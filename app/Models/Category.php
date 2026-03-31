<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations; // Ensure this package is installed

class Category extends Model
{
    use HasTranslations;

    protected $fillable = [
        'name',
        'slug',
    ];

    /**
     * Define which attributes should be translatable.
     * This allows name.en and name.dv to work seamlessly.
     */
    public array $translatable = ['name'];

    /**
     * Relationship: A category can have many posts.
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}