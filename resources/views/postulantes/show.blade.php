<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Postulante</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">

    <div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow-md mt-10">
        <h1 class="text-3xl font-semibold mb-6">👤 Detalles del Postulante</h1>

        <div class="mb-4">
            <strong class="text-gray-700">Nombre:</strong> {{ $postulante->nombres }} {{ $postulante->apellidos }}
        </div>

        <div class="mb-4">
            <strong class="text-gray-700">Email:</strong> {{ $postulante->email }}
        </div>

        <div class="mb-4">
            <strong class="text-gray-700">Teléfono:</strong> {{ $postulante->telefono }}
        </div>

        <div class="mb-4">
            <strong class="text-gray-700">CV:</strong>
            @if ($postulante->cv)
                <a href="{{ asset($postulante->cv) }}" class="text-blue-500" target="_blank">Ver CV</a>
            @else
                <span class="text-gray-500">No disponible</span>
            @endif
        </div>

        <div class="mb-4">
            <strong class="text-gray-700">Habilidades:</strong>
            <!-- Aquí convertimos el array de habilidades en una lista separada por comas -->
            {{ implode(', ', json_decode($postulante->skills)) }}
        </div>

        <div class="mb-4">
            <strong class="text-gray-700">Años de Experiencia:</strong> {{ $postulante->experiencia_anios }}
        </div>

        <a href="{{ route('postulantes.index') }}" class="text-blue-600">Volver a la lista de postulantes</a>
    </div>

</body>

</html>
