<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'dni',
        'name',
        'phone',
        'email',
        'ciclo',
        'status',
    ];

    /**
     * Define la relación Muchos a Muchos con Course a través de la tabla 'enrollments'.
     * Esto permite obtener el curso asociado al estudiante.
     */
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'enrollments', 'fk_student', 'fk_course')
            ->withPivot('status', 'registration_date')
            ->withTimestamps();
    }

}