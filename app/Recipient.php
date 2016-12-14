<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recipient extends Model
{
    protected $table = 'recepients';

    public function status() {
      return $this->belongsTo('App\Status', 'status', 'id');
    }

    public function recipient(){
      return $this->belongsTo('App\User', 'receipient', 'id');
    }

    public function mail(){
      return $this->belongsTo('App\Mail', 'mail', 'id');
    }
}
