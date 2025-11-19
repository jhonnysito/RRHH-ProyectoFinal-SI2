<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Planes de Suscripción') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    Elige el plan perfecto para tu empresa
                </h2>
                <p class="mt-4 text-lg text-gray-500">
                    Comienza gratis o mejora para obtener más potencia.
                </p>
            </div>

            <div class="mt-12 space-y-4 sm:mt-16 sm:space-y-0 sm:grid sm:grid-cols-3 sm:gap-6 lg:max-w-4xl lg:mx-auto xl:max-w-none xl:mx-0 xl:grid-cols-3">
                
                <!-- PLAN BÁSICO -->
                <div class="border border-gray-200 rounded-lg shadow-sm divide-y divide-gray-200 bg-white">
                    <div class="p-6">
                        <h2 class="text-lg leading-6 font-medium text-gray-900">Básico</h2>
                        <p class="mt-4 text-sm text-gray-500">Para pequeñas empresas.</p>
                        <p class="mt-8">
                            <span class="text-4xl font-extrabold text-gray-900">$10</span>
                            <span class="text-base font-medium text-gray-500">/mes</span>
                        </p>
                        <a href="{{ route('suscripcion.pagar', 'basico') }}" class="mt-8 block w-full bg-indigo-600 border border-transparent rounded-md py-2 text-sm font-semibold text-white text-center hover:bg-indigo-700">
                            Suscribirse al Básico
                        </a>
                    </div>
                </div>

                <!-- PLAN MEDIO -->
                <div class="border border-indigo-200 rounded-lg shadow-lg divide-y divide-gray-200 bg-white ring-2 ring-indigo-500">
                    <div class="p-6">
                        <h2 class="text-lg leading-6 font-medium text-gray-900">Profesional</h2>
                        <p class="mt-4 text-sm text-gray-500">Para empresas en crecimiento.</p>
                        <p class="mt-8">
                            <span class="text-4xl font-extrabold text-gray-900">$25</span>
                            <span class="text-base font-medium text-gray-500">/mes</span>
                        </p>
                        <a href="{{ route('suscripcion.pagar', 'medio') }}" class="mt-8 block w-full bg-indigo-600 border border-transparent rounded-md py-2 text-sm font-semibold text-white text-center hover:bg-indigo-700">
                            Suscribirse al Pro
                        </a>
                    </div>
                </div>

                <!-- PLAN AVANZADO -->
                <div class="border border-gray-200 rounded-lg shadow-sm divide-y divide-gray-200 bg-white">
                    <div class="p-6">
                        <h2 class="text-lg leading-6 font-medium text-gray-900">Empresarial</h2>
                        <p class="mt-4 text-sm text-gray-500">Para grandes corporaciones.</p>
                        <p class="mt-8">
                            <span class="text-4xl font-extrabold text-gray-900">$40</span>
                            <span class="text-base font-medium text-gray-500">/mes</span>
                        </p>
                        <a href="{{ route('suscripcion.pagar', 'avanzado') }}" class="mt-8 block w-full bg-indigo-600 border border-transparent rounded-md py-2 text-sm font-semibold text-white text-center hover:bg-indigo-700">
                            Suscribirse al Avanzado
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>