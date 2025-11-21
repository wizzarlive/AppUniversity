@extends('layouts.app')

@section('title', 'Curso ' . $course->name)

@section('content')

<div class="p-0">

    <!-- ENCABEZADO -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-5 p-6 bg-white rounded-2xl shadow-lg">

        <div>
            <h1 class="text-3xl font-bold text-gray-900 font-[Kumbh_Sans]">
                Curso: {{ $course->name }}
            </h1>

            <p class="text-base font-semibold text-gray-700 mt-1">
                Profesor asignado:
                <span class="font-bold">
                    {{ $course->teacher ? $course->teacher->name : 'Sin asignar' }}
                </span>
            </p>
        </div>

        <button onclick="openModal()"
            class="mt-4 sm:mt-0 inline-flex items-center px-5 py-3 rounded-md text-sm font-semibold text-white shadow-md w-full sm:w-auto justify-center"
            style="background-color: #509BDB;">
            Agregar Estudiante
        </button>
    </div>

    <!-- BARRA HERRAMIENTAS -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center sm:space-x-4 mb-5">

        <div class="text-gray-700">
            <span class="font-semibold px-5 py-2 rounded-md text-white block text-center sm:inline-block"
                style="background: linear-gradient(90deg, #2F0113 0%, #0B0641 100%);">
                Total estudiantes: <span class="font-bold">{{ $course->students->count() }}</span>
            </span>
        </div>

        <div class="relative w-full sm:max-w-xs mt-4 sm:mt-0">
            <input type="text" placeholder="Buscar estudiante..."
                class="w-full p-2.5 pl-10 border border-gray-300 rounded-lg focus:ring-[#0B0641] focus:border-[#0B0641] text-sm text-gray-700 bg-[#EEEEEE]">
            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-500"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M21 21l-5.2-5.2m0 0A7.5 7.5 0 105.2 5.2a7.5 7.5 0 0010.6 10.6z" />
            </svg>
        </div>
    </div>

    <!-- TABLA -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-10">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-300">
                <thead class="bg-gray-100">
                    <tr class="text-left">
                        <th class="px-4 py-3 text-xs font-bold text-gray-700 uppercase">DNI</th>
                        <th class="px-4 py-3 text-xs font-bold text-gray-700 uppercase">Nombre</th>
                        <th class="px-4 py-3 text-xs font-bold text-gray-700 uppercase">Número</th>
                        <th class="px-4 py-3 text-xs font-bold text-gray-700 uppercase">Ciclo</th>
                        <th class="px-4 py-3 text-xs font-bold text-gray-700 uppercase">Correo</th>
                        <th class="px-4 py-3 text-xs font-bold text-gray-700 uppercase">Inscrito</th>
                        <th class="px-4 py-3 text-xs font-bold text-gray-700 uppercase">Nota</th>
                        <th class="px-4 py-3 text-xs font-bold text-gray-700 uppercase">Estado</th>
                        <th class="px-4 py-3 text-xs font-bold text-gray-700 uppercase">Acciones</th>
                    </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200">

                    @foreach ($course->students as $student)
                        <tr class="hover:bg-gray-50">

                            <td class="px-4 py-3 text-sm text-gray-800">{{ $student->dni }}</td>
                            <td class="px-4 py-3 text-sm text-gray-800">{{ $student->name }}</td>
                            <td class="px-4 py-3 text-sm text-gray-800">{{ $student->phone }}</td>
                            <td class="px-4 py-3 text-sm text-gray-800">{{ $student->ciclo }}</td>
                            <td class="px-4 py-3 text-sm text-gray-800">{{ $student->email }}</td>

                            <td class="px-4 py-3 text-sm text-gray-800">
                                {{ $student->pivot->registration_date }}
                            </td>

                            <td class="px-4 py-3">
                                <span class="px-3 py-1 rounded-lg font-semibold text-white text-sm"
                                    style="background: linear-gradient(90deg,#003f88,#005dc1);">
                                    {{ $student->pivot->grade ?? '---' }}
                                </span>
                            </td>

                            <td class="px-4 py-3">
                                <span class="px-3 py-1 rounded-lg text-xs font-semibold text-white"
                                    style="background: #16C098;">
                                    {{ $student->pivot->status }}
                                </span>
                            </td>

                            <td class="px-4 py-3">

                                <!-- BOTÓN EDITAR -->
                                <button
                                    onclick="openEditModal({{ $student->id }}, '{{ $student->pivot->grade }}', '{{ $student->pivot->status }}')"
                                    class="inline-flex items-center justify-center h-7 w-12 rounded-md"
                                    style="background-color: rgba(255,180,0,0.19);">

                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" style="color:#FFB400;">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.232 5.232z" />
                                    </svg>

                                </button>

                            </td>
                        </tr>
                    @endforeach

                </tbody>

            </table>
        </div>
    </div>
