@extends('layouts.app')

@section('title', 'Gestión de Cursos')

@section('content')

    <div class="p-0">

        <!-- Encabezado -->
        <div
            class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-5 p-6 bg-white rounded-md shadow-md">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 font-[Kumbh_Sans]">Cursos</h1>
                <p class="text-base font-semibold text-gray-800 mt-1">Apartado para gestionar los cursos</p>
            </div>

            <button onclick="openCreateCourseModal()"
                class="mt-4 sm:mt-0 inline-flex items-center px-4 py-3 rounded-md shadow-sm text-sm font-semibold text-white w-full sm:w-auto justify-center"
                style="background-color: #509BDB;">
                Agregar Curso
            </button>
        </div>

        <!-- Barra herramientas -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center space-y-4 sm:space-y-0 sm:space-x-4 mb-5">

            <!-- Total -->
            <div class="text-gray-700 w-full sm:w-auto">
                <span class="font-medium px-4 py-2 rounded-md text-white block text-center sm:inline-block"
                    style="background: linear-gradient(90deg, #2F0113 0%, #0B0641 100%);">
                    Total de cursos: <span class="font-bold">{{ $courses->count() }}</span>
                </span>
            </div>

            <!-- Buscador -->
            <div class="relative w-full max-w-full sm:max-w-sm">
                <input type="text" id="searchInput" placeholder="Buscar curso..."
                    class="w-full p-2.5 pl-10 border border-gray-300 rounded-md focus:ring-[#0B0641] focus:border-[#0B0641] text-sm text-gray-600 font-normal">

                <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-gray-500"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.197 5.197a7.5 7.5 0 0010.606 10.606z" />
                </svg>
            </div>
        </div>

        <!-- GRID DE CURSOS (CARDS) -->
        <div id="courseGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

            @foreach ($courses as $course)
                <a href="{{ route('courses.show', $course->id) }}"
                    class="course-card block p-6 rounded-xl shadow-lg text-white hover:scale-[1.03] transition-all"
                    style="background: linear-gradient(90deg, #2F0113 0%, #0B0641 100%);">

                    <h3 class="text-xl font-bold">{{ $course->name }}</h3>

                    <p class="mt-2 text-sm opacity-90">
                        Profesor:
                        @if ($course->teacher)
                            <span class="font-semibold">{{ $course->teacher->name }}</span>
                        @else
                            <span class="opacity-70">Sin asignar</span>
                        @endif
                    </p>

                </a>

            @endforeach

        </div>

        <!-- Backdrop -->
        <div id="modalBackdrop" class="fixed inset-0 bg-gray-900 bg-opacity-50 z-40 hidden"></div>

        <!-- MODAL CREAR CURSO -->
        <div id="createCourseModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-black/30">
            <div class="flex items-center justify-center min-h-screen p-4">

                <div class="bg-white rounded-2xl shadow-xl sm:max-w-md w-full">

                    <div class="px-8 pt-8 pb-4 flex justify-between items-center">
                        <h3 class="text-2xl font-bold text-black font-[Kumbh_Sans]">Registrar Curso</h3>

                        <button onclick="closeCreateCourseModal()" class="text-gray-400 hover:text-gray-600">
                            ✕
                        </button>
                    </div>

                    <form action="{{ route('courses.store') }}" method="POST">
                        @csrf

                        <div class="px-8 pb-8 space-y-5">

                            <div>
                                <label class="block text-sm font-bold text-black mb-1">Nombre del Curso</label>
                                <input type="text" name="name" required
                                    class="w-full bg-[#EEEEEE] rounded-md py-3 px-4 text-sm text-gray-700 focus:ring-2 focus:ring-[#0B0641]">
                            </div>

                            <button type="submit" class="w-full py-3 text-white font-bold text-lg rounded-lg shadow-md"
                                style="background-color: #003366;">
                                Registrar
                            </button>

                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- MODAL EDITAR CURSO -->
        <div id="editCourseModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-black/30">
            <div class="flex items-center justify-center min-h-screen p-4">

                <div class="bg-white rounded-2xl shadow-xl sm:max-w-md w-full">

                    <div class="px-8 pt-8 pb-4 flex justify-between items-center">
                        <h3 class="text-2xl font-bold text-black font-[Kumbh_Sans]">Editar Curso</h3>

                        <button onclick="closeEditCourseModal()" class="text-gray-400 hover:text-gray-600">✕</button>
                    </div>

                    <form id="editCourseForm" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="px-8 pb-8 space-y-5">

                            <div>
                                <label class="block text-sm font-bold text-black mb-1">Nombre del Curso</label>
                                <input id="editCourseName" type="text" name="name" required
                                    class="w-full bg-[#EEEEEE] rounded-md py-3 px-4 text-sm text-gray-700 focus:ring-2 focus:ring-[#0B0641]">
                            </div>

                            <button type="submit" class="w-full py-3 text-white font-bold text-lg rounded-lg shadow-md"
                                style="background-color: #003366;">
                                Guardar Cambios
                            </button>

                        </div>
                    </form>

                </div>
            </div>
        </div>

        <script>
            function openCreateCourseModal() {
                document.getElementById('createCourseModal').classList.remove('hidden');
                document.getElementById('modalBackdrop').classList.remove('hidden');
            }

            function closeCreateCourseModal() {
                document.getElementById('createCourseModal').classList.add('hidden');
                document.getElementById('modalBackdrop').classList.add('hidden');
            }

            function openEditCourseModal(id, name) {
                document.getElementById('editCourseName').value = name;
                document.getElementById('editCourseForm').action = `/courses/${id}`;
                document.getElementById('editCourseModal').classList.remove('hidden');
                document.getElementById('modalBackdrop').classList.remove('hidden');
            }

            function closeEditCourseModal() {
                document.getElementById('editCourseModal').classList.add('hidden');
                document.getElementById('modalBackdrop').classList.add('hidden');
            }

            // Buscador
            document.getElementById('searchInput').addEventListener('input', function () {
                const search = this.value.toLowerCase();
                const cards = document.querySelectorAll('.course-card');
                cards.forEach(card => {
                    const title = card.querySelector('h3').innerText.toLowerCase();
                    card.style.display = title.includes(search) ? 'block' : 'none';
                });
            });
        </script>

@endsection