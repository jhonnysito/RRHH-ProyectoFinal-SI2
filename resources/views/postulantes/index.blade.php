<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Postulantes | HR IA</title>
    <!-- Usando la versión más moderna de Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Estilo para que la tabla sea responsive */
        @media screen and (max-width: 768px) {
            .table-responsive {
                display: block;
                width: 100%;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            .table-responsive>.min-w-full {
                min-width: 800px;
                /* Asegura un ancho mínimo para la tabla */
            }
        }
    </style>
</head>

<body class="bg-gray-50 p-4 md:p-8 font-sans">

    <div class="max-w-7xl mx-auto">
        <!-- Título y botón de creación -->
        <header class="flex flex-col md:flex-row justify-between items-center mb-8 bg-white p-6 rounded-xl shadow-lg">
            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-800">
                👥 Gestión de Postulantes
            </h1>
            <a href="{{ route('postulantes.create') }}"
                class="mt-4 md:mt-0 bg-indigo-600 text-white px-6 py-3 rounded-full shadow-lg hover:bg-indigo-700 transition duration-300 transform hover:scale-105 font-medium">
                ➕ Nuevo Postulante
            </a>
        </header>

        <!-- Mensaje de éxito/alerta -->
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-6 shadow-sm"
                role="alert">
                <span class="font-semibold">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Contenedor Responsivo para la Tabla -->
        <div class="table-responsive bg-white shadow-xl rounded-xl">
            <table class="min-w-full table-auto border-collapse">
                <thead class="bg-indigo-50 border-b border-indigo-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-bold text-gray-700"># ID</th>
                        <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Nombre</th>
                        <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Email</th>
                        <!-- COLUMNAS DE INTELIGENCIA ARTIFICIAL (GEMINI) -->
                        <th class="px-6 py-4 text-left text-sm font-bold text-indigo-700 bg-indigo-100">Puesto Sugerido
                            (AI)</th>
                        <th class="px-6 py-4 text-left text-sm font-bold text-indigo-700 bg-indigo-100">Habilidades
                            Clave (AI)</th>
                        <!-- FIN COLUMNAS DE IA -->
                        <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($postulantes as $postulante)
                        <tr class="hover:bg-indigo-50 transition duration-150">
                            <!-- Datos Básicos -->
                            <td class="px-6 py-4 text-sm font-semibold text-gray-900">{{ $postulante->id }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $postulante->nombres }}
                                {{ $postulante->apellidos }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $postulante->email }}</td>

                            <!-- Datos de IA (Mejor visibilidad con colores y estilos) -->
                            <td class="px-6 py-4 text-sm font-bold text-indigo-700 bg-indigo-50/50">
                                <span
                                    class="inline-block px-3 py-1 rounded-full bg-indigo-200 text-indigo-800 text-xs font-semibold">
                                    {{ $postulante->ai_suggested_job ?? 'Sin Analizar' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-xs text-gray-600 max-w-sm truncate"
                                title="{{ $postulante->ai_skills ?? 'Sin Analizar' }}">
                                <!-- Se usa un límite más generoso para mostrar más contexto de las habilidades -->
                                {{ Illuminate\Support\Str::limit($postulante->ai_skills ?? 'Sin Analizar', 70) }}
                            </td>
                            <!-- Fin Datos de IA -->

                            <!-- Acciones -->
                            <td class="px-6 py-4 text-sm space-x-2 whitespace-nowrap">
                                <a href="{{ route('postulantes.show', $postulante->id) }}"
                                    class="bg-blue-500 text-white px-3 py-1 rounded-full hover:bg-blue-600 text-xs font-medium transition">
                                    👀 Ver
                                </a>
                                <a href="{{ route('postulantes.edit', $postulante->id) }}"
                                    class="bg-yellow-500 text-white px-3 py-1 rounded-full hover:bg-yellow-600 text-xs font-medium transition">
                                    ✏️ Editar
                                </a>
                                <form action="{{ route('postulantes.destroy', $postulante->id) }}" method="POST"
                                    class="inline"
                                    onsubmit="return confirm('¿Está seguro de eliminar a este postulante? Esta acción es irreversible.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-500 text-white px-3 py-1 rounded-full hover:bg-red-600 text-xs font-medium transition">
                                        🗑️ Eliminar
                                    </button>
                                </form>
                                <a href="{{ route('solicitudes.index') }}?postulante_id={{ $postulante->id }}"
                                    class="bg-green-500 text-white px-3 py-1 rounded-full hover:bg-green-600 text-xs font-medium transition mt-1 inline-block">
                                    📑 Solicitudes
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</body>

</html>
