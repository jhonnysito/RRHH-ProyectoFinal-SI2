<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Puesto Disponible') }}
        </h2>
    </x-slot>

    <title>Editar Puesto Disponible</title>

    <form action="{{ route('puesto_disponibles.actualizar', $puesto_disponibles->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg m-5 p-5 grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- Nombre -->
            <div>
                <label class="font-bold text-lg" for="nombre">Nombre del Puesto</label>
                <input id="nombre" name="nombre" type="text" class="px-3 py-2 w-full rounded-xl bg-blue-100"
                       value="{{ old('nombre', $puesto_disponibles->nombre) }}">
                @error('nombre')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <!-- Área -->
            <div>
                <label class="font-bold text-lg" for="area">Área o Departamento</label>
                <input id="area" name="area" type="text" class="px-3 py-2 w-full rounded-xl bg-blue-100"
                       value="{{ old('area', $puesto_disponibles->area) }}">
                @error('area')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <!-- Ubicación -->
            <div>
                <label class="font-bold text-lg" for="ubicacion">Ubicación</label>
                <input id="ubicacion" name="ubicacion" type="text" class="px-3 py-2 w-full rounded-xl bg-blue-100"
                       value="{{ old('ubicacion', $puesto_disponibles->ubicacion) }}">
                @error('ubicacion')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tipo de Contrato -->
            <div>
                <label class="font-bold text-lg" for="tipo_contrato">Tipo de Contrato</label>
                <select id="tipo_contrato" name="tipo_contrato" class="px-3 py-2 w-full rounded-xl bg-blue-100">
                    <option value="Tiempo Completo" {{ $puesto_disponibles->tipo_contrato == 'Tiempo Completo' ? 'selected' : '' }}>Tiempo Completo</option>
                    <option value="Medio Tiempo" {{ $puesto_disponibles->tipo_contrato == 'Medio Tiempo' ? 'selected' : '' }}>Medio Tiempo</option>
                    <option value="Por Proyecto" {{ $puesto_disponibles->tipo_contrato == 'Por Proyecto' ? 'selected' : '' }}>Por Proyecto</option>
                    <option value="Temporal" {{ $puesto_disponibles->tipo_contrato == 'Temporal' ? 'selected' : '' }}>Temporal</option>
                </select>
                @error('tipo_contrato')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <!-- Modalidad -->
            <div>
                <label class="font-bold text-lg" for="modalidad">Modalidad</label>
                <select id="modalidad" name="modalidad" class="px-3 py-2 w-full rounded-xl bg-blue-100">
                    <option value="">Selecciona</option>
                    <option value="Presencial" {{ $puesto_disponibles->modalidad == 'Presencial' ? 'selected' : '' }}>Presencial</option>
                    <option value="Híbrido" {{ $puesto_disponibles->modalidad == 'Híbrido' ? 'selected' : '' }}>Híbrido</option>
                    <option value="Remoto" {{ $puesto_disponibles->modalidad == 'Remoto' ? 'selected' : '' }}>Remoto</option>
                </select>
            </div>

            <!-- Nivel -->
            <div>
                <label class="font-bold text-lg" for="nivel">Nivel del Puesto</label>
                <select id="nivel" name="nivel" class="px-3 py-2 w-full rounded-xl bg-blue-100">
                    <option value="">Selecciona</option>
                    <option value="Junior" {{ $puesto_disponibles->nivel == 'Junior' ? 'selected' : '' }}>Junior</option>
                    <option value="Semi Senior" {{ $puesto_disponibles->nivel == 'Semi Senior' ? 'selected' : '' }}>Semi Senior</option>
                    <option value="Senior" {{ $puesto_disponibles->nivel == 'Senior' ? 'selected' : '' }}>Senior</option>
                </select>
            </div>

            <!-- Salario -->
            <div>
                <label class="font-bold text-lg" for="salario">Salario o Rango Salarial</label>
                <input id="salario" name="salario" type="text" class="px-3 py-2 w-full rounded-xl bg-blue-100"
                       value="{{ old('salario', $puesto_disponibles->salario) }}">
            </div>

            <!-- Vacantes -->
            <div>
                <label class="font-bold text-lg" for="vacantes">Cantidad de Vacantes</label>
                <input id="vacantes" name="vacantes" type="number" class="px-3 py-2 w-full rounded-xl bg-blue-100"
                       value="{{ old('vacantes', $puesto_disponibles->vacantes) }}">
                @error('vacantes')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <!-- Fecha límite -->
            <div>
                <label class="font-bold text-lg" for="fecha_limite">Fecha Límite de Postulación</label>
                <input id="fecha_limite" name="fecha_limite" type="date" class="px-3 py-2 w-full rounded-xl bg-blue-100"
                      value="{{ old('fecha_limite', \Carbon\Carbon::parse($puesto_disponibles->fecha_limite)->format('Y-m-d')) }}"
                @error('fecha_limite')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <!-- Estado -->
            <div>
                <label class="font-bold text-lg" for="estado">Estado</label>
                <select id="estado" name="estado" class="px-3 py-2 w-full rounded-xl bg-blue-100">
                    <option value="Activo" {{ $puesto_disponibles->estado == 'Activo' ? 'selected' : '' }}>Activo</option>
                    <option value="Inactivo" {{ $puesto_disponibles->estado == 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
                </select>
            </div>

            <!-- Descripción -->
            <div class="col-span-1 md:col-span-2">
                <label class="font-bold text-lg" for="descripcion">Descripción del Puesto</label>
                <textarea id="descripcion" name="descripcion" class="w-full px-3 py-2 rounded-xl bg-blue-100" rows="4">{{ old('descripcion', $puesto_disponibles->descripcion) }}</textarea>
            </div>

            <!-- Requisitos -->
            <div class="col-span-1 md:col-span-2">
                <label class="font-bold text-lg" for="requisitos">Requisitos</label>
                <textarea id="requisitos" name="requisitos" class="w-full px-3 py-2 rounded-xl bg-blue-100" rows="4">{{ old('requisitos', $puesto_disponibles->requisitos) }}</textarea>
            </div>

            <!-- Beneficios -->
            <div class="col-span-1 md:col-span-2">
                <label class="font-bold text-lg" for="beneficios">Beneficios</label>
                <textarea id="beneficios" name="beneficios" class="w-full px-3 py-2 rounded-xl bg-blue-100" rows="4">{{ old('beneficios', $puesto_disponibles->beneficios) }}</textarea>
            </div>

            <!-- Botón Guardar -->
            <div class="col-span-1 md:col-span-2 text-right">
                <button type="submit" class="bg-blue-600 text-white font-bold px-6 py-3 rounded-lg hover:bg-blue-700 transition">
                    <i class="fa-solid fa-floppy-disk mr-1"></i> Guardar
                </button>
            </div>

        </div>
    </form>
</x-app-layout>
