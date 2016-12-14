<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail;
use App\Thread;
use App\Draft;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Jobs\sendEmail;
use Log;

class DraftController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }
    public function index()
    {
      $user = Auth::id();
      $draftMails = Draft::where('user', $user)->get()->toArray();

      return view('draft', ['draftMails' => $draftMails]);
    }

    public function openDraft($id)
    {
      $user = Auth::id();
      $draftDetails = Draft::with('user')->where('user', $user)->where('id', $id)->get()->toArray();

      return view('individualDraft', ['draftDetails' => $draftDetails]);
    }
    public function sendMail(Request $request)
    {
      $sender = Auth::id();
      $id = $request->input('id');
      $recipients = $request->input('recipients');

      $draft = Draft::where('id', $id)->where('user', $sender)->first()->toArray();
      $thread = new Thread;
      $thread->name = $draft['text'];
      $thread->save();

      $mail = Mail::updateOrCreate(
        ['user' => $sender, 'text' => $draft['text'], 'body' => $draft['body'], 'thread' => $thread['id']],
        ['child_of' => null, 'sender_status' => 2, 'attachment' => $draft['attachment']]
      );

      for ($i=0; $i < count($recipients); $i++) {
        Log::info("Queue for sending mails to recipients starts");
        $user = User::where('email', $recipients[$i])->value('id');
        $this->dispatch(new sendEmail($user, $mail));
        Log::info("Request ends");
      }
      Draft::where('id', $id)->delete();
    }
    
    public function discardDraft(Request $request)
    {
      $id = $request->input('id');
      Draft::where('id', $id)->delete();
    }
}
