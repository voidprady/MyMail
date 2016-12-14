<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Recipient;
use App\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;

class sendEmail implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $mail;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user, Mail $mail)
    {
        $this->user = $user;
        $this->mail = $mail;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
      $recipient = new Recipient();

      $recipient->receipient = $this->user;
      $recipient->mail = $this->mail->id;
      $recipient->status = 1;
      $recipient->isRead = false;
      $recipient->save();
    }

    public function failed() {

    }
}
