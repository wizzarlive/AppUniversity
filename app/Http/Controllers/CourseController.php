<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Teacher;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Enrollment;
class CourseController extends Controller
{

    public function index()
    {
        $courses = Course::with('teacher')->orderBy('id', 'DESC')->get();
        return view('course.index', compact('courses'));
    }

    public function create()
    {
        $teachers = Teacher::all();
        return view('courses.create', compact('teachers'));
    }

    public function show(Course $course)
    {
        $students = Student::orderBy('name')->get();

        return view('course.show', compact('course', 'students'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:courses,name',
            'fk_teacher' => 'nullable|exists:teachers,id',
        ]);

        Course::create($request->all());

        return redirect()->route('courses.index')->with('success', 'Curso creado correctamente.');
    }


    public function edit(Course $course)
    {
        $teachers = Teacher::all();
        return view('courses.edit', compact('course', 'teachers'));
    }


    public function update(Request $request, Course $course)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:courses,name,' . $course->id,
            'fk_teacher' => 'nullable|exists:teachers,id',
        ]);

        $course->update($request->all());

        return redirect()->route('courses.index')->with('success', 'Curso actualizado.');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('courses.index')->with('success', 'Curso eliminado.');
    }



    public function enrollStudent(Request $request, Course $course)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'grade' => 'nullable|numeric|min:0|max:20',
            'status' => 'required|string',
        ]);

        // Evitar duplicados
        if ($course->students()->where('students.id', $request->student_id)->exists()) {
            return back()->with('error', 'El estudiante ya está inscrito en este curso.');
        }

        // Inscribir
        $course->students()->attach($request->student_id, [
            'grade' => $request->grade,
            'status' => $request->status,
            'registration_date' => now(),
        ]);

        return back()->with('success', 'Estudiante inscrito correctamente.');
    }
}
