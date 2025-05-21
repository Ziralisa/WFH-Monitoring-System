<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'role', 'token', 'expires_at','company_id'
    ];

    protected $casts = [
        'expires_at'=> 'datetime',
    ];
}
