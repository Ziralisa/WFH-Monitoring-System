<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

<<<<<<< HEAD
    protected $fillable = ['name', 'description'];
=======
    protected $fillable = ['name', 'description', 'start_date', 'end_date'];
>>>>>>> a2f031c (initial commit)

    // A project has many tasks
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
    
}
<<<<<<< HEAD
=======



>>>>>>> a2f031c (initial commit)
