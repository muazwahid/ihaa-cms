<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Banner extends Model
{
    use HasTranslations;

    protected $fillable = ['title', 'description', 'image_path', 'link_url', 'is_active', 'sort_order'];

    public array $translatable = ['title', 'description'];

    protected $casts = [
        // REMOVE title and description from here
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];
}