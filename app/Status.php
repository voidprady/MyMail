<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    //
    protected $table = 'available_message_status';

    protected $fillable = [
        'status'
    ];
}
