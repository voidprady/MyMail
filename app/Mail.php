<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mail extends Model
{
    //
    protected $table = 'user_mails';

    protected $fillable = [
        'user', 'thread', 'child_of', 'text', 'body', 'attachment', 'sender_status' 
    ];

    public function recipients(){
      return $this->hasMany('App\Recipient', 'mail', 'id');
    }

    public function user(){
      return $this->belongsTo('App\User', 'user', 'id');
    }
}
