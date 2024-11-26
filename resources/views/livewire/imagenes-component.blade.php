<div>
    <h2 class="text-lg font-semibold">Gestión de Imágenes</h2>

    <!-- Mensaje de éxito -->
    @if (session()->has('message'))
        <div class="bg-green-500 text-white p-2 mb-4">
            {{ session('message') }}
        </div>
    @endif

    <!-- Formulario -->
    <form wire:submit.prevent="{{ $isEditMode ? 'update' : 'store' }}" class="mb-4">
        <div>
            <label for="nombre">Nombre</label>
            <input type="text" wire:model="nombre" id="nombre" class="border p-2 w-full">
            @error('nombre')
                <span class="text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="descripcion">Descripción</label>
            <textarea wire:model="descripcion" id="descripcion" class="border p-2 w-full"></textarea>
        </div>

        <div>
            <label for="imagen">Imagen</label>
            <input type="file" wire:model="imagen" id="imagen" class="border p-2 w-full">
            @error('imagen')
                <span class="text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <button style="background-color: blue;" type="submit" class="bg-blue-500 text-white p-2 mt-2">
            {{ $isEditMode ? 'Actualizar' : 'Guardar' }}
        </button>
    </form>

    <!-- Tabla de imágenes -->
    <table class="table-auto w-full">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($imagenes as $img)
                <tr>
                    <td>{{ $img->nombre }}</td>
                    <td>{{ $img->descripcion }}</td>
                    <td>
                        @if ($img->imagen)
                            <img src="{{ asset('storage/' . $img->imagen) }}" alt="Imagen" width="100">
                        @endif
                    </td>
                    <td>
                        <button wire:click="edit({{ $img->id }})"
                            class="bg-yellow-500 text-white p-2">Editar</button>
                        <button style="background-color: red;" wire:click="delete({{ $img->id }})"
                            class="text-white p-2">Eliminar</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
