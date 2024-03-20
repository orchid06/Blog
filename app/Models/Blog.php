<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Blog extends Model
{
    use HasFactory;
    protected $table   = 'blogs';
    protected $guarded =[];
    protected $casts = ['gallery_image' => 'object'];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($blog) {
            $blog->slug = Str::slug($blog->title);
        });
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function Dislikes()
    {
        return $this->hasMany(Dislike::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

}
