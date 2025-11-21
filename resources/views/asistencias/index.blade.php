@extends('layouts.app')

@section('content')
<div class="p-6 bg-gray-100 min-h-screen">
    <h1 class="text-3xl font-bold mb-6">Registro de Asistencias</h1>

    @if(session('success'))
    <div class="mb-4 p-3 bg-green-200 text-green-800 rounded shadow">
        {{ session('success') }}
    </div>
    @endif

    <div class="mb-4 flex justify-between items-center">
        <form action="{{ route('asistencias.store') }}" method="POST" id="formAsistencia">
            @csrf
            <button type="submit"
                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 flex items-center gap-2">
                <i class="fa-solid fa-plus"></i> Marcar Asistencia
            </button>
        </form>

        <form method="GET" class="flex gap-2">
            <input type="date" name="fecha" value="{{ request('fecha') }}" class="border rounded px-3 py-2">
            <select name="empleado_id" class="border rounded px-3 py-2">
                <option value="">Todos los empleados</option>
                @foreach($empleados as $empleado)
                <option value="{{ $empleado->id }}" {{ request('empleado_id') == $empleado->id ? 'selected' : '' }}>
                    {{ $empleado->nombre_completo }}
                </option>
                @endforeach
            </select>
            <button type="submit" class="px-4 py-2 bg-gray-700 text-white rounded hover:bg-gray-800">Buscar</button>
        </form>
    </div>

    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Empleado</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Entrada</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Salida</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Observación</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($asistencias as $asistencia)
                <tr class="even:bg-gray-50 hover:bg-gray-100 transition duration-150">
                    <td class="px-6 py-4">{{ $asistencia->empleado->nombre_completo ?? 'Sin empleado' }}</td>
                    <td class="px-6 py-4">{{ $asistencia->fecha }}</td>
                    <td class="px-6 py-4">
                        {{ $asistencia->hora_entrada ? \Carbon\Carbon::parse($asistencia->hora_entrada)->format('H:i') : '-' }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $asistencia->hora_salida ? \Carbon\Carbon::parse($asistencia->hora_salida)->format('H:i') : '-' }}
                    </td>
                    <td class="px-6 py-4">
                        @php
                        $colores = [
                        'Presente' => 'bg-green-500',
                        'Tarde' => 'bg-yellow-500',
                        'Ausente' => 'bg-red-500',
                        'Permiso' => 'bg-blue-500',
                        ];
                        @endphp
                        <span class="px-2 py-1 text-white rounded {{ $colores[$asistencia->estado] ?? 'bg-gray-500' }}">
                            {{ $asistencia->estado }}
                        </span>
                    </td>
                    <td class="px-6 py-4">{{ $asistencia->observacion ?? '-' }}</td>
                    <td class="px-6 py-4 flex gap-2">
                        <a href="{{ route('asistencias.edit', $asistencia->id) }}" class="px-3 py-1 bg-yellow-400 rounded hover:bg-yellow-500 text-white flex items-center gap-1">
                            <i class="fa-solid fa-pen"></i> Editar
                        </a>
                        <form action="{{ route('asistencias.destroy', $asistencia->id) }}" method="POST" onsubmit="return confirm('¿Seguro que quieres eliminar esta asistencia?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-1 bg-red-500 rounded hover:bg-red-600 text-white flex items-center gap-1">
                                <i class="fa-solid fa-trash"></i> Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $asistencias->links() }}
    </div>
</div>
@endsection
