@extends('layouts.app')

@section('title', 'Curso ' . $course->name)

@section('content')

<div class="p-0">

    <!-- Encabezado -->
    <div
        class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-5 p-6 bg-white rounded-md shadow-md">
        <div>
            <h1 class="text-3xl font-bold text-gray-800 font-[Kumbh_Sans]">
                Curso: {{ $course->name }}
            </h1>

            <p class="text-base font-semibold text-gray-800 mt-1">
                Profesor asignado:
                <span class="font-bold">
                    {{ $course->teacher ? $course->teacher->name : 'Sin asignar' }}
                </span>
            </p>
        </div>

        <button onclick="openModal()"
            class="mt-4 sm:mt-0 inline-flex items-center px-4 py-3 rounded-md shadow-sm text-sm font-semibold text-white w-full sm:w-auto justify-center"
            style="background-color: #509BDB;">
            Agregar Estudiante
        </button>
    </div>

    <!-- Barra herramientas -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center space-y-4 sm:space-y-0 sm:space-x-4 mb-5">

        <div class="text-gray-700 w-full sm:w-auto">
            <span class="font-medium px-4 py-2 rounded-md text-white block text-center sm:inline-block"
                style="background: linear-gradient(90deg, #2F0113 0%, #0B0641 100%);">
                Total de estudiantes:
                <span class="font-bold">{{ $course->students->count() }}</span>
            </span>
        </div>

        <div class="relative w-full max-w-full sm:max-w-sm">
            <input type="text" placeholder="Buscar estudiante por DNI"
                class="w-full p-2.5 pl-10 border border-gray-300 rounded-md focus:ring-[#0B0641] focus:border-[#0B0641] text-sm text-gray-600 font-normal">
            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-gray-500"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.197 5.197a7.5 7.5 0 0010.606 10.606z" />
            </svg>
        </div>

    </div>

    <!-- TABLA -->
    <div class="bg-white rounded-md shadow-md overflow-hidden mb-10">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr class="text-left">
                        <th class="px-3 py-3 text-xs font-bold text-black uppercase tracking-wider">DNI</th>
                        <th class="px-3 py-3 text-xs font-bold text-black uppercase tracking-wider">Nombres</th>
                        <th class="px-3 py-3 text-xs font-bold text-black uppercase tracking-wider">Número</th>
                        <th class="px-3 py-3 text-xs font-bold text-black uppercase tracking-wider">Ciclo</th>
                        <th class="px-3 py-3 text-xs font-bold text-black uppercase tracking-wider">Correo</th>
                        <th class="px-3 py-3 text-xs font-bold text-black uppercase tracking-wider">Fecha Inscrito</th>
                        <th class="px-3 py-3 text-xs font-bold text-black uppercase tracking-wider">Nota</th>
                        <th class="px-3 py-3 text-xs font-bold text-black uppercase tracking-wider">Estado</th>
                    </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200">

                    @foreach ($course->students as $student)
                        <tr>
                            <td class="px-3 py-4 text-xs text-gray-900">{{ $student->dni }}</td>
                            <td class="px-3 py-4 text-xs text-gray-900">{{ $student->name }}</td>
                            <td class="px-3 py-4 text-xs text-gray-900">{{ $student->phone }}</td>
                            <td class="px-3 py-4 text-xs text-gray-900">{{ $student->cycle }}</td>
                            <td class="px-3 py-4 text-xs text-gray-900">{{ $student->email }}</td>

                            <td class="px-3 py-4 text-xs text-gray-900">
                                {{ $student->pivot->registration_date ?? '---' }}
                            </td>

                            <td class="px-3 py-4 text-xs">
                                <span class="px-3 py-1 rounded-md font-semibold text-white" style="background:#166EC0;">
                                    {{ $student->pivot->grade ?? '---' }}
                                </span>
                            </td>

                            <td class="px-3 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 inline-flex text-xs font-medium rounded-md"
                                    style="background:#16C098; color:white;">
                                    {{ $student->pivot->status ?? 'Matriculado' }}
                                </span>
                            </td>
                        </tr>
                    @endforeach

                </tbody>

            </table>
        </div>
    </div>
</div>



<div id="createStudentModal"
    class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">

    <div class="bg-white w-full max-w-md p-6 rounded-xl shadow-xl relative animate-fadeIn">

        <h2 class="text-xl font-bold mb-4">Agregar estudiante al curso</h2>

        <button onclick="closeModal()" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-2xl">
            &times;
        </button>

        @if(session('success'))
            <p class="text-green-600 mb-3">{{ session('success') }}</p>
        @endif

        @if(session('error'))
            <p class="text-red-600 mb-3">{{ session('error') }}</p>
        @endif

        <form action="{{ route('courses.enroll', $course->id) }}" method="POST">
            @csrf

            <label class="block font-semibold mb-1">Seleccionar estudiante:</label>
            <select name="student_id" class="w-full border p-2 rounded mb-3" required>
                <option value="">-- Selecciona un estudiante --</option>

                @foreach ($students as $student)
                    <option value="{{ $student->id }}">
                        {{ $student->dni }} - {{ $student->name }}
                    </option>
                @endforeach
            </select>

            <label class="block font-semibold mb-1">Nota:</label>
            <input type="number" name="grade" class="w-full border p-2 rounded mb-3"
                   placeholder="Ingrese nota (opcional)" min="0" max="20">

            <label class="block font-semibold mb-1">Estado:</label>
            <select name="status" class="w-full border p-2 rounded mb-3">
                <option value="Matriculado">Matriculado</option>
                <option value="Aprobado">Aprobado</option>
                <option value="Desaprobado">Desaprobado</option>
            </select>

            <button class="bg-blue-700 hover:bg-blue-800 text-white px-4 py-2 rounded-lg w-full">
                Agregar estudiante
            </button>

        </form>
    </div>
</div>

<style>
    .animate-fadeIn {
        animation: fadeIn 0.2s ease-in-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: scale(0.95); }
        to   { opacity: 1; transform: scale(1); }
    }
</style>

<script>
    function openModal() {
        document.getElementById('createStudentModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('createStudentModal').classList.add('hidden');
    }
</script>

@endsection
