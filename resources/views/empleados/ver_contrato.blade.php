<x-app-layout>
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold mb-4 text-gray-800">📄 Detalle del Contrato</h2>

        @if($empleado->contratos->isEmpty())
            <div class="text-center py-10">
                <p class="text-gray-600">⚠️ Este empleado no tiene contratos registrados aún.</p>
            </div>
        @else
            @php
                $contrato = $empleado->contratos->last(); // Tomamos el contrato más reciente
            @endphp

            <!-- ✅ Datos del empleado -->
            <div class="mb-6 border-b pb-4">
                <h3 class="text-lg font-semibold text-gray-700 mb-2">Información del Empleado</h3>
                <p><strong>Nombre completo:</strong> {{ $empleado->nombre_completo }}</p>
                <p><strong>CI:</strong> {{ $empleado->ci }}</p>
                <p><strong>Correo electrónico:</strong> {{ $empleado->correo }}</p>
                <p><strong>Dirección:</strong> {{ $empleado->direccion }}</p>
                <p><strong>Teléfono:</strong> {{ $empleado->telefono }}</p>
                <p><strong>Cargo:</strong> {{ $empleado->cargo->nombre ?? 'Sin cargo' }}</p>
                <p><strong>Departamento:</strong> {{ $empleado->departamento->nombre ?? 'Sin departamento' }}</p>
            </div>

            <!-- ✅ Datos del contrato -->
            <div class="mb-4">
                <h3 class="text-lg font-semibold text-gray-700 mb-2">Detalles del Contrato</h3>
                <p><strong>Sueldo:</strong> {{ number_format($contrato->sueldo, 2) }} Bs</p>
                <p><strong>Fecha de Inicio:</strong> {{ \Carbon\Carbon::parse($contrato->fecha_inicio)->format('d/m/Y') }}</p>
                <p><strong>Fecha de Fin:</strong>
                    {{ $contrato->fecha_fin ? \Carbon\Carbon::parse($contrato->fecha_fin)->format('d/m/Y') : 'No definida' }}
                </p>
                <p><strong>Tipo de Contrato:</strong> {{ $contrato->tipo }}</p>
                <p><strong>Observaciones:</strong> {{ $contrato->observaciones ?? 'Sin observaciones' }}</p>
            </div>

            <!-- ✅ Botones -->
            <div class="flex justify-end space-x-3 mt-6">
                <a href="{{ route('empleados.index') }}"
                   class="bg-gray-500 text-white px-5 py-2 rounded-lg hover:bg-gray-600 transition">
                    ⬅️ Volver
                </a>

                <a href="{{ route('contratos.crear', $empleado->id) }}"
                   class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition">
                    ✏️ Crear nuevo contrato
                </a>
            </div>
        @endif
    </div>
</x-app-layout>
