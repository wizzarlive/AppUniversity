<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tuition extends Model
{
    use HasFactory;

    protected $fillable = [
        'period',
        'status',
        'registration_date',
        'fk_student',
        'fk_teacher_processed',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'fk_student');
    }


    public function processor()
    {
        return $this->belongsTo(Teacher::class, 'fk_teacher_processed'); 
    }
}