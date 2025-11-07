<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Iniciar nueva conversación con RRHH
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('chat.store') }}">
                        @csrf

                        <!-- Campo Asunto (igual) -->
                        <div>
                            <label for="asunto">Asunto</label>
                            <input id="asunto" type="text" name="asunto" required />
                        </div>

                        <!-- ¡NUEVO! Campo Destinatario -->
                        <div class="mt-4">
                            <label for="destinatario_id">Chatear con (RRHH)</label>
                            <select name="destinatario_id" id="destinatario_id" required>
                                <option value="">-- Selecciona un funcionario --</option>
                                @foreach ($funcionarios_rrhh as $funcionario)
                                    <option value="{{ $funcionario->id }}">
                                        {{ $funcionario->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Campo Mensaje (igual) -->
                        <div class="mt-4">
                            <label for="mensaje">Mensaje</label>
                            <textarea id="mensaje" name="mensaje" required></textarea>
                        </div>

                        <button type="submit">Iniciar Chat</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
