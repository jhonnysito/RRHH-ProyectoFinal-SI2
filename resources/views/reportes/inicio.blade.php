<x-app-layout>
    {{-- 
    ================================================
    INICIO DEL LAYOUT PRINCIPAL
    Aquí SÓLO van las tarjetas y el contenido de la página.
    LOS MODALES VAN AFUERA AL FINAL.
    ================================================
    --}}
    <x-slot name="header">
        <div class = "flex flex-wrap justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('REPORTES') }}
            </h2>
        </div>
    </x-slot>

    <title>Reportes</title>

    {{-- Scripts y Estilos (Alpine y FontAwesome) --}}
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <div class="px-3 md:lg:xl:px-40 py-20 bg-opacity-10">

        {{-- Bloque de Errores (Si el controlador falla) --}}
        @if ($errors->any() || session('error'))
            <div class="mb-5 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">¡Error!</strong>
                <ul class="list-disc list-inside mt-2">
                    @if(session('error'))
                        <li>{{ session('error') }}</li>
                    @endif
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- INICIO DEL GRID DE TARJETAS (SOLO TARJETAS) --}}
        <div class="grid grid-cols-1 md:lg:xl:grid-cols-3 group bg-white shadow-xl shadow-neutral-100 border ">

            {{-- ========= TARJETA EMPLEADOS ========= --}}
            <div class="p-10 flex flex-col items-center text-center group md:lg:xl:border-r md:lg:xl:border-b hover:bg-slate-50 cursor-pointer"
                onclick="toggleModalDiferentes('empleado', 'open')">
                <span class="p-5 rounded-full bg-green-500 text-white shadow-lg shadow-red-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </span>
                <p class="text-xl font-medium text-slate-700 mt-3">Empleados</p>
                <p class="mt-2 text-sm text-slate-500">Reporte de los datos de todos los empleados de la empresa</p>
            </div>

            {{-- ========= TARJETA DEPARTAMENTOS ========= --}}
            <div class="p-10 flex flex-col items-center text-center group md:lg:xl:border-r md:lg:xl:border-b hover:bg-slate-50 cursor-pointer"
                onclick="toggleModalDiferentes('departamento', 'open')">
                <span class="p-5 rounded-full bg-blue-500 text-white shadow-lg shadow-orange-200">
                    <svg class="h-10 w-10 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 4h12M6 4v16M6 4H5m13 0v16m0-16h1m-1 16H6m12 0h1M6 20H5M9 7h1v1H9V7Zm5 0h1v1h-1V7Zm-5 4h1v1H9v-1Zm5 0h1v1h-1v-1Zm-3 4h2a1 1 0 0 1 1 1v4h-4v-4a1 1 0 0 1 1-1Z" />
                    </svg>
                </span>
                <p class="text-xl font-medium text-slate-700 mt-3">Departamentos</p>
                <p class="mt-2 text-sm text-slate-500">Reportes de empleados filtrados por departamentos</p>
            </div>

            {{-- ========= TARJETA POSTULANTES ========= --}}
            <div class="p-10 flex flex-col items-center text-center group md:lg:xl:border-r md:lg:xl:border-b hover:bg-slate-50 cursor-pointer"
                onclick="toggleModalDiferentes('postulante', 'open')">
                <span class="p-5 rounded-full bg-orange-500 text-white shadow-lg shadow-red-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </span>
                <p class="text-xl font-medium text-slate-700 mt-3">Postulantes</p>
                <p class="mt-2 text-sm text-slate-500">Reporte de los datos de los postulantes registrados</p>
            </div>

        </div>
        {{-- FIN DEL GRID DE TARJETAS --}}
    </div>

</x-app-layout>
{{-- 
========================================================
FIN DEL LAYOUT.
LOS MODALES Y EL SCRIPT VAN AFUERA.
========================================================
--}}

