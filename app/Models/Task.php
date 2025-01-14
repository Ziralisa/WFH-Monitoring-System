<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
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
    
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

   // In Task.php model

public function sprints()
{
    return $this->belongsToMany(Sprint::class, 'sprint_task', 'task_id', 'sprint_id');
}


}
