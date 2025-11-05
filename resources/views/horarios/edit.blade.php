@extends('layouts.app')

@section('content')
<div class="p-6 bg-gray-100 min-h-screen">
    <h1 class="text-2xl font-bold mb-6">Editar Horario</h1>

    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-200 text-red-800 rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('horarios.update', $horario->id) }}" method="POST" class="bg-white p-6 rounded shadow max-w-md">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Empleado</label>
            <select name="empleado_id" class="w-full border rounded px-3 py-2">
                @foreach($empleados as $empleado)
                    <option value="{{ $empleado->id }}" {{ $horario->empleado_id == $empleado->id ? 'selected' : '' }}>
                        {{ $empleado->nombre_completo }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Día de la semana</label>
            <select name="dia_semana" class="w-full border rounded px-3 py-2">
                @foreach(['Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo'] as $dia)
                    <option value="{{ $dia }}" {{ $horario->dia_semana == $dia ? 'selected' : '' }}>{{ $dia }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Hora de entrada</label>
            <input type="time" name="hora_entrada" value="{{ $horario->hora_entrada }}" class="w-full border rounded px-3 py-2">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Hora de salida</label>
            <input type="time" name="hora_salida" value="{{ $horario->hora_salida }}" class="w-full border rounded px-3 py-2">
        </div>

        <div class="flex justify-end gap-2">
            <a href="{{ route('horarios.index') }}" class="px-4 py-2 bg-gray-400 rounded hover:bg-gray-500 text-white">Cancelar</a>
            <button type="submit" class="px-4 py-2 bg-green-600 rounded hover:bg-green-700 text-white">Actualizar</button>
        </div>
    </form>
</div>
@endsection

