<x-app-layout>
    <x-slot name="title">Descuentos de Empleados</x-slot>

    <!-- Encabezado -->
    <div class="mb-4 flex justify-between items-center">
        <h1 class="text-3xl font-bold">💸 Descuentos Registrados</h1>
        <a href="{{ route('descuentos.create') }}"
           class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
            + Nuevo Descuento
        </a>
    </div>

    @if($descuentos->count())
        <div class="overflow-x-auto bg-white shadow rounded p-4">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left">Empleado</th>
                        <th class="px-4 py-2 text-left">Tipo</th>
                        <th class="px-4 py-2 text-left">Monto</th>
                        <th class="px-4 py-2 text-left">Mes Correspondiente</th>
                        <th class="px-4 py-2 text-left">Fecha Creación</th>
                        <th class="px-4 py-2 text-left">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($descuentos as $descuento)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $descuento->empleado->nombre_completo ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $descuento->tipo }}</td>
                            <td class="px-4 py-2">{{ number_format($descuento->monto, 2) }}</td>
                            <td class="px-4 py-2">{{ $descuento->corresponde_a_mes ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $descuento->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-4 py-2 space-x-2">
                                <a href="{{ route('descuentos.edit', $descuento->id) }}"
                                   class="text-blue-500 hover:underline">Editar</a>
                                <form action="{{ route('descuentos.destroy', $descuento->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline" onclick="return confirm('¿Seguro que quieres eliminar este descuento?')">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="bg-yellow-100 text-yellow-800 p-4 rounded">
            No hay descuentos registrados en el sistema.
        </div>
    @endif
</x-app-layout>
