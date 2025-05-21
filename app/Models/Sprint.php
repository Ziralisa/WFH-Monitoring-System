<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sprint extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'desc',
        'startdate',
        'enddate',
        'project_id',
    ];

public function tasks()
{
    return $this->belongsToMany(Task::class, 'sprint_task', 'sprint_id', 'task_id');
}

public function project()
    {
        return $this->belongsTo(Project::class);
    }

 public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
