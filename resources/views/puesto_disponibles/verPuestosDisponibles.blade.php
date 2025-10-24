<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Puestos Activos de la Empresa</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

    <header class="bg-white shadow py-4 mb-6">
        <div class="container mx-auto flex justify-between items-center px-4">
            <h1 class="text-2xl font-bold text-blue-900">RRHH</h1>
            <nav class="space-x-4">
                <a href="/" class="text-gray-800 hover:text-blue-600">Inicio</a>
            </nav>
        </div>
    </header>

    <main class="container mx-auto py-8 px-4">
        <h2 class="text-3xl font-bold text-blue-900 mb-6">Puestos Activos de la Empresa</h2>

        @if($puesto_disponibles->isEmpty())
        <p class="text-gray-600">No hay puestos disponibles actualmente.</p>
        @else
        <div class="overflow-x-auto bg-white p-4 rounded-lg shadow">
            <table class="table-auto w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-blue-100">
                        <th class="px-4 py-2 border">Nombre</th>
                        <th class="px-4 py-2 border">Modalidad</th>
                        <th class="px-4 py-2 border">Nivel</th>
                        <th class="px-4 py-2 border">Salario</th>
                        <th class="px-4 py-2 border">Ubicación</th>
                        <th class="px-4 py-2 border">Vacantes</th>
                        <th class="px-4 py-2 border">Fecha Límite</th>
                        <th class="px-4 py-2 border">Estado</th>
                        <th class="px-4 py-2 border">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($puesto_disponibles as $puesto)
                    <tr class="hover:bg-blue-50">
                        <td class="px-4 py-2 border">{{ $puesto->nombre }}</td>
                        <td class="px-4 py-2 border">{{ $puesto->modalidad }}</td>
                        <td class="px-4 py-2 border">{{ $puesto->nivel }}</td>
                        <td class="px-4 py-2 border">{{ $puesto->salario }}</td>
                        <td class="px-4 py-2 border">{{ $puesto->ubicacion }}</td>
                        <td class="px-4 py-2 border">{{ $puesto->vacantes }}</td>
                        <td class="px-4 py-2 border">{{ $puesto->fecha_limite }}</td>
                        <td class="px-4 py-2 border">{{ $puesto->estado }}</td>
                        <td class="px-4 py-2 border">
                            <a href="{{ route('puesto_disponible.ver', $puesto->id) }}"
                                class="bg-blue-500 hover:bg-blue-600 text-white py-1 px-3 rounded-full text-sm">
                                Ver más
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </main>


    <footer class="bg-white shadow mt-8 py-4">
        <div class="container mx-auto text-center text-gray-600">
            &copy; {{ date('Y') }} RRHH - Todos los derechos reservados
        </div>
    </footer>

</body>

</html>