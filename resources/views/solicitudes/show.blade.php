<!-- resources/views/solicitudes/show.blade.php -->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de la Solicitud de Empleo</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">

    <div class="max-w-7xl mx-auto p-6 bg-white rounded-lg shadow-md mt-10">
        <h1 class="text-2xl font-bold mb-4">Detalles de la Solicitud de Empleo</h1>

        <div class="bg-white shadow-md rounded p-6">
            <p><strong>Postulante:</strong> {{ $solicitud->postulante->nombres }}
                {{ $solicitud->postulante->apellidos }}</p>
            <p><strong>Puesto solicitado:</strong> {{ $solicitud->puesto }}</p>
            <p><strong>Mensaje:</strong> {{ $solicitud->mensaje }}</p>
            <p><strong>Estado:</strong> {{ ucfirst($solicitud->estado) }}</p>
        </div>

        <div class="mt-4">
            <a href="{{ route('solicitudes.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md">Volver al
                listado</a>
        </div>
    </div>

</body>

</html>
