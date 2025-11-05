@extends('layouts.app')

@section('content')
<div class="p-6 bg-gray-100 min-h-screen">
    <h1 class="text-3xl font-bold mb-6">Horarios</h1>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-200 text-green-800 rounded shadow">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-4 flex justify-between items-center">
        @can('Agregar Horarios')
        <a href="{{ route('horarios.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 flex items-center gap-2">
            <i class="fa-solid fa-plus"></i> Nuevo Horario
        </a>
        @endcan

        
        <form method="GET" action="{{ route('horarios.index') }}" class="flex gap-2">
            <input type="text" name="search" placeholder="Buscar empleado..."
                value="{{ request('search') }}"
                class="border rounded px-3 py-2 w-60">
            <button type="submit" class="px-3 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
        </form>
    </div>

    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Empleado</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Día</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Entrada</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Salida</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Horas</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($horarios as $horario)
                <tr class="even:bg-gray-50 hover:bg-gray-100 transition duration-150">
                    <td class="px-6 py-4">{{ $horario->empleado->nombre_completo ?? 'Sin empleado' }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 rounded text-white 
                            {{ in_array($horario->dia_semana, ['Sábado','Domingo']) ? 'bg-orange-500' : 'bg-blue-500' }}">
                            {{ $horario->dia_semana }}
                        </span>
                    </td>
                    <td class="px-6 py-4">{{ $horario->hora_entrada }}</td>
                    <td class="px-6 py-4">{{ $horario->hora_salida }}</td>
                    <td class="px-6 py-4">
                        @php
                            $entrada = \Carbon\Carbon::createFromFormat('H:i:s', $horario->hora_entrada);
                            $salida = \Carbon\Carbon::createFromFormat('H:i:s', $horario->hora_salida);
                        @endphp
                        {{ $salida->diffInHours($entrada) }} h
                    </td>
                    <td class="px-6 py-4 flex gap-2">
                        @can('Editar Horarios')
                        <a href="{{ route('horarios.edit', $horario->id) }}" class="px-3 py-1 bg-yellow-400 rounded hover:bg-yellow-500 text-white flex items-center gap-1">
                            <i class="fa-solid fa-pen"></i> Editar
                        </a>
                        @endcan
                        @can('Eliminar Horarios')
                        <form action="{{ route('horarios.destroy', $horario->id) }}" method="POST" onsubmit="return confirm('¿Seguro que quieres eliminar este horario?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-1 bg-red-500 rounded hover:bg-red-600 text-white flex items-center gap-1">
                                <i class="fa-solid fa-trash"></i> Eliminar
                            </button>
                        </form>
                        @endcan
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
