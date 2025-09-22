<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear Puesto Disponible') }}
        </h2>
    </x-slot>

    <title>Crear_Puesto_Disponible</title>

    <form action="{{ route('puesto_disponibles.guardar') }}" method="POST" >
        @csrf
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg m-5">
            <div class="grid lg:grid-cols-3 grid-cols-1 gap-4 p-5">
                <div class="col-span-1">
                    <label class="font-bold text-lg" for=""> Nombre</label>
                    <input id="nombre" name = "nombre" type="text" class="px3 py2 w-full rounded-x1 bg-blue-100" 
                    placeholder="Ingresa el nombre" value="{{ old('nombre') }}">
                    @error('nombre')
                        <strong class = "text-red-500">Debes ingresar el nombre</strong>
                    @enderror
                </div>
                <div class="col-span-1">
                    <label class="font-bold text-lg" for=""> Información</label>
                    <input id="informacion" name = "informacion" type="text" class="px3 py2 w-full rounded-x1 bg-blue-100" 
                    placeholder="Ingresa la informacion" value="{{ old('informacion') }}">
                    @error('informacion')
                        <strong class = "text-red-500">Debes ingresar la Información</strong>
                    @enderror
                </div>
                <div class="col-span-1">
                    <label class="font-bold text-lg" for=""> Cantidad de Puestos Disponibles</label>
                    <input id="disponible" name = "disponible" type="text" class="px3 py2 w-full rounded-x1 bg-blue-100" 
                    placeholder="Ingresa la cantidad de puestos disponibles" value="{{ old('disponible') }}">
                    @error('disponible')
                        <strong class = "text-red-500">Debes ingresar la cantidad de Puestos disponibles</strong>
                    @enderror
                </div>
                <div class = "p-5">
                    <button type ="submit" id="registrar" class="bg-blue-600 text-white fond-bold px-6 py-3 rounded-lg">
                        <i class= "fa-solid fa-floppy-disk">GUARDAR</i>
                    </button>
                </div>

            </div>

        </div>
    </form>

</x-app-layout>