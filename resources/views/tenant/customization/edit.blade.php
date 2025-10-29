@extends('layouts.app')

@section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Personalización de la Apariencia') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">

                @if (session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                        <p class="font-bold">Éxito</p>
                        <p>{{ session('success') }}</p>
                    </div>
                @endif

                <form action="{{ route('tenant.customization.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <!-- Columna de Branding -->
                        <div class="space-y-6">
                            <div>
                                <label for="logo" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Logotipo de la Empresa</label>
                                <div class="mt-2 flex items-center gap-4">
                                    @if ($customization->logo)
                                        <img src="{{ Storage::disk('tenant')->url($customization->logo) }}" alt="Logotipo actual" class="h-16 w-16 object-contain rounded-md bg-gray-100">
                                    @else
                                        <div class="h-16 w-16 flex items-center justify-center bg-gray-100 dark:bg-gray-700 rounded-md text-gray-400">
                                            <i class="fa-solid fa-image fa-2x"></i>
                                        </div>
                                    @endif
                                    <input type="file" name="logo" id="logo" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 dark:file:bg-indigo-900 file:text-indigo-700 dark:file:text-indigo-300 hover:file:bg-indigo-100">
                                </div>
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Sube un archivo de imagen (PNG, JPG). Recomendado: 200x200px.</p>
                            </div>

                            <div>
                                <label for="font_family" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fuente del Texto</label>
                                <select name="font_family" id="font_family" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-900 dark:border-gray-600 dark:text-gray-300">
                                    <option value="Figtree, sans-serif" @if ($customization->font_family == 'Figtree, sans-serif') selected @endif>Predeterminada (Figtree)</option>
                                    <option value="Roboto, sans-serif" @if ($customization->font_family == 'Roboto, sans-serif') selected @endif>Roboto</option>
                                    <option value="Arial, sans-serif" @if ($customization->font_family == 'Arial, sans-serif') selected @endif>Arial</option>
                                    <option value="Verdana, sans-serif" @if ($customization->font_family == 'Verdana, sans-serif') selected @endif>Verdana</option>
                                    <option value="Times New Roman, serif" @if ($customization->font_family == 'Times New Roman, serif') selected @endif>Times New Roman</option>
                                </select>
                            </div>
                        </div>

                        <!-- Columna de Colores -->
                        <div class="space-y-6">
                            <div>
                                <label for="primary_color" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Color Primario</label>
                                <input type="color" name="primary_color" id="primary_color" value="{{ $customization->primary_color ?? '#4F46E5' }}" class="mt-1 h-10 w-full block border-gray-300 rounded-md">
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Usado para botones principales, enlaces y elementos destacados.</p>
                            </div>

                            <div>
                                <label for="secondary_color" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Color Secundario</label>
                                <input type="color" name="secondary_color" id="secondary_color" value="{{ $customization->secondary_color ?? '#7C3AED' }}" class="mt-1 h-10 w-full block border-gray-300 rounded-md">
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Usado para acentos, fondos secundarios o elementos de menor importancia.</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end mt-8 border-t border-gray-200 dark:border-gray-700 pt-6">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring focus:ring-indigo-300 disabled:opacity-25 transition">
                            Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
