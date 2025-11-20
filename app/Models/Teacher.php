<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'dni',
        'name',
        'phone',
        'email',
        'status',
    ];


    public function courses()
    {
        return $this->hasMany(Course::class, 'fk_teacher');
    }


    public function tuitionsProcessed()
    {
        return $this->hasMany(Tuition::class, 'fk_teacher_processed');
    }
}