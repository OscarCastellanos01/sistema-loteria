<div>
    <div class="bg-white shadow-md rounded-xl p-6 mb-8 border border-gray-200">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Sorteos') }}
        </h2>
        <div class="p-6 text-gray-900">
            @if (session()->has('message'))
                <div class="mb-4 text-green-600">
                    {{ session('message') }}
                </div>
            @endif
            <form wire:submit.prevent="save" method="POST" class="space-y-6">
                <div class="mb-5">
                    <label 
                        for="nombreSorteo" 
                        class="block text-sm font-medium text-gray-700 mb-1"
                    >
                        Nombre del Sorteo
                    </label>
                    <input 
                        type="text" 
                        wire:model="nombreSorteo" 
                        id="nombreSorteo"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                        placeholder="Ej: Sorteo Millonario"
                        autocomplete="off"
                    >
                    <x-input-error :messages="$errors->get('nombreSorteo')" class="mt-2" />
                </div>
                <div class="mb-5">
                    <label 
                        for="fechaSorteo" 
                        class="block text-sm font-medium text-gray-700 mb-1"
                    >
                        Fecha del Sorteo
                    </label>
                    <input 
                        type="datetime-local" 
                        wire:model="fechaSorteo" 
                        id="fechaSorteo"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                        autocomplete="off"
                    >
                    <x-input-error :messages="$errors->get('fechaSorteo')" class="mt-2" />
                </div>
                <x-primary-button title="{{ $sorteoId ? 'Actualizar Sorteo' : 'Crear Sorteo' }}">
                    @if ($sorteoId)
                        Editar
                    @else
                        Crear
                    @endif
                </x-primary-button>
            </form>
        </div>

        {{-- Listado de sorteos --}}
        <table class="w-full text-sm text-left text-gray-700">
            <thead class="text-xs uppercase bg-gray-100 text-gray-600">
                <tr>
                    <th class="px-4 py-3">Nombre</th>
                    <th class="px-4 py-3">Fecha</th>
                    <th class="px-4 py-3">Estado</th>
                    <th class="px-4 py-3 text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                @foreach ($sorteos as $sorteo)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2">{{ $sorteo->nombreSorteo }}</td>
                    <td class="px-4 py-2">{{ $sorteo->fechaSorteo }}</td>
                    <td class="px-4 py-2">
                        <span 
                            class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800"
                        >
                            {{ $sorteo->estadoSorteo ? 'Activo' : 'Inactivo' }}
                        </span>
                    </td>
                    <td class="px-4 py-2 text-right">
                        <button wire:click="edit({{ $sorteo->id }})"
                            class="text-indigo-600 hover:underline text-sm font-medium">
                            Editar
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
