@extends('layouts.app')

@section('title', 'Gestión de Matrículas')

@section('content')
<div class="p-0" x-data="{ openCreate: false, openEdit: false, tuition: {}, search: '' }" x-cloak>
    <style>
        [x-cloak]{display:none !important;}
    </style>

    <!-- Encabezado -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-5 p-6 bg-white rounded-md shadow-md">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Matrículas</h1>
            <p class="text-base font-semibold text-gray-800 mt-1">Apartado para gestionar las matrículas</p>
        </div>

        <button @click="openCreate = true"
            class="mt-4 sm:mt-0 inline-flex items-center px-4 py-3 rounded-md shadow-sm text-sm font-semibold text-white w-full sm:w-auto justify-center"
            style="background-color: #509BDB;">
            Agregar Matrícula
        </button>
    </div>

    <!-- Barra de herramientas: Total + Buscador -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center space-y-4 sm:space-y-0 sm:space-x-4 mb-5">
        <div class="text-gray-700 w-full sm:w-auto">
            <span class="font-medium px-4 py-2 rounded-md text-white block text-center sm:inline-block"
                style="background: linear-gradient(90deg, #2F0113 0%, #0B0641 100%);">
                Total de matrículas: <span class="font-bold">{{ $tuitions->count() }}</span>
            </span>
        </div>

        <div class="relative w-full max-w-full sm:max-w-sm">
            <input type="text" placeholder="Buscar matrícula por alumno" x-model="search"
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
                        <th class="px-3 py-3 text-xs font-bold text-black uppercase tracking-wider">ID</th>
                        <th class="px-3 py-3 text-xs font-bold text-black uppercase tracking-wider">Alumno</th>
                        <th class="px-3 py-3 text-xs font-bold text-black uppercase tracking-wider">Período</th>
                        <th class="px-3 py-3 text-xs font-bold text-black uppercase tracking-wider">Fecha</th>
                        <th class="px-3 py-3 text-xs font-bold text-black uppercase tracking-wider">Matriculado por</th>
                        <th class="px-3 py-3 text-xs font-bold text-black uppercase tracking-wider">Estado</th>
                        <th class="px-3 py-3 text-xs font-bold text-black uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200">
                    <template
                        x-for="t in {{ $tuitions->toJson() }}.filter(t => t.student.name.toLowerCase().includes(search.toLowerCase()))"
                        :key="t.id">
                        <tr :id="'tuition-' + t.id">
                            <td class="px-3 py-4 text-xs text-gray-900" x-text="t.id"></td>
                            <td class="px-3 py-4 text-xs text-gray-900" x-text="t.student.name"></td>
                            <td class="px-3 py-4 text-xs text-gray-900" x-text="t.period"></td>
                            <td class="px-3 py-4 text-xs text-gray-900" x-text="t.registration_date"></td>
                            <td class="px-3 py-4 text-xs text-gray-900" x-text="t.teacher?.name ?? 'No asignado'"></td>
                            <!-- Estado con colores -->
                            <td class="px-3 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 inline-flex text-xs font-medium rounded-md" :class="{
                                    'bg-gradient-to-r from-[#003f88] to-[#005dc1] text-white': t.status === 'Matriculado',
                                    'bg-gray-300 text-gray-800': t.status === 'Pendiente'
                                }" x-text="t.status">
                                </span>
                            </td>
                            <!-- Botón de editar estilo estudiantes -->
                            <td class="px-3 py-4 text-xs font-medium">
                                <button @click="tuition = t; openEdit = true"
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
                    </template>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Crear Matrícula -->
    <div x-show="openCreate" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div @click.away="openCreate = false" class="bg-white rounded-2xl shadow-xl sm:max-w-2xl w-full p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-bold">Agregar Matrícula</h2>
                <button @click="openCreate = false" class="text-gray-400 hover:text-gray-600">&times;</button>
            </div>

            <form method="POST" action="{{ route('tuitions.store') }}">
                @csrf

                <div class="mb-4">
                    <label class="block text-sm font-bold mb-1">Alumno</label>
                    <select name="fk_student" required class="w-full px-4 py-2 border rounded-lg">
                        <option value="">Seleccionar Alumno</option>
                        @foreach ($students as $s)
                            <option value="{{ $s->id }}">{{ $s->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-bold mb-1">Período</label>
                    <select name="period" required class="w-full px-4 py-2 border rounded-lg">
                        <option value="">Seleccionar Período</option>
                        @foreach ($periods as $p)
                            <option value="{{ $p }}">{{ $p }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-bold mb-1">Estado</label>
                    <select name="status" required class="w-full px-4 py-2 border rounded-lg">
                        @foreach ($statuses as $status)
                            <option value="{{ $status }}">{{ $status }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit"
                    class="w-full py-3 text-white font-bold text-lg rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0B0641]"
                    style="background-color: #003366;">
                    Crear Matrícula
                </button>
            </form>
        </div>
    </div>

    <!-- Modal Editar Matrícula -->
    <div x-show="openEdit" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div @click.away="openEdit = false" class="bg-white rounded-2xl shadow-xl sm:max-w-2xl w-full p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-bold">Editar Estado Matrícula</h2>
                <button @click="openEdit = false" class="text-gray-400 hover:text-gray-600">&times;</button>
            </div>

            <form @submit.prevent="
                fetch(`/tuitions/${tuition.id}`, {
                    method: 'PUT',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN':'{{ csrf_token() }}' },
                    body: JSON.stringify({status: tuition.status})
                })
                .then(res => res.json())
                .then(data => {
                    document.querySelector(`#tuition-${data.id} .status`).textContent = data.status;
                    openEdit = false;
                });
            ">
                <div class="mb-4">
                    <label class="block text-sm font-bold mb-1">Alumno</label>
                    <input type="text" :value="tuition.student.name" disabled
                        class="w-full px-4 py-2 border rounded-lg bg-gray-100">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-bold mb-1">Período</label>
                    <input type="text" :value="tuition.period" disabled
                        class="w-full px-4 py-2 border rounded-lg bg-gray-100">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-bold mb-1">Fecha Matriculado</label>
                    <input type="text" :value="tuition.registration_date" disabled
                        class="w-full px-4 py-2 border rounded-lg bg-gray-100">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-bold mb-1">Estado</label>
                    <select x-model="tuition.status" class="w-full px-4 py-2 border rounded-lg">
                        @foreach ($statuses as $status)
                            <option value="{{ $status }}">{{ $status }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit"
                    class="w-full py-3 text-white font-bold text-lg rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0B0641]"
                    style="background-color: #003366;">
                    Guardar Cambios
                </button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endsection
