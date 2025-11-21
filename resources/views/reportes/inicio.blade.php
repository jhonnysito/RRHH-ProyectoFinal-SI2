<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Generar Reportes Estáticos
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Contenedor principal -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form action="{{ route('reportes.generar') }}" method="POST" class="space-y-4">
                    @csrf <!-- muy importante en POST -->

                    <!-- Departamento -->
                    <div>
                        <label for="departamento" class="block font-medium text-gray-700">Departamento:</label>
                        <select name="departamento_id" id="departamento" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="">-- Todos --</option>
                            @foreach($departamentos as $departamento)
                            <option value="{{ $departamento->id }}">{{ $departamento->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Cargo -->
                    <div>
                        <label for="cargo" class="block font-medium text-gray-700">Cargo:</label>
                        <select name="cargo_id" id="cargo" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="">-- Todos --</option>
                            @foreach($cargos as $cargo)
                            <option value="{{ $cargo->id }}">{{ $cargo->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Empleado -->
                    <div>
                        <label for="empleado" class="block font-medium text-gray-700">Empleado:</label>
                        <select name="empleado_id" id="empleado" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="">-- Todos --</option>
                            @foreach($empleados as $empleado)
                            <option value="{{ $empleado->id }}">{{ $empleado->nombre_completo }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Botón Generar Reporte -->
                    <div>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            Generar Reporte
                        </button>
                    </div>
                </form>

                <!-- Reportes Estáticos -->
                <div class="mt-8">
                    <h3 class="font-semibold text-lg text-gray-800 mb-4">Reportes Disponibles:</h3>
                    <ul class="list-disc pl-5 space-y-2">
                        @foreach($reportes_estaticos as $reporte)
                        <li>{{ $reporte['nombre'] ?? $reporte }}</li>
                        @endforeach
                    </ul>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>