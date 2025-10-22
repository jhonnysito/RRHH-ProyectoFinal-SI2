<!-- resources/views/solicitudes/index.blade.php -->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Solicitudes de Empleo</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">

    <div class="max-w-7xl mx-auto p-6 bg-white rounded-lg shadow-md mt-10">
        <h1 class="text-2xl font-bold mb-4">Lista de Solicitudes de Empleo</h1>

        <!-- Botón para crear nueva solicitud -->
        <a href="{{ route('solicitudes.create') }}"
            class="bg-blue-600 text-white px-4 py-2 rounded-md mb-4 inline-block">Crear Solicitud</a>

        <!-- Tabla de solicitudes de empleo -->
        <table class="min-w-full bg-white border-collapse">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border px-4 py-2">Postulante</th>
                    <th class="border px-4 py-2">Puesto</th>
                    <th class="border px-4 py-2">Estado</th>
                    <th class="border px-4 py-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($solicitudes as $solicitud)
                    <tr class="hover:bg-gray-50">
                        <td class="border px-4 py-2">{{ $solicitud->postulante->nombres }}
                            {{ $solicitud->postulante->apellidos }}</td>
                        <td class="border px-4 py-2">{{ $solicitud->puesto }}</td>
                        <td class="border px-4 py-2">{{ $solicitud->estado }}</td>
                        <td class="border px-4 py-2">
                            <!-- Ver solicitud -->
                            <a href="{{ route('solicitudes.show', $solicitud) }}" class="text-blue-500">Ver</a>

                            <!-- Editar solicitud -->
                            <a href="{{ route('solicitudes.edit', $solicitud) }}"
                                class="text-yellow-500 ml-4">Editar</a>

                            <!-- Eliminar solicitud -->
                            <form action="{{ route('solicitudes.destroy', $solicitud) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 ml-4">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>

</body>

</html>
