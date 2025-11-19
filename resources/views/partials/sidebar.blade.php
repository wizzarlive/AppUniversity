@php
    $startGradient = '#300114'; 
    $endGradient = '#0B0641';
    $hoverColor = '#300114';
    $inactiveBgRgba = 'rgba(238, 238, 238, 0.72)';

    $navItems = [
        ['route' => 'dashboard', 'label' => 'Dashboard', 'icon' => 'M3 4h18M3 10h18M3 16h18'],
        ['route' => 'teachers.index', 'label' => 'Profesores', 'icon' => 'M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.25a.75.75 0 01.75-.75h14.5a.75.75 0 01.75.75V21.5a.75.75 0 01-.75.75H5.25a.75.75 0 01-.75-.75V20.25z'],
        ['route' => 'students.index', 'label' => 'Estudiantes', 'icon' => 'M12 4.5v15M10 7.5l4 4-4 4'],
        ['route' => 'courses.index', 'label' => 'Cursos', 'icon' => 'M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5'],
        ['route' => 'tuitions.index', 'label' => 'Matrículas', 'icon' => 'M19.5 12.75v3a2.25 2.25 0 01-2.25 2.25H5.25a2.25 2.25 0 01-2.25-2.25v-3m18-7.5h-16.5a2.25 2.25 0 00-2.25 2.25v10.5a2.25 2.25 0 002.25 2.25H16.5a2.25 2.25 0 002.25-2.25V5.25z'],
    ];
@endphp

{{-- SIDEBAR PARA PC (md en adelante) --}}
<div class="hidden md:flex w-64 min-h-screen shadow-2xl p-4 flex-col justify-between"
     style="background-image: linear-gradient(to right, {{ $startGradient }}, {{ $endGradient }}); font-family: 'Kumbh Sans', sans-serif;">

    <div>
        <div class="text-white text-center mb-8 p-2">
            <svg class="mx-auto h-12 w-12 mb-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 21.75l-4.5-2.25V4.5l4.5 2.25 4.5-2.25V19.5l-4.5 2.25zM12 21.75V6.75m0 0l-4.5 2.25M12 6.75l4.5 2.25" />
            </svg>
            <h1 class="text-lg font-bold">UNIVERSIDAD AXIS</h1>
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
                    <svg class="w-5 h-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}" />
                    </svg>
                    <span>{{ $item['label'] }}</span>
                </a>
            @endforeach
        </nav>
    </div>

    {{-- Cerrar sesión en PC --}}
    <div class="mt-8">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="w-full flex items-center justify-center px-4 py-2 rounded-lg text-sm font-semibold text-white 
                       bg-red-600 hover:bg-red-700 transition duration-200">

                <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
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
            $iconColor = $isActive ? 'text-white' : 'text-gray-300';
        @endphp

        <a href="{{ route($item['route']) }}" class="flex flex-col items-center">
            <svg class="w-7 h-7 {{ $iconColor }}" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}" />
            </svg>
            <span class="text-xs {{ $iconColor }}">{{ $item['label'] }}</span>
        </a>
    @endforeach
</div>
