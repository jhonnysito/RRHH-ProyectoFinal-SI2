@extends('layouts.app')

@section('content')
<div class="p-6 bg-gray-100 min-h-screen">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Editar Asistencia</h1>

    <div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow">
        <form action="{{ route('asistencias.update', $asistencia->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label for="empleado_id" class="block font-semibold text-gray-700 mb-2">Empleado</label>
                <select name="empleado_id" id="empleado_id" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-400">
                    @foreach($empleados as $empleado)
                        <option value="{{ $empleado->id }}" {{ $empleado->id == $asistencia->empleado_id ? 'selected' : '' }}>
                            {{ $empleado->nombre_completo }}
                        </option>
                    @endforeach
                </select>
                @error('empleado_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="fecha" class="block font-semibold text-gray-700 mb-2">Fecha</label>
                    <input type="date" name="fecha" id="fecha" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-400" value="{{ old('fecha', $asistencia->fecha) }}">
                    @error('fecha') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="estado" class="block font-semibold text-gray-700 mb-2">Estado</label>
                    <select name="estado" id="estado" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-400">
                        @foreach(['Presente','Tarde','Ausente','Permiso'] as $estado)
                            <option value="{{ $estado }}" {{ $asistencia->estado == $estado ? 'selected' : '' }}>
                                {{ $estado }}
                            </option>
                        @endforeach
                    </select>
                    @error('estado') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="hora_entrada" class="block font-semibold text-gray-700 mb-2">Hora de Entrada</label>
                    <input type="time" name="hora_entrada" id="hora_entrada" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-400" value="{{ old('hora_entrada', $asistencia->hora_entrada) }}">
                    @error('hora_entrada') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="hora_salida" class="block font-semibold text-gray-700 mb-2">Hora de Salida</label>
                    <input type="time" name="hora_salida" id="hora_salida" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-400" value="{{ old('hora_salida', $asistencia->hora_salida) }}">
                    @error('hora_salida') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <div>
                <label for="observacion" class="block font-semibold text-gray-700 mb-2">Observación</label>
                <textarea name="observacion" id="observacion" rows="3" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-400">{{ old('observacion', $asistencia->observacion) }}</textarea>
                @error('observacion') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="flex justify-between items-center mt-6">
                <a href="{{ route('asistencias.index') }}" class="text-gray-600 hover:underline">
                    <i class="fa-solid fa-arrow-left"></i> Volver
                </a>
                <button type="submit" class="px-5 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 flex items-center gap-2">
                    <i class="fa-solid fa-save"></i> Actualizar Asistencia
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
