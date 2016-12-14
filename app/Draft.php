<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Draft extends Model
{
    protected $table = 'drafts';
    protected $fillable = [
        'user', 'text', 'body', 'attachment'
    ];

    public function user(){
      return $this->belongsTo('App\User', 'user', 'id');
    }
}
