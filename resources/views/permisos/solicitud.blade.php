<x-app-layout>
    <div class="max-w-3xl mx-auto bg-white shadow p-6 rounded mt-10">

        <h1 class="text-2xl font-bold mb-6 text-center">Solicitar Permiso</h1>

        @if (session('creado'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                {{ session('creado') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
                <strong>Errores encontrados:</strong>
                <ul class="list-disc ml-6">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('permisos.enviar-solicitud') }}" method="POST">
            @csrf

            {{-- Tipo de Permiso --}}
            <div class="mb-4">
                <label class="block font-semibold">Tipo de Permiso</label>
                <select name="incidencia_id" class="w-full border-gray-300 rounded" required>
                    <option value="">Seleccione tipo…</option>

                    @foreach ($incidencias as $inc)
                        <option value="{{ $inc->id }}">{{ $inc->nombre }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Motivo --}}
            <div class="mb-4">
                <label class="block font-semibold">Motivo</label>
                <textarea name="motivo" rows="3" class="w-full border-gray-300 rounded"></textarea>
            </div>

            {{-- Fechas --}}
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block font-semibold">Fecha Inicio</label>
                    <input type="date" name="fecha_inicio" class="w-full border-gray-300 rounded" required>
                </div>

                <div>
                    <label class="block font-semibold">Fecha Fin</label>
                    <input type="date" name="fecha_fin" class="w-full border-gray-300 rounded" required>
                </div>
            </div>

            <button class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                Enviar Solicitud
            </button>
        </form>
    </div>
</x-app-layout>
