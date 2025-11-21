<x-app-layout>
    <x-slot name="title">Pagos de {{ $empleado->name }}</x-slot>

    <h1 class="text-3xl font-bold mb-6">💰 Pagos de {{ $empleado->name }}</h1>

    <a href="{{ route('salarios.index') }}"
       class="bg-gray-600 text-white px-4 py-2 rounded shadow hover:bg-gray-700 mb-4 inline-block">
       🔙 Volver
    </a>

    <table class="min-w-full bg-white shadow rounded">
        <thead class="bg-gray-100">
            <tr>
                <th class="text-left px-4 py-2">Mes</th>
                <th class="text-left px-4 py-2">Salario Base</th>
                <th class="text-left px-4 py-2">Total Bonos</th>
                <th class="text-left px-4 py-2">Total Descuentos</th>
                <th class="text-left px-4 py-2">Total Neto</th>
                <th class="text-left px-4 py-2">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pagosPorMes as $mes => $pagos)
            @php
                $totalBase = $pagos->sum('salario_base');
                $totalBonos = $pagos->sum('total_bonos');
                $totalDescuentos = $pagos->sum('total_descuentos');
                $totalNeto = $pagos->sum('total_neto');
            @endphp
            <tr class="border-b">
                <td class="px-4 py-2">{{ $mes }}</td>
                <td class="px-4 py-2">{{ number_format($totalBase,2) }}</td>
                <td class="px-4 py-2">{{ number_format($totalBonos,2) }}</td>
                <td class="px-4 py-2">{{ number_format($totalDescuentos,2) }}</td>
                <td class="px-4 py-2">{{ number_format($totalNeto,2) }}</td>
                <td class="px-4 py-2">
                    <a href="{{ route('salarios.empleado.mes', [$empleado->id, $mes]) }}"
                       class="bg-blue-600 text-white px-2 py-1 rounded hover:bg-blue-700">
                        Ver Días
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</x-app-layout>
