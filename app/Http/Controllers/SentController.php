<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Recipient;
use App\Mail;
use App\Thread;
use App\User;
use App\Jobs\sendEmail;
use Log;

class SentController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }
    public function index()
    {
      $sent = [];
      $user = Auth::id();
      $sent = Mail::where('user', $user)->where('sender_status', 2)->orderBy('created_at', 'desc')->get()->toArray();
      return view('sent', ['sent' => $sent]);
    }
    public function sendReply(Request $request)
    {
      $input = $request->input('body');
      $toMail = $request->input('toMail');
      $subject = $request->input('subject');
      $sender = Auth::id();

      $receivers = Recipient::with('mail')->where('mail', $toMail)->get()->toArray();

      $mail = new Mail;
      $mail->user = $sender;
      $mail->thread = $receivers[0]['mail']['thread'];
      $mail->child_of = $toMail;
      $mail->text = 'RE: '. $subject;
      $mail->body = $input;
      $mail->sender_status = 2;
      $mail->save();

      for ($i=0; $i < count($receivers); $i++) {
        Log::info("Queue for sending mails to recipients starts");
        $this->dispatch(new sendEmail($receivers[$i]['receipient'], $mail));
        Log::info("Request ends");
      }
    }

    public function forwardMail(Request $request)
    {
      $input = $request->input('body');
      $toUsers = $request->input('toUsers');
      $subject = $request->input('subject');
      $toMail = $request->input('toMail');
      $sender = Auth::id();

      $receiver = Mail::with('user')->where('id', $toMail)->get()->toArray();

      $mail = new Mail;
      $mail->user = $sender;
      $mail->thread = $receiver[0]['thread'];
      $mail->child_of = $toMail;
      $mail->text = 'Fwd: '.$subject;
      $mail->body = $input;
      $mail->sender_status = 2;
      $mail->save();

      for ($i=0; $i < count($toUsers); $i++) {
        Log::info("Queue for sending mails to recipients starts");
        $user = User::where('email', $toUsers[$i])->value('id');
        $this->dispatch(new sendEmail($user, $mail));
        Log::info("Request ends");
      }

    }

    public function openMail($id)
    {
      $user = Auth::id();
      $mailDetails = Mail::with('user')->where('user', $user)->where('id', $id)->where('sender_status', 2)->get()->toArray();
      if (strlen($mailDetails[0]['attachment']) != 0) {
        $mailDetails[0]['attachment'] = base64_decode($mailDetails[0]['attachment']);
      }
      $children = Mail::with('user')->where('thread', $mailDetails[0]['thread'])->where('created_at', '<', $mailDetails[0]['created_at'])->get()->toArray();

      if(!empty($children)){
        for ($i=0; $i <count($children); $i++) {
          if (strlen($children[$i]['attachment']) != 0) {
            $children[$i]['attachment'] = base64_decode($children[$i]['attachment']);
          }
        }
      }

      return view('individualSentMail', ['mailDetails'=>$mailDetails, 'children' => $children]);
    }

    public function trashMail(Request $request)
    {
      $id = $request->input('id');
      Mail::where('id', $id)->update(["sender_status" => 4]);
    }
}
