<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Darwin</title>
    <link href="https://fonts.googleapis.com/css2?family=Kumbh+Sans:wght@400;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-[#300114] to-[#0B0641] font-inter p-4">

    <!-- Contenedor principal del card (imagen + formulario) -->
    <div class="flex flex-col md:flex-row w-full max-w-[1080px] md:h-[424px] rounded-2xl shadow-2xl overflow-hidden">

        <!-- Imagen lateral -->
        <div class="w-full md:w-1/2 h-64 md:h-auto bg-cover bg-center" style="background-image: url('images/icons/login.webp');">
        </div>

        <!-- Card del formulario -->
        <div class="w-full md:w-1/2 bg-white px-10 py-12 flex flex-col justify-center">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6 font-kumbh">Iniciar Sesión</h2>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-4">
                    <label for="email" class="block font-semibold text-sm text-gray-700 mb-1">Correo</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                           placeholder="1354340@axis.pe"
                           class="block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-gray-800 text-sm focus:ring-1 focus:ring-red-500 focus:border-red-500 transition"/>
                </div>

                <div class="mb-6">
                    <label for="password" class="block font-semibold text-sm text-gray-700 mb-1">Contraseña</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="********"
                           class="block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-gray-800 text-sm focus:ring-1 focus:ring-red-500 focus:border-red-500 transition"/>
                </div>

                <button type="submit" class="w-full py-3 rounded-lg font-bold text-white shadow-md transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 bg-gradient-to-r from-[#300114] to-[#0B0641] hover:from-[#0B0641] hover:to-[#300114]">
                    Inicia Sesión
                </button>
            </form>
        </div>

    </div>

</body>
</html>
