<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RRHH - Bienvenida</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">

    <!-- Header / Navbar -->
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex-shrink-0">
                    <h1 class="text-xl font-bold text-gray-800">Sistema RRHH</h1>
                </div>
                <nav class="space-x-4 hidden md:flex">
                    <a href="{{ route('login') }}" class="text-gray-800 hover:text-blue-600 font-medium">Iniciar
                        sesión</a>
                    <a href="#nosotros" class="text-gray-800 hover:text-blue-600 font-medium">Nosotros</a>
                    <a href="{{ route('bitacora.index') }}"
                        class="text-gray-800 hover:text-blue-600 font-medium">Bitácora</a>
                    <a href="#contacto" class="text-gray-800 hover:text-blue-600 font-medium">Contacto</a>
                </nav>
                <!-- Menu hamburguesa para móvil -->
                <div class="md:hidden">
                    <button id="menu-btn" class="text-gray-800 focus:outline-none">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Menú móvil -->
        <div id="menu-mobile" class="hidden md:hidden px-4 pb-4 space-y-2">
            <a href="{{ route('login') }}" class="block text-gray-800 hover:text-blue-600">Iniciar sesión</a>
            <a href="#nosotros" class="block text-gray-800 hover:text-blue-600">Nosotros</a>
            <a href="{{ route('bitacora.index') }}" class="block text-gray-800 hover:text-blue-600">Bitácora</a>
            <a href="#contacto" class="block text-gray-800 hover:text-blue-600">Contacto</a>
        </div>
    </header>

    <!-- Hero / Bienvenida -->
    <main class="flex flex-col items-center justify-center text-center mt-16 px-4">
        <h2 class="text-5xl md:text-6xl font-extrabold text-gray-800 mb-4">Bienvenido al Sistema RRHH</h2>
        <p class="text-gray-600 text-lg md:text-xl mb-8 max-w-2xl">Gestiona empleados, roles, permisos y mucho más de
            forma sencilla y eficiente.</p>
        <a href="{{ route('login') }}"
            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition">Iniciar
            sesión</a>
    </main>

    <script>
        // Toggle menú móvil
        const btn = document.getElementById('menu-btn');
        const menu = document.getElementById('menu-mobile');
        btn.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });
    </script>

</body>

</html>
