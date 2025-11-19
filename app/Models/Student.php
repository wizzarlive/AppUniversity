<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'dni',
        'name',
        'phone',
        'ciclo',
        'email',
        'status',
    ];
    
    public function tuitions()
    {
        return $this->hasMany(Tuition::class, 'FK_STUDENT');
    }


    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'FK_STUDENT');
    }


    public function courses()
    {
        return $this->belongsToMany(Course::class, 'enrollments', 'FK_STUDENT', 'FK_COURSE')
                    ->withPivot('grade', 'status', 'registration_date')
                    ->using(Enrollment::class);
    }
}