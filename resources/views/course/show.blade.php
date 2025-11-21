@extends('layouts.app')

@section('title', 'Curso ' . $course->name)

@section('content')

<div class="p-0" x-data="{ openCreate: false, openEdit: false, student: {id:null, grade:null, status:'Pendiente'} }" x-cloak>

    <style>
        [x-cloak] { display: none !important; }
    </style>

    <!-- Encabezado -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-5 p-6 bg-white rounded-md shadow-md">
        <div>
            <h1 class="text-3xl font-bold text-gray-800 font-[Kumbh_Sans]">Curso: {{ $course->name }}</h1>
            <p class="text-base font-semibold text-gray-800 mt-1">
                Profesor asignado: <span class="font-bold">{{ $course->teacher ? $course->teacher->name : 'Sin asignar' }}</span>
            </p>
        </div>

        <button @click="openCreate = true"
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
                Total estudiantes: <span class="font-bold">{{ $course->students->count() }}</span>
            </span>
        </div>

        <div class="relative w-full max-w-full sm:max-w-sm">
            <input type="text" placeholder="Buscar estudiante..."
                class="w-full p-2.5 pl-10 border border-gray-300 rounded-md focus:ring-[#0B0641] focus:border-[#0B0641] text-sm text-gray-600 font-normal">
            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-gray-500"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.197 5.197a7.5 7.5 0 0010.606 10.606z" />
            </svg>
        </div>
    </div>

    <!-- Tabla -->
    <div class="bg-white rounded-md shadow-md overflow-hidden mb-10">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr class="text-left">
                        <th class="px-3 py-3 text-xs font-bold text-black uppercase tracking-wider">DNI</th>
                        <th class="px-3 py-3 text-xs font-bold text-black uppercase tracking-wider">Nombre</th>
                        <th class="px-3 py-3 text-xs font-bold text-black uppercase tracking-wider">Número</th>
                        <th class="px-3 py-3 text-xs font-bold text-black uppercase tracking-wider">Ciclo</th>
                        <th class="px-3 py-3 text-xs font-bold text-black uppercase tracking-wider">Correo</th>
                        <th class="px-3 py-3 text-xs font-bold text-black uppercase tracking-wider">Inscrito</th>
                        <th class="px-3 py-3 text-xs font-bold text-black uppercase tracking-wider">Nota</th>
                        <th class="px-3 py-3 text-xs font-bold text-black uppercase tracking-wider">Estado</th>
                        <th class="px-3 py-3 text-xs font-bold text-black uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($course->students as $student)
                        @php
                            $is_active = $student->pivot->status === 'Aprobado';
                        @endphp
                        <tr>
                            <td class="px-3 py-4 whitespace-nowrap text-xs text-gray-900">{{ $student->dni }}</td>
                            <td class="px-3 py-4 whitespace-nowrap text-xs text-gray-900">{{ $student->name }}</td>
                            <td class="px-3 py-4 whitespace-nowrap text-xs text-gray-900">{{ $student->phone }}</td>
                            <td class="px-3 py-4 whitespace-nowrap text-xs text-gray-900">{{ $student->ciclo }}</td>
                            <td class="px-3 py-4 whitespace-nowrap text-xs text-gray-900">{{ $student->email }}</td>
                            <td class="px-3 py-4 whitespace-nowrap text-xs text-gray-900">{{ $student->pivot->registration_date }}</td>
                            <td class="px-3 py-4 whitespace-nowrap text-xs text-gray-900">
                                {{ $student->pivot->grade ?? '---' }}
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 inline-flex text-xs font-medium rounded-md {{ $is_active ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }}">
                                    {{ $student->pivot->status }}
                                </span>
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-xs font-medium">
                                <button @click="openEdit = true; student = {id:{{ $student->id }}, grade:'{{ $student->pivot->grade }}', status:'{{ $student->pivot->status }}'};"
                                    class="inline-flex items-center justify-center h-6 w-10 rounded-md"
                                    style="background-color: rgba(255,180,0,0.19);">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                        style="color: #FFB400;">
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

    <!-- Modal Crear Estudiante -->
    <div x-show="openCreate" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
        <div @click.away="openCreate = false" class="bg-white rounded-2xl shadow-xl sm:max-w-2xl w-full">
            <div class="px-8 pt-8 pb-4 flex justify-between items-center">
                <h3 class="text-2xl font-bold text-black font-[Kumbh_Sans]">Añadir Estudiante al Curso</h3>
                <button @click="openCreate = false" class="text-gray-400 hover:text-gray-600">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form action="{{ route('courses.enroll', $course->id) }}" method="POST" class="px-8 pb-8 space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-bold text-black mb-1">Seleccionar Estudiante</label>
                    <select name="student_id" required
                        class="w-full bg-[#EEEEEE] rounded-md py-3 px-4 text-sm text-gray-600 cursor-pointer focus:ring-2 focus:ring-[#0B0641]">
                        <option value="">-- Selecciona --</option>
                        @foreach ($students as $student)
                            <option value="{{ $student->id }}">{{ $student->dni }} - {{ $student->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold text-black mb-1">Nota</label>
                    <input type="number" name="grade" min="0" max="20"
                        class="w-full bg-[#EEEEEE] rounded-md py-3 px-4 text-sm text-gray-700 placeholder-gray-500 focus:ring-2 focus:ring-[#0B0641]"
                        placeholder="Ingrese nota (opcional)">
                </div>

                <div>
                    <label class="block text-sm font-bold text-black mb-1">Estado</label>
                    <select name="status" class="w-full bg-[#EEEEEE] rounded-md py-3 px-4 text-sm text-gray-600 cursor-pointer focus:ring-2 focus:ring-[#0B0641]">
                        <option value="Pendiente">Pendiente</option>
                        <option value="Aprobado">Aprobado</option>
                        <option value="Desaprobado">Desaprobado</option>
                    </select>
                </div>

                <div class="pt-4">
                    <button type="submit"
                        class="w-full py-3 text-white font-bold text-lg rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0B0641]"
                        style="background-color: #003366;">
                        Agregar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Editar Estudiante -->
    <div x-show="openEdit" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
        <div @click.away="openEdit = false" class="bg-white rounded-2xl shadow-xl sm:max-w-2xl w-full">
            <div class="px-8 pt-8 pb-4 flex justify-between items-center">
                <h3 class="text-2xl font-bold text-black font-[Kumbh_Sans]">Editar Datos</h3>
                <button @click="openEdit = false" class="text-gray-400 hover:text-gray-600">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form :action="`/courses/{{ $course->id }}/students/${student.id}`" method="POST" class="px-8 pb-8 space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-bold text-black mb-1">Nota</label>
                    <input type="number" name="grade" x-model="student.grade" min="0" max="20"
                        class="w-full bg-[#EEEEEE] rounded-md py-3 px-4 text-sm text-gray-700 placeholder-gray-500 focus:ring-2 focus:ring-[#0B0641]">
                </div>

                <div>
                    <label class="block text-sm font-bold text-black mb-1">Estado</label>
                    <select name="status" x-model="student.status"
                        class="w-full bg-[#EEEEEE] rounded-md py-3 px-4 text-sm text-gray-600 cursor-pointer focus:ring-2 focus:ring-[#0B0641]">
                        <option value="Pendiente">Pendiente</option>
                        <option value="Aprobado">Aprobado</option>
                        <option value="Desaprobado">Desaprobado</option>
                    </select>
                </div>

                <div class="pt-4">
                    <button type="submit"
                        class="w-full py-3 text-white font-bold text-lg rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0B0641]"
                        style="background-color: #003366;">
                        Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

@endsection
