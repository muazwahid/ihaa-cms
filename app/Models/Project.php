<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Project extends Model
{
    use HasTranslations;

    protected $fillable = [
        'name', 
        'description', 
        'image_path', 
        'project_cost', 
        'date_started', 
        'date_ended', 
        'progress_percentage', 
        'status',
        'is_featured',
        'funded_by'
    ];

    public array $translatable = ['name','description'];

    protected $casts = [
        'project_cost' => 'decimal:2',
        'date_started' => 'date', // CRITICAL for DatePicker
        'date_ended' => 'date',
        'progress_percentage' => 'integer',
    ];
}