<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail;
use App\Recipient;
use Illuminate\Support\Facades\Auth;

class TrashController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }
    public function index()
    {
      $user = Auth::id();
      $trashSent = Mail::where('sender_status', 4)->where('user', $user)->orderBy('created_at', 'desc')->get()->toArray();
      $trashReceived = Recipient::with('mail', 'status', 'recipient')->where('status', 4)->orderBy('created_at', 'desc')->where('receipient', $user)->get()->toArray();

      return view('trash', ['trashReceived' => $trashReceived, 'trashSent' => $trashSent]);
    }
}
