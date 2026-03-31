<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Download extends Model
{
    // Explicitly point to your 'downloads' table
    protected $table = 'downloads';
    public array $translatable = ['title'];
    protected $casts = [
        'title' => 'array',
        'is_active' => 'boolean',
    ];

    // Ensure all fields are fillable for Filament to save them
    protected $fillable = [
        'title',
        'category',
        'file_path',
        'is_active',
        'sort_order',
    ];
}