{{-- ====================================================== --}}
{{-- ================= MODAL EMPLEADOS ================== --}}
{{-- ====================================================== --}}
<div id="modal_empleado" class="fixed hidden inset-0 z-50 flex items-center justify-center">
    <div class="fixed inset-0 bg-gray-800 opacity-75"></div>
    <!-- Contenido del modal -->
    <div class="max-w-xl rounded overflow-hidden shadow-lg bg-white p-8 z-50" style="width: 36rem" x-data="{ modoReporte: 'estatico' }">
        {{-- BOTÓN CERRAR (CON SVG COMPLETO) --}}
        <button class="float-right -mt-4 -mr-4" onclick="toggleModalDiferentes('empleado', 'close')">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        <p class="text-xl font-semibold p-4">Reporte de Empleados</p>
        <div class="border-b-2 m-0"></div>
        
        <div class="mr-8 ml-4">
            <form action="{{ route('reportes.generar') }}" method="POST" class="relative self-center" target="_blank">
                @csrf
                <input type="hidden" name="tipo_reporte" value="empleados">
                
                {{-- 1. MODO REPORTE --}}
                <p class="p-4 font-medium">1. Seleccione el modo:</p>
                <select name="modo_reporte" x-model="modoReporte" class="w-full border-gray-300 rounded-md shadow-sm">
                    <option value="estatico">Estático (Solo atributos)</option>
                    <option value="dinamico">Dinámico (Por Fechas)</option>
                    <option value="ia">IA (Por Voz)</option>
                </select>

                {{-- 2. FILTROS DINÁMICOS O IA --}}
                <div x-show="modoReporte === 'dinamico'" x-transition class="grid grid-cols-2 gap-4 mt-4 p-4 border rounded-md bg-gray-50">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Fecha de Creación (Inicio)</label>
                        <input type="date" name="fecha_inicio" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Fecha de Creación (Fin)</label>
                        <input type="date" name="fecha_fin" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>
                </div>
                
                <div x-show="modoReporte === 'ia'" x-transition class="mt-4 p-4 border rounded-md bg-gray-50">
                    <label class="block text-sm font-medium text-gray-700">Comando de Voz</label>
                    <div class="flex items-center space-x-2">
                        <textarea id="comando_voz_empleado" name="comando_voz_texto" rows="3" class="flex-1 block w-full rounded-md border-gray-300" placeholder="Ej: Muéstrame el nombre y teléfono de los empleados..."></textarea>
                        <button type="button" id="mic_btn_empleado" class="p-3 bg-blue-500 text-white rounded-full hover:bg-blue-600">
                            <i class="fa-solid fa-microphone"></i>
                        </button>
                    </div>
                </div>

                {{-- 3. ATRIBUTOS (Oculto si es IA) --}}
                <div x-show="modoReporte !== 'ia'" x-transition>
                    <p class="p-4 font-medium">2. Seleccione atributos (si no selecciona, se usarán todos):</p>
                    <div class='flex flex-col mt-2 max-h-40 overflow-y-auto border p-4 rounded-md'>
                        @foreach ($atributos_empleado as $key => $label)
                            <label class="ml-2 flex items-center">
                                <input type="checkbox" name="atributos_empleado[]" value="{{ $key }}" class="rounded"> 
                                <span class="ml-2">{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
                
                {{-- 4. FORMATO --}}
                <div>
                    <p class="p-4 font-medium">3. Seleccione el formato:</p>
                    <select name="formato" class="w-full border-gray-300 rounded-md shadow-sm">
                        <option value="html">HTML (Ver en navegador)</option>
                        <option value="excel">Excel</option>
                        <option value="pdf">PDF</option>
                    </select>
                </div>

                <button type="submit" class="w-full bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 mt-8">
                    Generar Reporte
                </button>
            </form>
        </div>
    </div>
</div>

{{-- ====================================================== --}}
{{-- ================= MODAL DEPARTAMENTOS ============== --}}
{{-- ====================================================== --}}
<div id="modal_departamento" class="fixed hidden inset-0 z-50 flex items-center justify-center">
    <div class="fixed inset-0 bg-gray-800 opacity-75"></div>
    <div class="max-w-xl rounded overflow-hidden shadow-lg bg-white p-8 z-50" style="width: 36rem" x-data="{ modoReporte: 'estatico' }">
        {{-- BOTÓN CERRAR (CON SVG COMPLETO) --}}
        <button class="float-right -mt-4 -mr-4" onclick="toggleModalDiferentes('departamento', 'close')">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        <p class="text-xl font-semibold p-4">Reporte por Departamentos</p>
        <div class="border-b-2 m-0"></div>
        <div class="mr-8 ml-4">
            <form action="{{ route('reportes.generar') }}" method="POST" class="relative self-center" target="_blank">
                @csrf
                <input type="hidden" name="tipo_reporte" value="departamentos">

                {{-- 1. FILTRO DEPARTAMENTOS --}}
                <p class="p-4 font-medium">1. Seleccione departamentos:</p>
                <select name="departamentos_id[]" multiple class="w-full h-32 border-gray-300 rounded-md shadow-sm">
                    @foreach ($departamentos as $dep)
                        <option value="{{ $dep->id }}">{{ $dep->nombre }}</option>
                    @endforeach
                </select>
                <p class="text-xs text-gray-500">Mantén presionado Ctrl (o Cmd) para seleccionar varios.</p>

                {{-- 2. MODO REPORTE --}}
                <p class="p-4 font-medium">2. Seleccione el modo:</p>
                <select name="modo_reporte" x-model="modoReporte" class="w-full border-gray-300 rounded-md shadow-sm">
                    <option value="estatico">Estático (Solo atributos)</option>
                    <option value="dinamico">Dinámico (Por Fechas)</option>
                    <option value="ia">IA (Por Voz)</option>
                </select>

                {{-- 3. FILTROS DINÁMICOS O IA --}}
                <div x-show="modoReporte === 'dinamico'" x-transition class="grid grid-cols-2 gap-4 mt-4 p-4 border rounded-md bg-gray-50">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Fecha de Creación (Inicio)</label>
                        <input type="date" name="fecha_inicio" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Fecha de Creación (Fin)</label>
                        <input type="date" name="fecha_fin" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>
                </div>
                
                <div x-show="modoReporte === 'ia'" x-transition class="mt-4 p-4 border rounded-md bg-gray-50">
                    <label class="block text-sm font-medium text-gray-700">Comando de Voz</label>
                    <div class="flex items-center space-x-2">
                        <textarea id="comando_voz_depto" name="comando_voz_texto" rows="3" class="flex-1 block w-full rounded-md border-gray-300" placeholder="Ej: Muéstrame el nombre y teléfono de los empleados de contabilidad..."></textarea>
                        <button type="button" id="mic_btn_depto" class="p-3 bg-blue-500 text-white rounded-full hover:bg-blue-600">
                            <i class="fa-solid fa-microphone"></i>
                        </button>
                    </div>
                </div>

                {{-- 4. ATRIBUTOS (Oculto si es IA) --}}
                <div x-show="modoReporte !== 'ia'" x-transition>
                    <p class="p-4 font-medium">3. Seleccione atributos (si no selecciona, se usarán todos):</p>
                    <div class='flex flex-col mt-2 max-h-40 overflow-y-auto border p-4 rounded-md'>
                        @foreach ($atributos_empleado as $key => $label)
                            <label class="ml-2 flex items-center">
                                <input type="checkbox" name="atributos_empleado[]" value="{{ $key }}" class="rounded"> 
                                <span class="ml-2">{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
                
                {{-- 5. FORMATO --}}
                <div>
                    <p class="p-4 font-medium">4. Seleccione el formato:</p>
                    <select name="formato" class="w-full border-gray-300 rounded-md shadow-sm">
                        <option value="html">HTML (Ver en navegador)</option>
                        <option value="excel">Excel</option>
                        <option value="pdf">PDF</option>
                    </select>
                </div>

                <button type="submit" class="w-full bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 mt-8">
                    Generar Reporte
                </button>
            </form>
        </div>
    </div>
</div>

{{-- ====================================================== --}}
{{-- ================= MODAL POSTULANTES ================ --}}
{{-- ====================================================== --}}
<div id="modal_postulante" class="fixed hidden inset-0 z-50 flex items-center justify-center">
    <div class="fixed inset-0 bg-gray-800 opacity-75"></div>
    <div class="max-w-xl rounded overflow-hidden shadow-lg bg-white p-8 z-50" style="width: 36rem" x-data="{ modoReporte: 'estatico' }">
        {{-- BOTÓN CERRAR (CON SVG COMPLETO) --}}
        <button class="float-right -mt-4 -mr-4" onclick="toggleModalDiferentes('postulante', 'close')">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        <p class="text-xl font-semibold p-4">Reporte de Postulantes</p>
        <div class="border-b-2 m-0"></div>
        <div class="mr-8 ml-4">
            <form action="{{ route('reportes.generar') }}" method="POST" class="relative self-center" target="_blank">
                @csrf
                <input type="hidden" name="tipo_reporte" value="postulantes">

                {{-- 1. MODO REPORTE --}}
                <p class="p-4 font-medium">1. Seleccione el modo:</p>
                <select name="modo_reporte" x-model="modoReporte" class="w-full border-gray-300 rounded-md shadow-sm">
                    <option value="estatico">Estático (Solo atributos)</option>
                    <option value="dinamico">Dinámico (Por Fechas)</option>
                    <option value="ia">IA (Por Voz)</option>
                </select>

                {{-- 2. FILTROS DINÁMICOS O IA --}}
                <div x-show="modoReporte === 'dinamico'" x-transition class="grid grid-cols-2 gap-4 mt-4 p-4 border rounded-md bg-gray-50">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Fecha de Postulación (Inicio)</label>
                        <input type="date" name="fecha_inicio" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Fecha de Postulación (Fin)</label>
                        <input type="date" name="fecha_fin" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>
                </div>
                
                <div x-show="modoReporte === 'ia'" x-transition class="mt-4 p-4 border rounded-md bg-gray-50">
                    <label class="block text-sm font-medium text-gray-700">Comando de Voz</label>
                    <div class="flex items-center space-x-2">
                        <textarea id="comando_voz_postulante" name="comando_voz_texto" rows="3" class="flex-1 block w-full rounded-md border-gray-300" placeholder="Ej: Muéstrame postulantes con más de 3 años de experiencia..."></textarea>
                        <button type="button" id="mic_btn_postulante" class="p-3 bg-blue-500 text-white rounded-full hover:bg-blue-600">
                            <i class="fa-solid fa-microphone"></i>
                        </button>
                    </div>
                </div>

                {{-- 3. ATRIBUTOS (Oculto si es IA) --}}
                <div x-show="modoReporte !== 'ia'" x-transition>
                    <p class="p-4 font-medium">2. Seleccione atributos (si no selecciona, se usarán todos):</p>
                    <div class='flex flex-col mt-2 max-h-40 overflow-y-auto border p-4 rounded-md'>
                        @foreach ($atributos_postulante as $key => $label)
                            <label class="ml-2 flex items-center">
                                <input type="checkbox" name="atributos_postulante[]" value="{{ $key }}" class="rounded"> 
                                <span class="ml-2">{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
                
                {{-- 4. FORMATO --}}
                <div>
                    <p class="p-4 font-medium">3. Seleccione el formato:</p>
                    <select name="formato" class="w-full border-gray-300 rounded-md shadow-sm">
                        <option value="html">HTML (Ver en navegador)</option>
                        <option value="excel">Excel</option>
                        <option value="pdf">PDF</option>
                    </select>
                </div>

                <button type="submit" class="w-full bg-orange-500 text-white px-4 py-2 rounded-md hover:bg-orange-600 mt-8">
                    Generar Reporte
                </button>
            </form>
        </div>
    </div>
</div>

{{-- 
========================================================
SCRIPT DE JAVASCRIPT (TAMBIÉN VA AFUERA)
========================================================
--}}
<script>
    // Tu script de modal (está perfecto)
    function toggleModal(modalId, action) {
        const modal = document.getElementById(modalId);
        if (action === 'open') {
            modal.classList.remove('hidden');
        } else if (action === 'close') {
            modal.classList.add('hidden');
        }
    }

    function toggleModalDiferentes(entityType, action) {
        const modalId = `modal_${entityType}`;
        toggleModal(modalId, action);
    }

    // --- NUEVO SCRIPT PARA WEB SPEECH API ---
    
    // Función genérica para inicializar el reconocimiento de voz
    function setupSpeechRecognition(buttonId, textareaId) {
        const micButton = document.getElementById(buttonId);
        const textarea = document.getElementById(textareaId);
        
        // Verificar si el navegador soporta la API
        const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
        if (!SpeechRecognition) {
            console.error("Tu navegador no soporta la API de Reconocimiento de Voz.");
            micButton.disabled = true;
            micButton.innerHTML = '<i class="fa-solid fa-microphone-slash"></i>'; // Deshabilitado
            return;
        }

        const recognition = new SpeechRecognition();
        recognition.lang = 'es-ES'; // Configurar a español
        recognition.interimResults = false;
        recognition.maxAlternatives = 1;

        let isRecognizing = false;

        micButton.addEventListener('click', () => {
            if (isRecognizing) {
                recognition.stop();
                isRecognizing = false;
            } else {
                recognition.start();
                isRecognizing = true;
            }
        });

        // Eventos del reconocimiento
        recognition.onstart = () => {
            micButton.classList.add('bg-red-500', 'animate-pulse'); // Indicar que está grabando
            micButton.classList.remove('bg-blue-500');
        };

        recognition.onend = () => {
            micButton.classList.remove('bg-red-500', 'animate-pulse');
            micButton.classList.add('bg-blue-500');
            isRecognizing = false;
        };

        recognition.onresult = (event) => {
            const transcript = event.results[0][0].transcript;
            textarea.value = (textarea.value + ' ' + transcript).trim(); // Añadir al texto existente
        };

        recognition.onerror = (event) => {
            console.error("Error de reconocimiento: ", event.error);
            isRecognizing = false;
        };
    }

    // Inicializar para cada modal una vez que el DOM esté cargado
    document.addEventListener('DOMContentLoaded', () => {
        setupSpeechRecognition('mic_btn_empleado', 'comando_voz_empleado');
        setupSpeechRecognition('mic_btn_depto', 'comando_voz_depto');
        setupSpeechRecognition('mic_btn_postulante', 'comando_voz_postulante');
    });

</script>

