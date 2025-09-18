<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bitácora del Sistema - RRHH</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 font-sans">

    <div class="container mx-auto p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-bold text-gray-800">Bitácora de Actividad</h2>
            <a href="{{ url('/') }}" class="text-blue-600 hover:underline">Volver al Inicio</a>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="py-2 px-4 border-b">ID</th>
                            <th class="py-2 px-4 border-b">Usuario</th>
                            <th class="py-2 px-4 border-b">Acción Principal</th>
                            <th class="py-2 px-4 border-b">Fecha</th>
                            <th class="py-2 px-4 border-b">IP</th>
                            <th class="py-2 px-4 border-b">Detalles de Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($bitacoras as $bitacora)
                            <tr class="hover:bg-gray-50">
                                <td class="py-2 px-4 border-b text-center">{{ $bitacora->id }}</td>
                                <td class="py-2 px-4 border-b">{{ $bitacora->usuario }} (ID: {{ $bitacora->user_id }})
                                </td>
                                <td class="py-2 px-4 border-b">{{ $bitacora->bitacora }}</td>
                                <td class="py-2 px-4 border-b text-center">{{ $bitacora->fecha }}</td>
                                <td class="py-2 px-4 border-b text-center">{{ $bitacora->ip }}</td>
                                <td class="py-2 px-4 border-b">
                                    @if ($bitacora->detalles->isNotEmpty())
                                        <ul>
                                            @foreach ($bitacora->detalles as $detalle)
                                                <li class="text-sm text-gray-600">
                                                    - <span class="font-semibold">{{ $detalle->accion }}</span> en
                                                    '{{ $detalle->tabla }}' (Registro ID: {{ $detalle->registroId }})
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <span class="text-gray-400">Sin detalles</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-4 px-4 text-center text-gray-500">No hay registros en la
                                    bitácora.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-6">{{ $bitacoras->links() }}</div>
        </div>
    </div>
</body>

</html>
