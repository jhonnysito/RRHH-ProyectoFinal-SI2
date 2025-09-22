<x-app-layout>
    <form action="{{ route('roles.guardar') }}" method="POST">
        @csrf
        <div class="w-full">
            <div class="bg-gradient-to-b from-blue-800 to-blue-600 h-96"></div>
            <div class="max-w-5xl mx-auto px-6 sm:px-6 lg:px-8 mb-12">
                <div class="bg-white w-full shadow rounded p-8 sm:p-12 -mt-72">
                    <p class="text-3xl font-bold leading-7 text-center">Crear Rol</p>
                    <form action="" method="post">
                        <div class="md:flex items-center mt-8">
                            <div class="w-full flex flex-col">
                                <label for="name" class="font-semibold leading-none">Nombre</label>
                                <input type="text" name="name" id="name"
                                    class="leading-none text-gray-900 p-3 focus:outline-none focus:border-blue-700 mt-4 bg-gray-100 border rounded border-gray-200" />
                            </div>

                        </div>
                        <div class="md:flex items-center mt-8">
                            <div class="w-full flex flex-col">
                                <label for="permissions[]" class="font-semibold leading-none">Permisos</label>
                                @foreach ($permissions as $permission)
                                    <div class="inline-flex items-center">
                                        <input type="checkbox" name="permissions[]" id="permissions[]"
                                            class="form-checkbox" value="{{ $permission->id }}" />
                                        <label for="permissions[]" class="ml-2">{{ $permission->name }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="flex items-center justify-center w-full">
                            <button
                                class="mt-9 font-semibold leading-none text-white py-4 px-10 bg-blue-700 rounded hover:bg-blue-600 focus:ring-2 focus:ring-offset-2 focus:ring-blue-700 focus:outline-none">
                                Guardar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </form>
</x-app-layout>
