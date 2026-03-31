<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
/*for log activities*/
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Banner extends Model
{
    use HasTranslations, LogsActivity;

    protected $fillable = ['title', 'description', 'image_path', 'link_url', 'is_active', 'sort_order'];

    public array $translatable = ['title', 'description'];

    protected $casts = [
        // REMOVE title and description from here
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()            // Automatically logs all fields in $fillable
            ->logOnlyDirty()          // Only records a log if something actually changed
            ->dontSubmitEmptyLogs()   // Prevents logging if no changes were made
            ->useLogName('banner');     // Groups these logs under 'post' in the DB
    }
}