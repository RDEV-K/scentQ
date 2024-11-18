<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class MailSubscriber extends Model
{
    protected $guarded = ['id'];

    function getUnsubscribeUrlAttribute()
    {
        return URL::signedRoute('mail.unsubscribe', ['email' => $this->email]);
    }
}
