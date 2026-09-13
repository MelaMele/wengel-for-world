<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teaching extends Model
{
    protected $fillable = [
        'pastor_id', 'category_id', 'title', 'slug', 'type', 'media_url', 'content', 'views_count', 'is_featured'
    ];

    public function pastor()
    {
        return $this->belongsTo(User::class, 'pastor_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
