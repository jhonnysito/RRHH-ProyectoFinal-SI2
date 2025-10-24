<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Postular al puesto: {{ $puesto->nombre }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

    <header class="bg-white shadow py-4 mb-6">
        <div class="container mx-auto flex justify-between items-center px-4">
            <h1 class="text-2xl font-bold text-blue-900">RRHH</h1>
            <nav class="space-x-4">
                <a href="/" class="text-gray-800 hover:text-blue-600">Inicio</a>
                <a href="{{ url()->previous() }}" class="text-gray-800 hover:text-blue-600">Volver</a>
            </nav>
        </div>
    </header>

    <main class="container mx-auto py-8 px-4 bg-white rounded-lg shadow max-w-xl">
        <h2 class="text-2xl font-bold text-blue-900 mb-6">Postular al puesto: {{ $puesto->nombre }}</h2>

        @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
        @endif

        <form action="{{ route('postulantes.guardar', $puesto->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div>
                <label class="block font-semibold">Nombres:</label>
                <input type="text" name="nombres" class="w-full border rounded px-3 py-2" required>
            </div>

            <div>
                <label class="block font-semibold">Apellidos:</label>
                <input type="text" name="apellidos" class="w-full border rounded px-3 py-2" required>
            </div>

            <div>
                <label class="block font-semibold">Correo electrónico:</label>
                <input type="email" name="email" class="w-full border rounded px-3 py-2" required>
            </div>

            <div>
                <label class="block font-semibold">Teléfono:</label>
                <input type="text" name="telefono" class="w-full border rounded px-3 py-2">
            </div>

            <div>
                <label class="block font-semibold">Subir CV (PDF o Word):</label>
                <input type="file" name="cv" class="w-full" required>
            </div>

            <div>
                <label class="block font-semibold">Habilidades (separadas por coma)</label>
                <input type="text" name="skills" value="{{ old('skills') }}" class="w-full border rounded px-3 py-2">
                @error('skills')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block font-semibold">Años de Experiencia</label>
                <input type="number" name="experiencia_anios" value="{{ old('experiencia_anios') }}" class="w-full border rounded px-3 py-2">
                @error('experiencia_anios')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-6 rounded-full">
                    Enviar Postulación
                </button>
            </div>
        </form>
    </main>

</body>

</html>