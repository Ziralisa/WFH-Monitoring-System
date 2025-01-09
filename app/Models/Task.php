<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'sprint_id',
        'name',
        'task_status',
        'task_priority',
        'task_assign',
        'task_description',
    ];

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'task_assign');
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); // Assuming tasks are assigned to a user
    }
    

}
