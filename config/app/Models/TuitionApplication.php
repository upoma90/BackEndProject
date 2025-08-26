<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TuitionApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'tuition_post_id',
        'tutor_id',
        'message',
        'proposed_rate',
        'status', // pending, accepted, rejected
    ];

    protected $casts = [
        'proposed_rate' => 'decimal:2',
    ];

    public function tuitionPost()
    {
        return $this->belongsTo(TuitionPost::class);
    }

    public function tutor()
    {
        return $this->belongsTo(User::class, 'tutor_id');
    }
} 