</div>


<!-- MODAL CREAR -->
<div id="createStudentModal"
    class="hidden fixed inset-0 bg-black/40 backdrop-blur-sm flex justify-center items-center z-50">

    <div class="bg-white w-full max-w-md p-6 rounded-2xl shadow-xl relative">

        <h2 class="text-2xl font-bold mb-4 font-[Kumbh_Sans] text-gray-900">Agregar Estudiante</h2>

        <button onclick="closeModal()" class="absolute top-3 right-3 text-gray-400 hover:text-gray-700 text-xl">✕</button>

        <form action="{{ route('courses.enroll', $course->id) }}" method="POST">
            @csrf

            <label class="block font-semibold mb-1 text-gray-800">Seleccionar estudiante:</label>
            <select name="student_id" class="w-full bg-[#EEEEEE] border p-3 rounded-md mb-3" required>
                <option value="">-- Selecciona --</option>

                @foreach ($students as $student)
                    <option value="{{ $student->id }}">
                        {{ $student->dni }} - {{ $student->name }}
                    </option>
                @endforeach
            </select>

            <label class="block font-semibold mb-1 text-gray-800">Nota:</label>
            <input type="number" name="grade" class="w-full bg-[#EEEEEE] border p-3 rounded-md mb-3"
                   placeholder="Ingrese nota (opcional)" min="0" max="20">

            <label class="block font-semibold mb-1 text-gray-800">Estado:</label>
            <select name="status" class="w-full bg-[#EEEEEE] border p-3 rounded-md mb-3">
                <option value="Matriculado">Matriculado</option>
                <option value="Aprobado">Aprobado</option>
                <option value="Desaprobado">Desaprobado</option>
            </select>

            <button class="w-full py-3 text-white font-bold rounded-lg shadow-md"
                style="background-color:#003366;">
                Agregar estudiante
            </button>
        </form>
    </div>
</div>


<!-- MODAL EDITAR -->
<div id="editStudentModal"
    class="hidden fixed inset-0 bg-black/40 backdrop-blur-sm flex justify-center items-center z-50">

    <div class="bg-white w-full max-w-md p-6 rounded-2xl shadow-xl relative">

        <h2 class="text-2xl font-bold mb-4 font-[Kumbh_Sans] text-gray-900">Editar Datos</h2>

        <button onclick="closeEditModal()" class="absolute top-3 right-3 text-gray-400 hover:text-gray-700 text-xl">✕</button>

        <form id="editForm" method="POST">
            @csrf
            @method('PUT')

            <label class="block font-semibold mb-1 text-gray-800">Nota:</label>
            <input type="number" id="edit_grade" name="grade"
                   class="w-full bg-[#EEEEEE] border p-3 rounded-md mb-3"
                   min="0" max="20">

            <label class="block font-semibold mb-1 text-gray-800">Estado:</label>
            <select id="edit_status" name="status"
                    class="w-full bg-[#EEEEEE] border p-3 rounded-md mb-3">
                <option value="Matriculado">Matriculado</option>
                <option value="Aprobado">Aprobado</option>
                <option value="Desaprobado">Desaprobado</option>
            </select>

            <button class="w-full py-3 text-white font-bold rounded-lg shadow-md"
                style="background-color:#003366;">
                Guardar cambios
            </button>
        </form>
    </div>
</div>


<script>
    function openModal() {
        document.getElementById('createStudentModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('createStudentModal').classList.add('hidden');
    }

    function openEditModal(id, grade, status) {
        document.getElementById('edit_grade').value = grade !== 'null' ? grade : '';
        document.getElementById('edit_status').value = status;
        document.getElementById('editForm').action = `/courses/{{ $course->id }}/students/${id}`;
        document.getElementById('editStudentModal').classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('editStudentModal').classList.add('hidden');
    }
</script>

@endsection
