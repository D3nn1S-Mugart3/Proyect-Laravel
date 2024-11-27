<div class="p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-2xl font-semibold mb-4 text-gray-700">Gestión de Imágenes</h2>

    <!-- Mensaje de éxito -->
    @if (session()->has('message'))
        <div style="background-color: rgb(3, 179, 3);"
            class="bg-green-100 text-green-700 border border-green-400 p-3 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    <!-- Botón para abrir el modal y exportar PDF -->
    <div class="flex justify-between items-center mb-4">
        <button style="background-color: rgb(115, 184, 248)" wire:click="$set('isModalOpen', true)"
            class="bg-blue-400 text-white px-6 py-2 rounded-lg shadow hover:bg-blue-600 transition">
            {{ $isEditMode ? 'Editar Imagen' : 'Agregar Nueva Imagen' }}
        </button>

        <button style="background-color: red;" wire:click="exportToPdf"
            class="bg-red-500 text-white px-6 py-2 rounded-lg shadow hover:bg-red-600 transition">
            Exportar a PDF
        </button>
    </div>

    <!-- Modal -->
    @if ($isModalOpen)
        <div class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-lg w-1/2 p-6 relative">
                <h3 class="text-xl font-semibold mb-4 text-gray-800">
                    {{ $isEditMode ? 'Editar Imagen' : 'Nueva Imagen' }}
                </h3>

                <!-- Formulario -->
                <form wire:submit.prevent="{{ $isEditMode ? 'update' : 'store' }}" class="space-y-4">
                    <div>
                        <label for="nombre" class="block font-medium text-gray-700">Nombre</label>
                        <input type="text" wire:model="nombre" id="nombre"
                            class="border border-gray-300 rounded-lg p-2 w-full focus:ring focus:ring-blue-200">
                        @error('nombre')
                            <span style="background-color: red; class="bg-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="descripcion" class="block font-medium text-gray-700">Descripción</label>
                        <textarea wire:model="descripcion" id="descripcion"
                            class="border border-gray-300 rounded-lg p-2 w-full focus:ring focus:ring-blue-200"></textarea>
                    </div>

                    <div>
                        <label for="imagen" class="block font-medium text-gray-700">Imagen</label>
                        <input type="file" wire:model="imagen" id="imagen"
                            class="border border-gray-300 rounded-lg p-2 w-full focus:ring focus:ring-blue-200">
                        @error('imagen')
                            <span style="background-color: red; class="bg-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button style="background-color: gray" type="button" wire:click="$set('isModalOpen', false)"
                            class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                            Cancelar
                        </button>
                        <button style="background-color: rgb(115, 184, 248)" type="submit"
                            class="bg-blue-800 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-600 transition">
                            {{ $isEditMode ? 'Actualizar' : 'Guardar' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Tabla de imágenes -->
    <div class="overflow-x-auto mt-6">
        <table class="w-full border-collapse border border-gray-200 bg-white rounded-lg shadow-md">
            <thead class="bg-gray-200">
                <tr>
                    <th class="border border-gray-300 px-4 py-2 text-left">Nombre</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Descripción</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Imagen</th>
                    <th class="border border-gray-300 px-4 py-2 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($imagenes as $img)
                    <tr class="hover:bg-gray-100 odd:bg-gray-50 even:bg-white">
                        <td class="border border-gray-300 px-4 py-2">{{ $img->nombre }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $img->descripcion }}</td>
                        <td class="border border-gray-300 px-4 py-2">
                            @if ($img->imagen)
                                <img src="{{ asset('storage/' . $img->imagen) }}" alt="Imagen"
                                    class="w-16 h-16 object-cover rounded-md shadow">
                            @endif
                        </td>
                        <td class="border border-gray-300 px-4 py-2 text-center space-x-2">
                            <button wire:click="edit({{ $img->id }})"
                                class="bg-yellow-600 text-white px-3 py-1 rounded-lg hover:bg-yellow-600 transition">
                                Editar
                            </button>
                            <button wire:click="delete({{ $img->id }})"
                                class="bg-red-600 text-white px-3 py-1 rounded-lg hover:bg-red-600 transition">
                                Eliminar
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
