<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $table = 'user_locations';
    protected $fillable = [
        'user_id', 'latitude', 'longitude', 'type', 'status', 'clockinpoints', 'workinghourpoints', 'total_points'
    ];

}
