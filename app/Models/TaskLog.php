<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'status',
        'title',
        'user_id',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id'); 
    }
    

}
