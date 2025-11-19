<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Validation\Rule;
use App\Models\Course;
use App\Models\Enrollment; // Aunque no lo usaremos directamente, es bueno tenerlo

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::orderBy('name')->paginate(10);
        $courses = Course::all();

        return view('students.index', compact('students', 'courses'));
    }

    public function create()
    {
        return view('students.create');
    }

    /**
     * Almacena un nuevo estudiante y crea su matrícula inicial.
     */
    public function store(Request $request)
    {
        // 1. Añadimos validación para el course_id y su existencia
        $request->validate([
            'dni' => ['required', 'string', 'max:15', 'unique:students,dni'],
            'name' => 'required|string|max:100',
            'phone' => 'nullable|string|max:15',
            'email' => 'required|email|max:100|unique:students,email',
            'ciclo' => 'required|integer|min:1',
            'status' => 'required|string|max:20',
            'course_id' => 'required|exists:courses,id', // ¡Validación crucial!
        ]);

        // 2. Crear el estudiante
        $student = Student::create($request->except('course_id')); // Excluimos course_id del create del Student

        // 3. Crear la matrícula (Enrollment)
        $courseId = $request->input('course_id');
        $student->courses()->attach($courseId, [
            // Definimos los campos extra de la tabla pivot 'enrollments'
            'status' => 'Matriculado',
            'registration_date' => now(),
        ]);

        return redirect()->route('students.index')
            ->with('success', 'Estudiante y matrícula registrados exitosamente.');
    }


    public function show(Student $student)
    {
        return view('students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'dni' => ['required', 'string', 'max:15', Rule::unique('students', 'dni')->ignore($student)],
            'name' => 'required|string|max:100',
            'phone' => 'nullable|string|max:15',
            'email' => ['required', 'email', 'max:100', Rule::unique('students', 'email')->ignore($student)],
            'ciclo' => 'required|integer|min:1',
            'status' => 'required|string|max:20',

            // ✔ Validamos el curso
            'course_id' => 'required|exists:courses,id',
        ]);

        $student->update($request->except('course_id'));

        $courseId = $request->input('course_id');

        $student->courses()->sync([
            $courseId => [
                'status' => 'Matriculado',
                'registration_date' => now(),
            ]
        ]);

        return redirect()->route('students.index')
            ->with('success', 'Datos del estudiante actualizados exitosamente.');
    }

    /**
     * Elimina el estudiante y sus matrículas asociadas.
     */
    public function destroy(Student $student)
    {
        // Opcional: Si quieres desmatricular de todos los cursos antes de eliminar:
        // $student->courses()->detach(); 

        $student->delete();

        return redirect()->route('students.index')
            ->with('success', 'Estudiante eliminado exitosamente.');
    }
}