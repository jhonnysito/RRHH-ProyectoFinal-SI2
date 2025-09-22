<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'ERP RRHH' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-900">

    <!-- Navbar -->
    <nav class="bg-blue-600 text-white p-4">
        <div class="max-w-7xl mx-auto flex justify-between">
            <span class="font-bold">ERP RRHH</span>
            <a href="{{ route('departamentos.index') }}" class="hover:underline">Departamentos</a>
        </div>
    </nav>

    <!-- Contenido -->
    <main class="max-w-7xl mx-auto p-6">
        {{ $slot }}
    </main>

</body>
</html>
