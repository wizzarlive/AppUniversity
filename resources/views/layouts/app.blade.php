<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - @yield('title')</title>

    <link href="https://fonts.googleapis.com/css2?family=Kumbh+Sans:wght@100..900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<style>
    body {
        font-family: "Kumbh Sans", sans-serif;
    }
</style>

<body class="font-sans antialiased">

    {{-- Contenedor Principal: Usa flex para Sidebar (izquierda) y Contenido (derecha) --}}
    <div class="flex min-h-screen bg-gray-100">

        {{-- 1. Sidebar/Barra Lateral Fija --}}
        @include('partials.sidebar')

        {{-- 2. Contenido de la Derecha (Se expande) --}}
        <div class="flex-1 flex flex-col overflow-hidden">

            @isset($header)
                <header class="bg-white shadow">
                    <div class="py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main class="flex-1 p-6 md:p-8 overflow-x-hidden overflow-y-auto">
                {{-- Usa @yield('content') para recibir el contenido de las vistas hijas --}}
                @yield('content')
            </main>
        </div>
    </div>
</body>

</html>