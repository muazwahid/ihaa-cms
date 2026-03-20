<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasTranslations;

    protected $fillable = [
        'title', 'content', 'slug', 'category', 
        'featured_image', 'is_featured', 'show_sidebar', 
        'sidebar_config', 'status'
    ];

    public $translatable = ['title', 'content'];

    protected $casts = [
        'title' => 'array',
        'content' => 'array',
        'sidebar_config' => 'array',
        'is_featured' => 'boolean',
        'show_sidebar' => 'boolean',
    ];

    // Automatically generate slug from English title if not provided
    protected static function boot()
    {
        parent::boot();
        static::saving(function ($post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->getTranslation('title', 'en'));
            }
        });
    }
}