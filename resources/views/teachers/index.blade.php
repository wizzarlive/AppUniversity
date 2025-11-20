@extends('layouts.app')

@section('title', 'Gestión de Profesores')

@section('content')

<div class="p-0">

    <!-- Encabezado -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-5 p-6 bg-white rounded-md shadow-md">
        <div>
            <h1 class="text-3xl font-bold text-gray-800 font-[Kumbh_Sans]">Profesores</h1>
            <p class="text-base font-semibold text-gray-800 mt-1">Apartado para gestionar los profesores</p>
        </div>

        <button onclick="openCreateModal()"
            class="mt-4 sm:mt-0 inline-flex items-center px-4 py-3 rounded-md shadow-sm text-sm font-semibold text-white w-full sm:w-auto justify-center"
            style="background-color: #509BDB;">
            Agregar Profesor
        </button>
    </div>

    <!-- Barra herramientas -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center space-y-4 sm:space-y-0 sm:space-x-4 mb-5">
        <div class="text-gray-700 w-full sm:w-auto">
            <span class="font-medium px-4 py-2 rounded-md text-white block text-center sm:inline-block"
                style="background: linear-gradient(90deg, #2F0113 0%, #0B0641 100%);">
                Total de profesores: <span class="font-bold">{{ $teachers->total() }}</span>
            </span>
        </div>

        <div class="relative w-full max-w-full sm:max-w-sm">
            <input type="text" placeholder="Buscar profesor por dni"
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
                        <th class="px-3 py-3 text-xs font-bold text-black uppercase tracking-wider">Id</th>
                        <th class="px-3 py-3 text-xs font-bold text-black uppercase tracking-wider">Dni</th>
                        <th class="px-3 py-3 text-xs font-bold text-black uppercase tracking-wider">Nombres</th>
                        <th class="px-3 py-3 text-xs font-bold text-black uppercase tracking-wider">Número</th>
                        <th class="px-3 py-3 text-xs font-bold text-black uppercase tracking-wider">Cursos</th>
                        <th class="px-3 py-3 text-xs font-bold text-black uppercase tracking-wider">Correo Electrónico</th>
                        <th class="px-3 py-3 text-xs font-bold text-black uppercase tracking-wider">Estado</th>
                        <th class="px-3 py-3 text-xs font-bold text-black uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($teachers as $teacher)
                        <tr>
                            <td class="px-3 py-4 whitespace-nowrap text-xs text-gray-900">{{ $teacher->id }}</td>
                            <td class="px-3 py-4 whitespace-nowrap text-xs text-gray-900">{{ $teacher->dni }}</td>
                            <td class="px-3 py-4 whitespace-nowrap text-xs text-gray-900">{{ $teacher->name }}</td>
                            <td class="px-3 py-4 whitespace-nowrap text-xs text-gray-900">{{ $teacher->phone }}</td>
                            <td class="px-3 py-4 whitespace-nowrap text-xs text-gray-900">
                                @if ($teacher->courses->isNotEmpty())
                                    {{ $teacher->courses->pluck('name')->join(', ') }}
                                @else
                                    Sin Curso
                                @endif
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-xs text-gray-900">{{ $teacher->email }}</td>
                            <td class="px-3 py-4 whitespace-nowrap">
                                @php $is_active = in_array($teacher->status, ['Activo', 'Activado', 'active']); @endphp
                                <span class="px-3 py-1 inline-flex text-xs font-medium rounded-md {{ $is_active ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }}">
                                    {{ $teacher->status }}
                                </span>
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-xs font-medium">
                                <a onclick='openEditModal(@json($teacher), @json($teacher->courses->pluck("id")))'
                                    class="inline-flex items-center justify-center h-6 w-10 rounded-md"
                                    style="background-color: rgba(255,180,0,0.19);">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                        style="color: #FFB400;">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.232 5.232z" />
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-gray-200">
            {{ $teachers->links() }}
        </div>

    </div>
</div>

<!-- Backdrop -->
<div id="modalBackdrop" class="fixed inset-0 bg-gray-900 bg-opacity-50 z-40 hidden"></div>

