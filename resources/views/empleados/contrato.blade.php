<x-app-layout>
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold mb-4 text-gray-800">Crear Contrato</h2>

        <!-- ✅ Datos del empleado -->
        <div class="mb-4 space-y-1">
            <p><strong>Nombre completo:</strong> {{ $empleado->nombre_completo }}</p>
            <p><strong>CI:</strong> {{ $empleado->ci }}</p>
            <p><strong>Correo electrónico:</strong> {{ $empleado->correo }}</p>
            <p><strong>Dirección:</strong> {{ $empleado->direccion }}</p>
            <p><strong>Teléfono:</strong> {{ $empleado->telefono }}</p>
            <p><strong>Cargo:</strong> {{ $empleado->cargo->nombre ?? 'Sin cargo' }}</p>
            <p><strong>Departamento:</strong> {{ $empleado->departamento->nombre ?? 'Sin departamento' }}</p>
        </div>

        <hr class="my-4">

        <!-- ✅ Formulario para crear contrato -->
        <form action="{{ route('contratos.store') }}" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="empleado_id" value="{{ $empleado->id }}">

            <div>
                <label class="block text-sm font-medium text-gray-700">Sueldo (Bs)</label>
                <input type="number" name="sueldo" class="w-full border-gray-300 rounded-md" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Fecha de Inicio</label>
                <input type="date" name="fecha_inicio" class="w-full border-gray-300 rounded-md" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Fecha de Fin</label>
                <input type="date" name="fecha_fin" class="w-full border-gray-300 rounded-md">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Tipo de Contrato</label>
                <select name="tipo" class="w-full border-gray-300 rounded-md" required>
                    <option value="">Seleccione un tipo</option>
                    <option value="Indefinido">indefinido</option>
                    <option value="Anual">anual</option>
                    <option value="Temporal">Temporal</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Observaciones</label>
                <textarea name="observaciones" rows="3" class="w-full border-gray-300 rounded-md"></textarea>
            </div>

            <div class="flex justify-end">
                <button type="submit"
                    class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition">
                    Guardar Contrato
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
