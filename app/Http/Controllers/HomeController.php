<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Mail;
use App\Draft;
use App\Jobs\sendEmail;
use Log;
use App\Thread;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('compose');
    }

    public function sendMail(Request $request)
    {
      $body = $request->input('body');
      $recipients = $request->input('recipients');
      $sender = Auth::id();
      $subject = $request->input('subject');
      $attachment = $request->input('attachment');
      $filedata = '';

      if($attachment != null){
        $dataIndex = stripos($attachment, 'base64') + 7;
        $filedata = substr($attachment, $dataIndex, strlen($attachment));
        $filedata = base64_encode($filedata);
      }

      $thread = new Thread;
      $thread->name = $subject;
      $thread->save();

      $mail = Mail::updateOrCreate(
        ['user' => $sender, 'text' => $subject, 'body' => $body, 'thread' => $thread['id']],
        ['child_of' => null, 'sender_status' => 2, 'attachment' => $filedata]
      );


      for ($i=0; $i < count($recipients); $i++) {
        Log::info("Queue for sending mails to recipients starts");
        $user = DB::table('users')->where('email', $recipients[$i])->value('id');
        $this->dispatch(new sendEmail($user, $mail));
        Log::info("Request ends");
      }
    }
    public function saveAsDraft(Request $request)
    {
      $body = $request->input('body');
      $recipients = $request->input('recipients');
      $sender = Auth::id();
      $subject = $request->input('subject');
      $attachment = $request->input('attachment');
      $filedata = '';

      if($attachment != null){
        $dataIndex = stripos($attachment, 'base64') + 7;
        $filedata = substr($attachment, $dataIndex, strlen($attachment));
      }

      $draft = Draft::updateOrCreate(
        ['user' => $sender],
        ['text' => $subject, 'body' => $body, 'attachment' => $filedata]
      );
    }
}