<!-- Modal Crear Profesor -->
<div id="createTeacherModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-black/30">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-2xl shadow-xl sm:max-w-2xl w-full">
            <div class="px-8 pt-8 pb-4 flex justify-between items-center">
                <h3 class="text-2xl font-bold text-black font-[Kumbh_Sans]">Añadir Nuevo Profesor</h3>
                <button onclick="closeCreateModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form action="{{ route('teachers.store') }}" method="POST">
                @csrf
                <div class="px-8 pb-8 space-y-5">

                    <div>
                        <label class="block text-sm font-bold text-black mb-1">Apellidos y Nombres</label>
                        <input type="text" name="name" required class="w-full bg-[#EEEEEE] rounded-md py-3 px-4 text-sm">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-bold text-black mb-1">Correo Electrónico</label>
                            <input type="email" name="email" required class="w-full bg-[#EEEEEE] rounded-md py-3 px-4 text-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-black mb-1">DNI</label>
                            <input type="text" maxlength="8" name="dni" required class="w-full bg-[#EEEEEE] rounded-md py-3 px-4 text-sm">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-black mb-1">Número Telefónico</label>
                        <input type="text" maxlength="9" name="phone" required class="w-full bg-[#EEEEEE] rounded-md py-3 px-4 text-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-black mb-1">Estado</label>
                        <select name="status" required class="w-full bg-[#EEEEEE] rounded-md py-3 px-4 text-sm">
                            <option value="Activo">Activo</option>
                            <option value="Inactivo">Inactivo</option>
                        </select>
                    </div>

                    <!-- SELECT MULTIPLE CREAR -->
                    <div>
                        <label class="block text-sm font-bold text-black mb-1">Seleccione cursos</label>
                        <select name="courses[]" multiple class="w-full bg-[#EEEEEE] rounded-md py-3 px-4 text-sm h-40 overflow-y-auto cursor-pointer">
                            @foreach ($courses as $course)
                                @php $assigned = $course->fk_teacher !== null; @endphp
                                <option value="{{ $course->id }}" @if($assigned) disabled @endif class="whitespace-nowrap">
                                    {{ $course->name }}
                                    @if($assigned) (No disponible) @endif
                                </option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-500 mt-1">Puede seleccionar varios cursos.</p>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full py-3 text-white font-bold text-lg rounded-lg shadow-md" style="background-color: #003366;">
                            Añadir
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Editar Profesor -->
<div id="editTeacherModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-black/30">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-2xl shadow-xl sm:max-w-2xl w-full">
            <div class="px-8 pt-8 pb-4 flex justify-between items-center">
                <h3 class="text-2xl font-bold text-black font-[Kumbh_Sans]">Editar Profesor</h3>
                <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form id="editTeacherForm" method="POST">
                @csrf
                @method('PUT')
                <div class="px-8 pb-8 space-y-5">

                    <div>
                        <label class="block text-sm font-bold text-black mb-1">Apellidos y Nombres</label>
                        <input type="text" id="edit_name" name="name" required class="w-full bg-[#EEEEEE] rounded-md py-3 px-4 text-sm">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-bold text-black mb-1">Correo Electrónico</label>
                            <input type="email" id="edit_email" name="email" required class="w-full bg-[#EEEEEE] rounded-md py-3 px-4 text-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-black mb-1">DNI</label>
                            <input type="text" maxlength="8" id="edit_dni" name="dni" required class="w-full bg-[#EEEEEE] rounded-md py-3 px-4 text-sm">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-black mb-1">Número Telefónico</label>
                        <input type="text" maxlength="9" id="edit_phone" name="phone" required class="w-full bg-[#EEEEEE] rounded-md py-3 px-4 text-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-black mb-1">Estado</label>
                        <select id="edit_status" name="status" required class="w-full bg-[#EEEEEE] rounded-md py-3 px-4 text-sm">
                            <option value="Activo">Activo</option>
                            <option value="Inactivo">Inactivo</option>
                        </select>
                    </div>

                    <!-- SELECT MULTIPLE EDITAR -->
                    <div>
                        <label class="block text-sm font-bold text-black mb-1">Seleccione cursos</label>
                        <select name="courses[]" id="edit_courses" multiple class="w-full bg-[#EEEEEE] rounded-md py-3 px-4 text-sm h-40 overflow-y-auto cursor-pointer">
                            @foreach ($courses as $course)
                                @php
                                    $assigned = $course->teacher ? true : false;
                                    $isMine = isset($teacher) && $course->fk_teacher == $teacher->id;
                                @endphp
                                <option value="{{ $course->id }}" @if($isMine) selected @endif @if($assigned && !$isMine) disabled @endif class="whitespace-nowrap">
                                    {{ $course->name }}
                                    @if($assigned) (Asignado a: {{ $course->teacher->name }}) @endif
                                </option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-500 mt-1">Puede seleccionar varios cursos.</p>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full py-3 text-white font-bold text-lg rounded-lg shadow-md" style="background-color: #003366;">
                            Guardar Cambios
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openCreateModal() {
    document.getElementById('createTeacherModal').classList.remove('hidden');
    document.getElementById('modalBackdrop').classList.remove('hidden');
}

function closeCreateModal() {
    document.getElementById('createTeacherModal').classList.add('hidden');
    document.getElementById('modalBackdrop').classList.add('hidden');
}

function openEditModal(teacher, courseIds) {
    document.getElementById('editTeacherModal').classList.remove('hidden');
    document.getElementById('modalBackdrop').classList.remove('hidden');

    document.getElementById('editTeacherForm').action = `/teachers/${teacher.id}`;

    document.getElementById('edit_name').value = teacher.name;
    document.getElementById('edit_email').value = teacher.email;
    document.getElementById('edit_dni').value = teacher.dni;
    document.getElementById('edit_phone').value = teacher.phone;
    document.getElementById('edit_status').value = teacher.status;

    // Seleccionar cursos
    const select = document.getElementById('edit_courses');
    Array.from(select.options).forEach(opt => {
        opt.selected = courseIds.includes(parseInt(opt.value));
    });
}

function closeEditModal() {
    document.getElementById('editTeacherModal').classList.add('hidden');
    document.getElementById('modalBackdrop').classList.add('hidden');
}
</script>

@endsection
