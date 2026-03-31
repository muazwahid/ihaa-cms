<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class StaffCategory extends Model
{
    use HasTranslations;

    protected $fillable = ['name', 'slug', 'sort_order'];
    public $translatable = ['name'];

    public function staff()
    {
        return $this->hasMany(Staff::class);
    }
}