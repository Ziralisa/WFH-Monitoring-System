<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyTask extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'task_id', 'status'];
    
    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
