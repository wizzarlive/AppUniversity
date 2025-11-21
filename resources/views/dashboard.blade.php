@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="p-6">

    <!-- Header estilo estudiantes -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-5 p-6 bg-white rounded-md shadow-md">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 font-[Kumbh_Sans]">Dashboard</h1>
            <p class="text-sm sm:text-base text-gray-500 mt-1">Resumen general de la universidad</p>
        </div>
    </div>

    <!-- Cards compactos -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 mb-6">
        <a href="{{ route('students.index') }}"
            class="bg-white rounded-lg shadow p-3 flex flex-col justify-between hover:shadow-md transition">
            <p class="text-sm font-semibold text-gray-600">Estudiantes</p>
            <p class="text-xl font-bold text-gray-900">{{ $totalStudents }}</p>
        </a>

        <a href="{{ route('courses.index') }}"
            class="bg-white rounded-lg shadow p-3 flex flex-col justify-between hover:shadow-md transition">
            <p class="text-sm font-semibold text-gray-600">Cursos</p>
            <p class="text-xl font-bold text-gray-900">{{ $totalCourses }}</p>
        </a>

        <a href="{{ route('teachers.index') }}"
            class="bg-white rounded-lg shadow p-3 flex flex-col justify-between hover:shadow-md transition">
            <p class="text-sm font-semibold text-gray-600">Docentes</p>
            <p class="text-xl font-bold text-gray-900">{{ $totalTeachers }}</p>
        </a>

        <a href="{{ route('dashboard') }}"
            class="bg-white rounded-lg shadow p-3 flex flex-col justify-between hover:shadow-md transition">
            <p class="text-sm font-semibold text-gray-600">Resumen</p>
            <p class="text-xl font-bold text-gray-900">{{ $totalStudents + $totalTeachers }}</p>
        </a>
    </div>

    <!-- Gráficos compactos -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        <!-- Estudiantes por curso -->
        <div class="bg-white p-3 rounded-lg shadow">
            <h3 class="text-md font-bold text-gray-800 mb-2">Estudiantes por Curso</h3>
            <canvas id="studentsChart" class="w-full" style="height:150px;"></canvas>
        </div>

        <!-- Docentes por curso -->
        <div class="bg-white p-3 rounded-lg shadow">
            <h3 class="text-md font-bold text-gray-800 mb-2">Docentes por Curso</h3>
            <canvas id="teachersChart" class="w-full" style="height:150px;"></canvas>
        </div>
    </div>

</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', () => {

    const coursesLabels = @json($courses->pluck('name'));
    const studentsData = @json($courses->map(function($c){ return $c->students->count(); }));
    const teachersData = @json($courses->map(function($c){ return $c->teacher ? 1 : 0; }));

    // Estudiantes
    new Chart(document.getElementById('studentsChart').getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: coursesLabels,
            datasets: [{
                label: 'Estudiantes',
                data: studentsData,
                backgroundColor: ['#3B82F6', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6', '#EC4899'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });

    // Docentes
    new Chart(document.getElementById('teachersChart').getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: coursesLabels,
            datasets: [{
                label: 'Docentes',
                data: teachersData,
                backgroundColor: ['#F87171', '#60A5FA', '#34D399', '#FBBF24', '#A78BFA', '#F472B6'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });

});
</script>

@endsection
