<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Puesto Disponible') }}
        </h2>
    </x-slot>

    <title>Editar_Puesto_Disponible</title>

    <form action="{{ route('puesto_disponibles.actualizar', $puesto_disponibles->id) }}" method="POST">
        @csrf
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg m-5">
            <div class="grid lg:grid-cols-3 grid-cols-1 gap-4 p-5">
                <div class="col-span-1">
                    <label class="font-bold text-lg" for=""> Nombre</label>
                    <input id="nombre" name = "nombre" type="text" class="px3 py2 w-full rounded-xl bg-blue-100" value="{{ $puesto_disponibles->nombre }}">
                    @error('nombre')
                        <strong class = "text-red-500">Debes ingresar tu nombre</strong>
                    @enderror
                </div>
                <div class="col-span-1">
                    <label class="font-bold text-lg" for=""> Información</label>
                    <input id="informacion" name = "informacion" type="text" class="px3 py2 w-full rounded-xl bg-blue-100" value="{{ $puesto_disponibles->informacion }}">
                    @error('informacion')
                        <strong class = "text-red-500">Debes ingresar la Información</strong>
                    @enderror
                </div>
                <div class="col-span-1">
                    <label class="font-bold text-lg" for=""> Puestos Disponibles</label>
                    <input id="disponible" name = "disponible" type="text" class="px3 py2 w-full rounded-xl bg-blue-100" value="{{ $puesto_disponibles->disponible }}">
                    @error('disponible')
                        <strong class = "text-red-500">Debes ingresar la Puestos Disponibles</strong>
                    @enderror
                </div>
                
                <div class = "p-5">
                    <button type ="submit" class="bg-blue-600 text-white fond-bold px-5 py-3 rounded-lg">
                        <i class= "fa-solid fa-floppy-disk">Guardar</i>
                    </button>
                </div>

            </div>

        </div>
    </form>

</x-app-layout>
