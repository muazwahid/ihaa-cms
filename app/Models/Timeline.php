<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Add this import
use Spatie\Translatable\HasTranslations;

class Timeline extends Model
{
    use HasTranslations;

    public $translatable = ['title', 'description'];

    protected $fillable = [
        'title',
        'description',
        'event_date',
        'category',
        'project_id',
        'achievement_id', // Make sure this is in your fillable array
        'status',
        'image',
        'icon',
        'is_active',
        'sort_order',
    ];
    protected $casts = [
    'event_date' => 'date',
];
    /**
     * Relationship to the Project model
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Relationship to the Achievement model
     */
    public function achievement(): BelongsTo
    {
        return $this->belongsTo(Achievement::class, 'achievement_id');
    }
}