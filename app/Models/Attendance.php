<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'clock_in', 'clock_out', 'clock_in_points', 'clock_out_points', 'work_hour_points'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
