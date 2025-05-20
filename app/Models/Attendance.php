<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'clock_in',
        'clock_out',
        'clock_in_points',
        'clock_out_points',
        'working_hours_points',
        'total_points', 
    ];
    protected $casts = [
        'clock_in' => 'datetime',    // Automatically cast to Carbon instance
        'clock_out' => 'datetime',   // Automatically cast to Carbon instance
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
