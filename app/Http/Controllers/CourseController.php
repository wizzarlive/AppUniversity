<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Teacher;
use Illuminate\Http\Request;

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
}
