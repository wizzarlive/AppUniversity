<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tuition;
use App\Models\Student;
use App\Models\Teacher;

class TuitionController extends Controller
{
    public function index()
    {
        $tuitions = Tuition::with(['student', 'teacher'])->get();
        $students = Student::all();
        $periods = ['202025','202026','202027','202028']; // o genera dinámicamente
        $statuses = ['Matriculado', 'Pendiente'];

        return view('tuitions.index', compact('tuitions', 'students', 'periods', 'statuses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fk_student' => 'required|exists:students,id',
            'period' => 'required|string',
            'status' => 'required|string',
        ]);

        $tuition = Tuition::create([
            'fk_student' => $request->fk_student,
            'period' => $request->period,
            'status' => $request->status,
            'registration_date' => now()->format('Y-m-d'),
            'fk_teacher_processed' => auth()->id(), // usuario autenticado
        ]);

        return redirect()->route('tuitions.index')->with('success', 'Matrícula creada correctamente');
    }

    public function update(Request $request, Tuition $tuition)
    {
        $request->validate([
            'status' => 'required|string',
        ]);

        $tuition->update([
            'status' => $request->status,
        ]);

        // responder JSON para actualización live
        return response()->json([
            'id' => $tuition->id,
            'status' => $tuition->status,
        ]);
    }
}
