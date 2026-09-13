<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrayerRequest extends Model
{
    public $timestamps = false;
    protected $dates = ['created_at'];

    protected $fillable = [
        'user_id', 'requester_name', 'title', 'request', 'is_anonymous', 'status'
    ];
}
