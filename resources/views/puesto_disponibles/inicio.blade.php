<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Lista de Puestos Disponibles') }}
            </h2>
            <a class="px-3 py-2 bg-indigo-600 font-bold text-white rounded-lg"
               href="{{ route('puesto_disponibles.crear') }}">CREAR PUESTO DISPONIBLE</a>
        </div>
    </x-slot>

    <title>Puestos Disponibles</title>

    <table class="min-w-full border-collapse block md:table">
        <thead class="block md:table-header-group">
            <tr class="border border-grey-500 md:border-none block md:table-row absolute -top-full md:top-auto -left-full md:left-auto md:relative">
                <th class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">ID</th>
                <th class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">Nombre</th>
                <th class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">Información</th>
                <th class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">Puestos Disponibles</th>
                <th class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">Acciones</th>
            </tr>
        </thead>
        <tbody class="block md:table-row-group">
            @foreach ($puesto_disponibles as $Puesto_Disponible)
                <tr class="bg-white border border-grey-500 md:border-none block md:table-row">
                    <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell">
                        <span class="inline-block w-1/3 md:hidden font-bold">ID</span>{{ $Puesto_Disponible->id }}
                    </td>
                    <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell">
                        <span class="inline-block w-1/3 md:hidden font-bold">Nombre</span>{{ $Puesto_Disponible->nombre }}
                    </td>
                    <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell">
                        <span class="inline-block w-1/3 md:hidden font-bold">Información</span>{{ $Puesto_Disponible->informacion }}
                    </td>
                    <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell">
                        <span class="inline-block w-1/3 md:hidden font-bold">Puestos Disponibles</span>{{ $Puesto_Disponible->disponible }}
                    </td>
                    <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell">
                        <div class="flex flex-wrap">
                            <span class="inline-block w-1/3 md:hidden font-bold">Acciones</span>

                            <!-- Botón Editar -->
                            <a href="{{ route('puesto_disponibles.editar', $Puesto_Disponible->id) }}"
                               class="bg-green-400 px-2 py-2 rounded-lg" title="Editar">
                               <i class="fa-regular fa-pen-to-square"></i>
                            </a>

                            <!-- Botón Eliminar -->
                            <div>
                                <form id="formEliminar_{{ $Puesto_Disponible->id }}"
                                      action="{{ route('puesto_disponibles.eliminar', $Puesto_Disponible->id) }}"
                                      method="POST">
                                    @csrf
                                    <button type="button" class="bg-red-500 px-2 py-2 rounded-lg" title="Eliminar"
                                            onclick="confirmarEliminacion('{{ $Puesto_Disponible->id }}')">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        @if (Session::has('eliminado'))
            toastr.options = {"closeButton": true,"progressBar": true};
            toastr.success("{{ session('eliminado') }}")
        @endif
        @if (Session::has('actualizado'))
            toastr.options = {"closeButton": true,"progressBar": true};
            toastr.success("{{ session('actualizado') }}")
        @endif
        @if (Session::has('creado'))
            toastr.options = {"closeButton": true,"progressBar": true};
            toastr.success("{{ session('creado') }}")
        @endif
        function confirmarEliminacion(id) {
    if (confirm("¿Estás seguro de que deseas eliminar este puesto disponible?")) {
        document.getElementById('formEliminar_' + id).submit();
    }
}
    </script>
</x-app-layout>

