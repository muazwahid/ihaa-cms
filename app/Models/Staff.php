<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
// Use Spatie if your Staff model also has translatable fields
use Spatie\Translatable\HasTranslations; 

class Staff extends Model
{
    use HasTranslations;

    public $translatable = ['name', 'designation', 'responsibility'];

    protected $casts = [
    'is_active' => 'boolean',
    'joined_at' => 'date',   // Ensures Laravel treats this as a Carbon instance
    'resigned_at' => 'date',
    ];
protected $fillable = [
        'name',
        'designation',
        'responsibility',
        'staff_category_id', // Ensure this is in fillable
        'email',
        'contact_num',
        'photo',
        'sort_order',
        'is_active',
        'joined_at',
        'resigned_at',
    ];

    /**
     * Get the category that owns the staff member.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(StaffCategory::class, 'staff_category_id');
    }
}