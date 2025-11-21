<x-app-layout>
    <x-slot name="title">Salarios</x-slot>

    <h1 class="text-3xl font-bold mb-6">💰 Salarios por Empleado</h1>

    <table class="min-w-full bg-white shadow rounded">
        <thead class="bg-gray-100">
            <tr>
                <th class="text-left px-4 py-2">#</th>
                <th class="text-left px-4 py-2">Empleado</th>
                <th class="text-left px-4 py-2">Salario Total Base</th>
                <th class="text-left px-4 py-2">Total Bonos</th>
                <th class="text-left px-4 py-2">Total Descuentos</th>
                <th class="text-left px-4 py-2">Total Neto</th>
                <th class="text-left px-4 py-2">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($empleados as $empleado)
            @php
                $totalBase = $empleado->pagos->sum('salario_base');
                $totalBonos = $empleado->pagos->sum('total_bonos');
                $totalDescuentos = $empleado->pagos->sum('total_descuentos');
                $totalNeto = $empleado->pagos->sum('total_neto');
            @endphp
            <tr class="border-b">
                <td class="px-4 py-2">{{ $loop->iteration }}</td>
                <td class="px-4 py-2">{{ $empleado->name }}</td>
                <td class="px-4 py-2">{{ number_format($totalBase,2) }}</td>
                <td class="px-4 py-2">{{ number_format($totalBonos,2) }}</td>
                <td class="px-4 py-2">{{ number_format($totalDescuentos,2) }}</td>
                <td class="px-4 py-2">{{ number_format($totalNeto,2) }}</td>
                <td class="px-4 py-2">
                    <a href="{{ route('salarios.empleado', $empleado->id) }}"
                       class="bg-blue-600 text-white px-2 py-1 rounded hover:bg-blue-700">
                        Ver Meses
                    </a>
                </td>
            </tr>   
            @endforeach
        </tbody>
    </table>
</x-app-layout>
