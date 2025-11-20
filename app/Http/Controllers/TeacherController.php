<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\Course;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::with('courses')->paginate(10);

        // Todos los cursos (asignados o no)
        $courses = Course::with('teacher')->get();

        return view('teachers.index', compact('teachers', 'courses'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'dni' => 'required|min:8|max:15|unique:teachers,dni',
            'name' => 'required|string|max:100',
            'phone' => 'nullable|string|max:15',
            'email' => 'required|email|max:100|unique:teachers,email',
            'status' => 'required|in:Activo,Inactivo',
            'courses' => 'nullable|array'
        ]);

        $teacher = Teacher::create($request->only([
            'dni',
            'name',
            'phone',
            'email',
            'status'
        ]));

        // Asignar cursos libres
        if ($request->has('courses')) {
            Course::whereIn('id', $request->courses)
                ->update(['fk_teacher' => $teacher->id]);
        }

        return redirect()->back()->with('success', 'Profesor registrado correctamente.');
    }

    public function update(Request $request, $id)
    {
        $teacher = Teacher::findOrFail($id);

        $request->validate([
            'dni' => 'required|min:8|max:15|unique:teachers,dni,' . $teacher->id,
            'name' => 'required|string|max:100',
            'phone' => 'nullable|string|max:15',
            'email' => 'required|email|max:100|unique:teachers,email,' . $teacher->id,
            'status' => 'required|in:Activo,Inactivo',
            'courses' => 'nullable|array'
        ]);

        // Actualizamos profesor
        $teacher->update($request->only([
            'dni',
            'name',
            'phone',
            'email',
            'status'
        ]));

        // Quitamos cursos previos
        Course::where('fk_teacher', $teacher->id)->update(['fk_teacher' => null]);

        // Asignamos nuevos cursos
        if ($request->has('courses')) {
            Course::whereIn('id', $request->courses)
                ->update(['fk_teacher' => $teacher->id]);
        }

        return redirect()->back()->with('success', 'Profesor actualizado correctamente.');
    }

    public function destroy($id)
    {
        try {
            Teacher::findOrFail($id)->delete();
            return redirect()->back()->with('success', 'Profesor eliminado.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'No se puede eliminar este profesor porque tiene registros asociados.');
        }
    }
}
