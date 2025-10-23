<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear Puesto Disponible') }}
        </h2>
    </x-slot>

    <title>Crear_Puesto_Disponible</title>

    <form action="{{ route('puesto_disponibles.guardar') }}" method="POST">
        @csrf
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg m-5">
            <div class="grid lg:grid-cols-3 grid-cols-1 gap-4 p-5">

                <!-- Nombre del Puesto -->
                <div class="col-span-1">
                    <label class="font-bold text-lg">Nombre del Puesto</label>
                    <input id="nombre" name="nombre" type="text"
                        class="px-3 py-2 w-full rounded-xl bg-blue-100"
                        placeholder="Ej: Analista de Recursos Humanos"
                        value="{{ old('nombre') }}" required>
                    @error('nombre')
                        <strong class="text-red-500">Debes ingresar el nombre del puesto</strong>
                    @enderror
                </div>

                <!-- Área o Departamento -->
                <div class="col-span-1">
                    <label class="font-bold text-lg">Área o Departamento</label>
                    <input id="area" name="area" type="text"
                        class="px-3 py-2 w-full rounded-xl bg-blue-100"
                        placeholder="Ej: Finanzas, Tecnología, RRHH"
                        value="{{ old('area') }}" required>
                    @error('area')
                        <strong class="text-red-500">Debes ingresar el área</strong>
                    @enderror
                </div>

                <!-- Tipo de Contrato -->
                <div class="col-span-1">
                    <label class="font-bold text-lg">Tipo de Contrato</label>
                    <select id="tipo_contrato" name="tipo_contrato"
                        class="px-3 py-2 w-full rounded-xl bg-blue-100" required>
                        <option value="">Selecciona una opción</option>
                        <option value="Tiempo completo">Tiempo completo</option>
                        <option value="Medio tiempo">Medio tiempo</option>
                        <option value="Temporal">Temporal</option>
                        <option value="Prácticas">Prácticas</option>
                    </select>
                    @error('tipo_contrato')
                        <strong class="text-red-500">Debes seleccionar un tipo de contrato</strong>
                    @enderror
                </div>

                <!-- Ubicación -->
                <div class="col-span-1">
                    <label class="font-bold text-lg">Ubicación</label>
                    <input id="ubicacion" name="ubicacion" type="text"
                        class="px-3 py-2 w-full rounded-xl bg-blue-100"
                        placeholder="Ej: La Paz, Cochabamba, Santa Cruz"
                        value="{{ old('ubicacion') }}" required>
                    @error('ubicacion')
                        <strong class="text-red-500">Debes ingresar la ubicación</strong>
                    @enderror
                </div>

                <!-- Modalidad -->
                <div class="col-span-1">
                    <label class="font-bold text-lg">Modalidad</label>
                    <select id="modalidad" name="modalidad"
                        class="px-3 py-2 w-full rounded-xl bg-blue-100">
                        <option value="">Selecciona una opción</option>
                        <option value="Presencial">Presencial</option>
                        <option value="Híbrido">Híbrido</option>
                        <option value="Remoto">Remoto</option>
                    </select>
                </div>

                <!-- Nivel del Puesto -->
                <div class="col-span-1">
                    <label class="font-bold text-lg">Nivel del Puesto</label>
                    <select id="nivel" name="nivel"
                        class="px-3 py-2 w-full rounded-xl bg-blue-100">
                        <option value="">Selecciona un nivel</option>
                        <option value="Junior">Junior</option>
                        <option value="Semi-senior">Semi-senior</option>
                        <option value="Senior">Senior</option>
                    </select>
                </div>

                <!-- Salario -->
                <div class="col-span-1">
                    <label class="font-bold text-lg">Salario o Rango Salarial</label>
                    <input id="salario" name="salario" type="text"
                        class="px-3 py-2 w-full rounded-xl bg-blue-100"
                        placeholder="Ej: 4000 - 6000 Bs"
                        value="{{ old('salario') }}">
                </div>

                <!-- Fecha límite -->
                <div class="col-span-1">
                    <label class="font-bold text-lg">Fecha Límite de Postulación</label>
                    <input id="fecha_limite" name="fecha_limite" type="date"
                        class="px-3 py-2 w-full rounded-xl bg-blue-100"
                        value="{{ old('fecha_limite') }}" required>
                </div>

                <!-- Cantidad de vacantes -->
                <div class="col-span-1">
                    <label class="font-bold text-lg">Cantidad de Vacantes</label>
                    <input id="vacantes" name="vacantes" type="number"
                        class="px-3 py-2 w-full rounded-xl bg-blue-100"
                        placeholder="Ej: 2"
                        value="{{ old('vacantes') }}" required>
                </div>

                <!-- Estado -->
                <div class="col-span-1">
                    <label class="font-bold text-lg">Estado</label>
                    <select id="estado" name="estado"
                        class="px-3 py-2 w-full rounded-xl bg-blue-100" required>
                        <option value="Activo">Activo</option>
                        <option value="Inactivo">Inactivo</option>
                    </select>
                </div>

                <!-- Descripción -->
                <div class="col-span-3">
                    <label class="font-bold text-lg">Descripción del Puesto</label>
                    <textarea id="descripcion" name="descripcion"
                        class="px-3 py-2 w-full rounded-xl bg-blue-100"
                        placeholder="Describe las funciones y responsabilidades del puesto"
                        rows="4" required>{{ old('descripcion') }}</textarea>
                </div>

                <!-- Requisitos -->
                <div class="col-span-3">
                    <label class="font-bold text-lg">Requisitos</label>
                    <textarea id="requisitos" name="requisitos"
                        class="px-3 py-2 w-full rounded-xl bg-blue-100"
                        placeholder="Ej: Título universitario, experiencia mínima, conocimientos específicos"
                        rows="3" required>{{ old('requisitos') }}</textarea>
                </div>

                <!-- Beneficios -->
                <div class="col-span-3">
                    <label class="font-bold text-lg">Beneficios</label>
                    <textarea id="beneficios" name="beneficios"
                        class="px-3 py-2 w-full rounded-xl bg-blue-100"
                        placeholder="Ej: Seguro médico, bonos, capacitaciones"
                        rows="3">{{ old('beneficios') }}</textarea>
                </div>

                <!-- Botón -->
                <div class="col-span-3 text-center p-5">
                    <button type="submit" id="registrar"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-6 py-3 rounded-lg transition">
                        <i class="fa-solid fa-floppy-disk mr-2"></i> GUARDAR
                    </button>
                </div>

            </div>
        </div>
    </form>

</x-app-layout>
