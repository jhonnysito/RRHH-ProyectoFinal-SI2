<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Generador de Reportes Dinámicos
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <!-- Formulario para prompt de texto -->
                <form action="{{ route('reportes.generar_dinamico') }}" method="POST" class="space-y-4">
                    @csrf
                    <label for="prompt" class="block font-medium text-gray-700">Escribe o dicta tu reporte:</label>
                    <textarea name="prompt" id="prompt" rows="3"
                              class="w-full border border-gray-300 rounded-md p-2"
                              placeholder="Ej: Mostrar empleados del departamento Ventas con cargo Gerente">{{ $prompt ?? '' }}</textarea>

                    <button type="submit"
                            class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                        Generar Reporte
                    </button>
                </form>

                <!-- Botón de reconocimiento de voz (opcional) -->
                <button id="start-record-btn"
                        class="mt-2 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    🎤 Hablar
                </button>

                <!-- Tabla de resultados -->
                @isset($empleados_filtrados)
                    <div class="mt-6">
                        <h3 class="font-semibold text-lg text-gray-800 mb-4">Empleados Filtrados:</h3>
                        <table class="table-auto w-full border border-gray-300">
                            <thead>
                                <tr class="bg-gray-200">
                                    <th class="px-4 py-2">Nombre completo</th>
                                    <th class="px-4 py-2">Email</th>
                                    <th class="px-4 py-2">Departamento</th>
                                    <th class="px-4 py-2">Cargo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($empleados_filtrados as $empleado)
                                    <tr>
                                        <td class="border px-4 py-2">{{ $empleado->nombre_completo }}</td>
                                        <td class="border px-4 py-2">{{ $empleado->email }}</td>
                                        <td class="border px-4 py-2">{{ $empleado->departamento->nombre ?? '-' }}</td>
                                        <td class="border px-4 py-2">{{ $empleado->cargo->nombre ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endisset

            </div>
        </div>
    </div>

    <!-- JS para reconocimiento de voz -->
    <script>
        const startRecordBtn = document.getElementById('start-record-btn');
        const promptInput = document.getElementById('prompt');

        startRecordBtn.addEventListener('click', () => {
            const recognition = new (window.SpeechRecognition || window.webkitSpeechRecognition)();
            recognition.lang = 'es-ES';
            recognition.start();

            recognition.onresult = (event) => {
                promptInput.value = event.results[0][0].transcript;
            };
        });
    </script>
</x-app-layout>
