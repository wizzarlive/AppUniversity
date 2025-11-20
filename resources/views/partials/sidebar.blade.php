@php
    $startGradient = '#300114';
    $endGradient = '#0B0641';
    $hoverColor = '#300114';
    $inactiveBgRgba = 'rgba(238, 238, 238, 0.72)';

    $navItems = [
        ['route' => 'dashboard', 'label' => 'Dashboard', 'icon' => 'images/icons/home.webp'],
        ['route' => 'teachers.index', 'label' => 'Profesores', 'icon' => 'images/icons/teacher.webp'],
        ['route' => 'students.index', 'label' => 'Estudiantes', 'icon' => 'images/icons/students.webp'],
        ['route' => 'courses.index', 'label' => 'Cursos', 'icon' => 'images/icons/course.webp'],
        ['route' => 'tuitions.index', 'label' => 'Matrículas', 'icon' => 'images/icons/matricula.webp'],
    ];
@endphp

{{-- SIDEBAR PARA PC (md en adelante) --}}
<div class="hidden md:flex w-64 min-h-screen shadow-2xl p-4 flex-col justify-between"
    style="background-image: linear-gradient(to right, {{ $startGradient }}, {{ $endGradient }}); font-family: 'Kumbh Sans', sans-serif;">

    <div>
        <div class="text-white text-center mb-8 p-2">

            {{-- 🔥 AQUI SE REMPLAZÓ EL SVG + TEXTO POR EL LOGO --}}
            <img src="{{ asset('images/icons/logo_sidebar.webp') }}"
                 class="mx-auto h-20 object-contain mb-4"
                 alt="Logo Universidad">

        </div>

        <nav class="space-y-2">
            @foreach($navItems as $item)
                @php
                    $isActive = request()->routeIs($item['route']);

                    if ($isActive) {
                        $textClasses = "text-[$endGradient] bg-white";
                        $bgStyle = '';
                    } else {
                        $textClasses = 'text-black';
                        $bgStyle = "background-color: $inactiveBgRgba;";
                    }
                @endphp

                <a href="{{ route($item['route']) }}"
                    class="flex items-center px-4 py-2 rounded-lg transition duration-200 font-semibold {{ $textClasses }}"
                    style="{{ $bgStyle }}">

                    <img src="{{ asset($item['icon']) }}" class="w-5 h-5 mr-3 object-contain" alt="{{ $item['label'] }}">

                    <span>{{ $item['label'] }}</span>
                </a>
            @endforeach
        </nav>
    </div>

    {{-- Cerrar sesión en PC --}}
    <div class="mt-8">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center px-4 py-2 rounded-lg text-sm font-semibold text-white 
                       bg-red-600 hover:bg-red-700 transition duration-200">

                <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l3 3m0 0l-3 3m3-3H4.5" />
                </svg>
                Cerrar Sesión
            </button>
        </form>
    </div>
</div>

{{-- BARRA INFERIOR PARA MÓVIL --}}
<div class="fixed bottom-0 left-0 w-full md:hidden flex justify-around items-center py-2 shadow-xl"
    style="background-image: linear-gradient(to right, {{ $startGradient }}, {{ $endGradient }}); font-family: 'Kumbh Sans', sans-serif;">

    @foreach($navItems as $item)
        @php
            $isActive = request()->routeIs($item['route']);
            $iconColor = $isActive ? 'opacity-100' : 'opacity-50';
        @endphp

        <a href="{{ route($item['route']) }}" class="flex flex-col items-center">

            <img src="{{ asset($item['icon']) }}"
                 class="w-7 h-7 mb-1 object-contain {{ $iconColor }}"
                 alt="{{ $item['label'] }}">

            <span class="text-xs text-white">{{ $item['label'] }}</span>
        </a>
    @endforeach

</div>
