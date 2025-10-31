<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'ERP RRHH' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 text-gray-900">

    <!-- Navbar superior -->
    <nav class="bg-blue-100 text-white p-4 fixed top-0 left-0 w-full z-20 shadow">
        <div class="max-w-7xl mx-auto flex justify-between">
            <span class="font-bold text-gray-700">ERP RRHH</span>
            <a href="{{ route('departamentos.index') }}" class="hover:underline text-gray-700">Departamentos</a>
        </div>
    </nav>

    <!-- Sidebar fijo -->
    <aside
        class="w-60 h-[calc(100vh-55px)] fixed top-14 left-0 bg-gray-100 shadow overflow-y-auto z-10">
        <ul class="flex flex-col gap-1 mt-2">
            <li class="text-gray-600 hover:bg-gray-200">
                <a href="{{ route('dashboard') }}" class="block px-5 py-3">Dashboard</a>
            </li>
            <li class="text-gray-600 hover:bg-gray-200">
                <a href="{{ route('departamentos.index') }}" class="block px-5 py-3">Departamentos</a>
            </li>
            <!-- Más items -->
        </ul>
    </aside>

    <!-- Contenido principal -->
    <main class="ml-60 pt-16 p-4">
        {{ $slot }}
    </main>

</body>
</html>
