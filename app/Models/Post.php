<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
/*for log activities*/
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Post extends Model
{
    use HasTranslations,LogsActivity;

    protected $fillable = [
        'title', 'content', 'slug', 'category_id', 
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
    /**
     * Configure the Activity Log options
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()            // Automatically logs all fields in $fillable
            ->logOnlyDirty()          // Only records a log if something actually changed
            ->dontSubmitEmptyLogs()   // Prevents logging if no changes were made
            ->useLogName('post');     // Groups these logs under 'post' in the DB
    }
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
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