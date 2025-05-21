<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'start_date', 'end_date','company_id'];

    // A project has many tasks
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    
}



