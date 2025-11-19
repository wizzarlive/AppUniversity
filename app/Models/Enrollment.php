<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    protected $fillable = [
        'grade',
        'status',
        'registration_date',
        'fk_student',
        'fk_course',
    ];


    public function student()
    {
        return $this->belongsTo(Student::class, 'fk_student');
    }


    public function course()
    {
        return $this->belongsTo(Course::class, 'fk_course');
    }
}