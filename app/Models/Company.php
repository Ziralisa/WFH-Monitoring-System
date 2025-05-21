<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $table = 'companies';

        protected $fillable = [
            'company_name',
            'registration_no',
            'address',
            'contact_email',
            'contact_phone',
        ];

        protected $hidden = [];
    
        protected $casts = [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];

        public function users()
        {
            return $this->hasMany(User::class);
        }
}
