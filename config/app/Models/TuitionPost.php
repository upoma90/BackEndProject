<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TuitionPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subject_id',
        'title',
        'description',
        'class_level',
        'location',
        'budget',
        'availability',
        'status', // pending, approved, rejected
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'budget' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function applications()
    {
        return $this->hasMany(TuitionApplication::class);
    }
} 