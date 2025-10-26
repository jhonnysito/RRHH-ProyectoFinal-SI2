<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            📝 Crear Contrato
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                
                <!-- Mensajes de éxito -->
                @if (session('success'))
                    <div class="mb-4 p-3 bg-green-100 text-green-800 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Errores de validación -->
                @if ($errors->any())
                    <div class="mb-4 p-3 bg-red-100 text-red-800 rounded-lg">
                        <ul class="list-disc ml-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Formulario -->
                <form action="{{ route('contratos.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Empleado -->
                    <div>
                        <label for="empleado_id" class="block font-medium text-gray-700">Empleado</label>
                        <input type="hidden" name="empleado_id" value="{{ $empleado->id }}">
                        <input 
                            type="text" 
                            value="{{ $empleado->nombre }} {{ $empleado->apellido }}" 
                            class="w-full border-gray-300 rounded-lg shadow-sm" 
                            readonly
                        >
                    </div>

                    <!-- Sueldo -->
                    <div>
                        <label for="sueldo" class="block font-medium text-gray-700">Sueldo (Bs.)</label>
                        <input 
                            type="number" 
                            step="0.01" 
                            name="sueldo" 
                            id="sueldo" 
                            value="{{ old('sueldo') }}" 
                            class="w-full border-gray-300 rounded-lg shadow-sm" 
                            required
                        >
                    </div>

                    <!-- Fecha inicio -->
                    <div>
                        <label for="fecha_inicio" class="block font-medium text-gray-700">Fecha de Inicio</label>
                        <input 
                            type="date" 
                            name="fecha_inicio" 
                            id="fecha_inicio" 
                            value="{{ old('fecha_inicio') }}" 
                            class="w-full border-gray-300 rounded-lg shadow-sm" 
                            required
                        >
                    </div>

                    <!-- Fecha fin -->
                    <div>
                        <label for="fecha_fin" class="block font-medium text-gray-700">Fecha de Fin (opcional)</label>
                        <input 
                            type="date" 
                            name="fecha_fin" 
                            id="fecha_fin" 
                            value="{{ old('fecha_fin') }}" 
                            class="w-full border-gray-300 rounded-lg shadow-sm"
                        >
                    </div>

                    <!-- Tipo de contrato -->
                    <div>
                        <label for="tipo" class="block font-medium text-gray-700">Tipo de Contrato</label>
                        <select 
                            name="tipo" 
                            id="tipo" 
                            class="w-full border-gray-300 rounded-lg shadow-sm" 
                            required
                        >
                            <option value="indefinido" {{ old('tipo') == 'indefinido' ? 'selected' : '' }}>Indefinido</option>
                            <option value="anual" {{ old('tipo') == 'anual' ? 'selected' : '' }}>Anual</option>
                        </select>
                    </div>

                    <!-- Observaciones -->
                    <div>
                        <label for="observaciones" class="block font-medium text-gray-700">Observaciones</label>
                        <textarea 
                            name="observaciones" 
                            id="observaciones" 
                            rows="3" 
                            class="w-full border-gray-300 rounded-lg shadow-sm"
                            placeholder="Notas adicionales..."
                        >{{ old('observaciones') }}</textarea>
                    </div>

                    <!-- Tenant ID -->
                    <input type="hidden" name="tenant_id" value="{{ auth()->user()->tenant_id }}">

                    <!-- Botón -->
                    <div class="flex justify-end">
                        <a href="{{ route('empleados.index') }}" 
                           class="mr-3 bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded-lg">
                            Cancelar
                        </a>
                        <button type="submit" 
                                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg">
                            💾 Guardar Contrato
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
