<x-app-layout>
    <x-slot name="title">Salario del Mes</x-slot>

    <!-- Encabezado -->
    <div class="mb-4 flex justify-between items-center">
        <h1 class="text-3xl font-bold">💰 Salario de {{ $empleado->nombre_completo }}</h1>
        <a href="{{ route('salarios.empleado', $empleado->id) }}"
           class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
            ← Volver a Meses
        </a>
    </div>

    <!-- Resumen del pago -->
    @if($pagoMes)
        <div class="bg-white shadow rounded p-4 mb-6">
            <h2 class="text-xl font-semibold mb-2">📊 Resumen del Pago</h2>
            <ul class="space-y-1">
                <li><strong>Salario Base:</strong> {{ number_format($pagoMes->salario_base, 2) }}</li>
                <li><strong>Total Bonos:</strong> {{ number_format($pagoMes->total_bonos, 2) }}</li>
                <li><strong>Total Descuentos:</strong> {{ number_format($pagoMes->total_descuentos, 2) }}</li>
                <li><strong>Total Neto:</strong> {{ number_format($pagoMes->total_neto, 2) }}</li>
                <li><strong>Estado:</strong> {{ ucfirst($pagoMes->estado) }}</li>
            </ul>
        </div>
    @else
        <div class="bg-red-100 text-red-700 p-4 rounded mb-6">
            No hay pago registrado para este mes.
        </div>
    @endif

    <!-- Título asistencias -->
    <div class="mb-4 flex justify-between items-center">
        <h2 class="text-2xl font-semibold">🗓 Asistencias de {{ \Carbon\Carbon::parse($mes)->format('F Y') }}</h2>
        <button id="toggle-problems" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">
            Mostrar solo días con problemas
        </button>
    </div>

    <!-- Tabla de asistencias -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white shadow rounded">
            <thead class="bg-gray-100">
                <tr>
                    <th class="text-left px-4 py-2">Día</th>
                    <th class="text-left px-4 py-2">Entrada</th>
                    <th class="text-left px-4 py-2">Salida</th>
                    <th class="text-left px-4 py-2">Problema</th>
                </tr>
            </thead>
            <tbody>
                @foreach($asistencias as $dia => $records)
                    @php
                        $entrada = $records->min('recorded_at');
                        $salida = $records->max('recorded_at');
                        $problema = $records->count() < 2; // si falta entrada o salida
                    @endphp
                    <tr class="border-b @if($problema) problem-row @else no-problem-row @endif">
                        <td class="px-4 py-2">{{ \Carbon\Carbon::parse($dia)->format('d/m/Y') }}</td>
                        <td class="px-4 py-2">{{ $entrada ? \Carbon\Carbon::parse($entrada)->format('H:i') : '-' }}</td>
                        <td class="px-4 py-2">{{ $salida ? \Carbon\Carbon::parse($salida)->format('H:i') : '-' }}</td>
                        <td class="px-4 py-2 text-red-600 font-semibold">
                            @if($problema)
                                ❌ Faltante
                                <form method="POST" action="{{ route('asistencia.correccion') }}" class="inline ml-2">
                                    @csrf
                                    <input type="hidden" name="empleado" value="{{ $empleado->id }}">
                                    <input type="hidden" name="dia" value="{{ $dia }}">
                                    <button type="submit" class="bg-blue-500 text-white px-2 py-1 rounded">
                                        Corregir
                                    </button>
                                </form>
                            @else
                                ✔
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Script para alternar filas con problemas -->
    <script>
        const toggleBtn = document.getElementById('toggle-problems');
        let showingProblemsOnly = false;

        toggleBtn.addEventListener('click', () => {
            showingProblemsOnly = !showingProblemsOnly;

            document.querySelectorAll('.problem-row').forEach(row => {
                row.style.display = ''; // siempre mostrar los problem-row
            });
            document.querySelectorAll('.no-problem-row').forEach(row => {
                row.style.display = showingProblemsOnly ? 'none' : '';
            });

            toggleBtn.textContent = showingProblemsOnly
                ? 'Mostrar todos los días'
                : 'Mostrar solo días con problemas';
        });
    </script>
</x-app-layout>
