@extends('layouts.app')

@section('content')
<div class="p-6 bg-gray-100 min-h-screen flex justify-center">
    <div class="bg-white p-6 rounded shadow w-full max-w-md">
        <h1 class="text-2xl font-bold mb-6">Crear Horario</h1>

        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-200 text-red-800 rounded shadow">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('horarios.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Empleado</label>
                <select name="empleado_id" class="w-full border rounded px-3 py-2">
                    <option value="">Selecciona un empleado</option>
                    @foreach($empleados as $empleado)
                        <option value="{{ $empleado->id }}">{{ $empleado->nombre_completo }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Día de la semana</label>
                <select name="dia_semana" class="w-full border rounded px-3 py-2">
                    @foreach(['Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo'] as $dia)
                        <option value="{{ $dia }}">{{ $dia }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Hora de entrada</label>
                <input type="time" name="hora_entrada" placeholder="08:00" class="w-full border rounded px-3 py-2">
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Hora de salida</label>
                <input type="time" name="hora_salida" placeholder="17:00" class="w-full border rounded px-3 py-2">
            </div>

            <div class="flex justify-end gap-2">
                <a href="{{ route('horarios.index') }}" class="px-4 py-2 bg-gray-400 rounded hover:bg-gray-500 text-white">Cancelar</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 rounded hover:bg-blue-700 text-white flex items-center gap-1">
                    <i class="fa-solid fa-save"></i> Guardar
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
