<!-- resources/views/solicitudes/create.blade.php -->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Solicitud de Empleo</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">

    <div class="max-w-7xl mx-auto p-6 bg-white rounded-lg shadow-md mt-10">
        <h1 class="text-2xl font-bold mb-4">Crear Solicitud de Empleo</h1>

        <form action="{{ route('solicitudes.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="postulante_id" class="block text-gray-700">Postulante</label>
                <select name="postulante_id" id="postulante_id" class="mt-1 block w-full border-gray-300 rounded-md"
                    required>
                    <option value="">Seleccionar postulante</option>
                    @foreach ($postulantes as $postulante)
                        <option value="{{ $postulante->id }}">{{ $postulante->nombres }} {{ $postulante->apellidos }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="puesto" class="block text-gray-700">Puesto</label>
                <input type="text" name="puesto" id="puesto" class="mt-1 block w-full border-gray-300 rounded-md"
                    required>
            </div>

            <div class="mb-4">
                <label for="mensaje" class="block text-gray-700">Mensaje</label>
                <textarea name="mensaje" id="mensaje" rows="4" class="mt-1 block w-full border-gray-300 rounded-md" required></textarea>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md">Enviar Solicitud</button>
        </form>

        <div class="mt-4">
            <a href="{{ route('solicitudes.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded-md">Volver al
                listado</a>
        </div>
    </div>

</body>

</html>
