<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Lista de Puestos Disponibles') }}
            </h2>
            <a class="px-3 py-2 bg-indigo-600 font-bold text-white rounded-lg hover:bg-indigo-700 transition"
               href="{{ route('puesto_disponibles.crear') }}">
               <i class="fa-solid fa-plus mr-1"></i> CREAR PUESTO DISPONIBLE
            </a>
        </div>
    </x-slot>

    <title>Puestos Disponibles</title>

    <div class="m-5 bg-white shadow-lg rounded-xl overflow-hidden">
        <table class="min-w-full border-collapse block md:table">
            <thead class="block md:table-header-group bg-gray-600 text-white">
                <tr class="md:table-row block">
                    <th class="p-3 text-left font-bold md:table-cell">Nombre</th>
                    <th class="p-3 text-left font-bold md:table-cell">Área</th>
                    <th class="p-3 text-left font-bold md:table-cell">Ubicación</th>
                    <th class="p-3 text-left font-bold md:table-cell">Tipo de Contrato</th>
                    <th class="p-3 text-left font-bold md:table-cell">Vacantes</th>
                    <th class="p-3 text-left font-bold md:table-cell">Fecha Límite</th>
                    <th class="p-3 text-left font-bold md:table-cell">Estado</th>
                    <th class="p-3 text-left font-bold md:table-cell">Acciones</th>
                </tr>
            </thead>

            <tbody class="block md:table-row-group">
                @forelse ($puesto_disponibles as $puesto)
                    <tr class="bg-white border border-gray-300 md:border-none block md:table-row hover:bg-gray-100 transition">
                       
                        <!-- Nombre -->
                        <td class="p-3 md:border md:border-gray-300 text-left block md:table-cell">
                            <span class="inline-block w-1/3 md:hidden font-bold">Nombre</span>
                            {{ $puesto->nombre }}
                        </td>

                        <!-- Área -->
                        <td class="p-3 md:border md:border-gray-300 text-left block md:table-cell">
                            <span class="inline-block w-1/3 md:hidden font-bold">Área</span>
                            {{ $puesto->area }}
                        </td>

                        <!-- Ubicación -->
                        <td class="p-3 md:border md:border-gray-300 text-left block md:table-cell">
                            <span class="inline-block w-1/3 md:hidden font-bold">Ubicación</span>
                            {{ $puesto->ubicacion }}
                        </td>

                        <!-- Tipo de Contrato -->
                        <td class="p-3 md:border md:border-gray-300 text-left block md:table-cell">
                            <span class="inline-block w-1/3 md:hidden font-bold">Contrato</span>
                            {{ $puesto->tipo_contrato }}
                        </td>

                        <!-- Vacantes -->
                        <td class="p-3 md:border md:border-gray-300 text-left block md:table-cell text-center">
                            <span class="inline-block w-1/3 md:hidden font-bold">Vacantes</span>
                            {{ $puesto->vacantes }}
                        </td>

                        <!-- Fecha límite -->
                        <td class="p-3 md:border md:border-gray-300 text-left block md:table-cell">
                            <span class="inline-block w-1/3 md:hidden font-bold">Fecha Límite</span>
                            {{ \Carbon\Carbon::parse($puesto->fecha_limite)->format('d/m/Y') }}
                        </td>

                        <!-- Estado -->
                        <td class="p-3 md:border md:border-gray-300 text-left block md:table-cell">
                            <span class="inline-block w-1/3 md:hidden font-bold">Estado</span>
                            <span class="px-3 py-1 rounded-full text-sm font-semibold 
                                {{ $puesto->estado === 'Activo' ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }}">
                                {{ $puesto->estado }}
                            </span>
                        </td>

                        <!-- Acciones -->
                        <td class="p-3 md:border md:border-gray-300 text-left block md:table-cell">
                            <div class="flex gap-2 justify-start">
                                <!-- Editar -->
                                <a href="{{ route('puesto_disponibles.editar', $puesto->id) }}"
                                   class="bg-green-500 hover:bg-green-600 text-white px-3 py-2 rounded-lg"
                                   title="Editar">
                                   <i class="fa-regular fa-pen-to-square"></i>
                                </a>

                                <!-- Eliminar -->
                                <form id="formEliminar_{{ $puesto->id }}"
                                      action="{{ route('puesto_disponibles.eliminar', $puesto->id) }}"
                                      method="POST">
                                    @csrf
                                    <button type="button"
                                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg"
                                            title="Eliminar"
                                            onclick="confirmarEliminacion('{{ $puesto->id }}')">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr class="bg-white border border-gray-300 md:border-none block md:table-row">
                        <td colspan="9" class="text-center p-5 text-gray-500 font-semibold">
                            No hay puestos disponibles registrados.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Script de confirmación y notificaciones -->
    <script>
        @if (Session::has('eliminado'))
            toastr.options = {"closeButton": true,"progressBar": true};
            toastr.success("{{ session('eliminado') }}");
        @endif

        @if (Session::has('actualizado'))
            toastr.options = {"closeButton": true,"progressBar": true};
            toastr.success("{{ session('actualizado') }}");
        @endif

        @if (Session::has('creado'))
            toastr.options = {"closeButton": true,"progressBar": true};
            toastr.success("{{ session('creado') }}");
        @endif

        function confirmarEliminacion(id) {
            if (confirm("¿Estás seguro de que deseas eliminar este puesto disponible?")) {
                document.getElementById('formEliminar_' + id).submit();
            }
        }
    </script>
</x-app-layout>
