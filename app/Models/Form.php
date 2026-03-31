<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'is_active',
    ];

    // Fix this: Casts MUST be a property, not a method
    protected $casts = [
        'content' => 'array',
        'is_active' => 'boolean',
    ];
}