<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory, HasTranslations;

    /**
     * The attributes that are translatable using Spatie Translatable.
     */
    public array $translatable = [
        'title',
        'description',
        'venue',
    ];

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
        'slug',
        'description',
        'venue',
        'start_date',
        'end_date',
        'event_time',
        'photo',
        'featured_photo',
        'gallery_id',
        'is_featured',
        'news_generated',
        'status',
    ];

    /**
     * The attributes that should be cast to native types.
     * This ensures Filament's DatePicker and TimePicker work correctly.
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_featured' => 'boolean',
        'news_generated' => 'boolean',
        'title' => 'json',
        'description' => 'json',
        'venue' => 'json',
    ];

    /**
     * Relationship to the Gallery model.
     */
    public function gallery(): BelongsTo
    {
        return $this->belongsTo(Gallery::class);
    }

    /**
     * Scope to get only featured events for the homepage.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope to get only upcoming events.
     */
    public function scopeUpcoming($query)
    {
        return $query->where('start_date', '>=', now())
                     ->where('status', '!=', 'cancelled')
                     ->orderBy('start_date', 'asc');
    }
}