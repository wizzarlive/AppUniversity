<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'fk_teacher',
    ];


    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'fk_teacher');
    }


    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'FK_COURSE');
    }


    public function students()
    {
        return $this->belongsToMany(Student::class, 'enrollments', 'FK_COURSE', 'FK_STUDENT')
                    ->withPivot('grade', 'status', 'registration_date')
                    ->using(Enrollment::class);
    }
}