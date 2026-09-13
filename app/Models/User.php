<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'phone', 'role', 'country', 'password', 'avatar', 'is_verified'
    ];

    protected $hidden = [
        'password',
    ];

    public function pastorProfile()
    {
        return $this->hasOne(PastorProfile::class, 'user_id');
    }

    public function teachings()
    {
        return $this->hasMany(Teaching::class, 'pastor_id');
    }

    public function isPastor()
    {
        return $this->role === 'pastor';
    }

    public function isAdmin()
    {
        return $this->role === 'super_admin';
    }
}
