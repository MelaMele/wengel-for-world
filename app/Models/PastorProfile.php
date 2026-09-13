<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PastorProfile extends Model
{
    protected $fillable = [
        'user_id', 'title', 'church_name', 'bio', 'cover_image', 'phone_for_counseling'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
