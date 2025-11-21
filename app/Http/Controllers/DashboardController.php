<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Course;
use App\Models\Enrollment;

class DashboardController extends Controller
{
    public function index()
    {
        $totalStudents = Student::count();
        $totalCourses = Course::count();
        $totalTeachers = Teacher::count();

        $courses = Course::with(['students', 'teacher'])->get();

        return view('dashboard', compact(
            'totalStudents',
            'totalCourses',
            'totalTeachers',
            'courses'
        ));
    }

}
