<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Recipient;
use App\Mail;
use App\Jobs\sendEmail;
use Log;
use App\Thread;

class InboxController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }
   public function index()
   {
        $received = [];
        $user = Auth::id();
        $received = Recipient::with('mail', 'status', 'recipient')->where('receipient', $user)->where('status', 1)->orderBy('created_at', 'desc')->get()->toArray();
        return view('inbox', ['received' => $received]);

   }
   public function sendReply(Request $request)
   {
     $input = $request->input('body');
     $toMail = $request->input('toMail');
     $subject = $request->input('subject');
     $sender = Auth::id();
    //  dd($subject);
     $receiver = Mail::with('user')->where('id', $toMail)->get()->toArray();

     $mail = new Mail;
     $mail->user = $sender;
     $mail->thread = $receiver[0]['thread'];
     $mail->child_of = $toMail;
     $mail->text = 'RE: '. $subject;
     $mail->body = $input;
     $mail->sender_status = 2;
     $mail->save();

     Log::info("Queue for sending mails to recipients starts");
     $user = DB::table('users')->where('email', $receiver[0]['user']['email'])->value('id');
     $this->dispatch(new sendEmail($user, $mail));
     Log::info("Request ends");
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
       $user = DB::table('users')->where('email', $toUsers[$i])->value('id');
       $this->dispatch(new sendEmail($user, $mail));
       Log::info("Request ends");
     }

   }

   public function openMail($id)
   {
     $user = Auth::id();
     $query = Recipient::with('mail.user', 'status', 'recipient')->where('receipient', $user)->where('id', $id)->where('status', 1);
     $mailDetails = $query->get()->toArray();
     if(strlen($mailDetails[0]['mail']['attachment']) != null){
       $mailDetails[0]['mail']['attachment'] = base64_decode($mailDetails[0]['mail']['attachment']);
     }
     $children = Mail::with('user')->where('thread', $mailDetails[0]['mail']['thread'])->where('created_at', '<', $mailDetails[0]['created_at'])->get()->toArray();
     if(!empty($children)){
       for ($i=0; $i <count($children); $i++) {
         if (strlen($children[$i]['attachment']) != 0) {
           $children[$i]['attachment'] = base64_decode($children[$i]['attachment']);
         }
       }
     }
     $query->update(['isRead' => true]);
     return view('individualMail', ['mailDetails'=>$mailDetails, 'children' => $children]);
   }
   public function trashReceivedMail(Request $request)
   {
     $mailId = $request->input("id");
     $user = Auth::id();
     Recipient::where('mail', $mailId)->where('receipient', $user)->update(['status' => 4]);
   }
}
