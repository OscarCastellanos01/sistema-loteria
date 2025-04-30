<div class="max-w-7xl mx-auto py-6 px-4">
    @if(auth()->user()->hasRole('admin'))
        <div class="mb-6 p-6 rounded-lg shadow bg-white">
            <h2 class="text-lg font-semibold mb-4">Crear Sorteo</h2>
            @if (session()->has('message'))
                <div class="mb-4 text-green-600">
                    {{ session('message') }}
                </div>
            @endif
            @if (session()->has('error'))
                <div class="mb-4 text-red-600">
                    {{ session('error') }}
                </div>
            @endif
            <form wire:submit.prevent="save" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label 
                        class="block text-sm font-medium text-gray-700"
                    >
                        Nombre del Sorteo
                    </label>
                    <input 
                        type="text" 
                        wire:model="nombreSorteo" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm"
                    >
                    @error('nombreSorteo') 
                        <span 
                            class="text-red-600 text-sm"
                        >
                            {{ $message }}
                        </span> @enderror
                </div>
                <div>
                    <label 
                        class="block text-sm font-medium text-gray-700"
                    >
                        Fecha del Sorteo
                    </label>
                    <input 
                        type="datetime-local" 
                        wire:model="fechaSorteo"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm"
                    >
                    @error('fechaSorteo') 
                        <span 
                            class="text-red-600 text-sm"
                        >
                            {{ $message }}
                        </span> 
                    @enderror
                </div>
                <div class="md:col-span-2">
                    <div class="md:col-span-2">
                        <x-primary-button>
                            {{ $sorteoId ? 'Actualizar' : 'Crear' }}
                        </x-primary-button>
                    </div>
                </div>
            </form>
        </div>
    @endif

    <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
        <input type="text" wire:model.debounce.500ms="searchNombre"
            placeholder="Buscar por nombre"
            class="w-full rounded-md border-gray-300 text-sm shadow-sm" />

        <input type="date" wire:model="fechaInicio"
            class="w-full rounded-md border-gray-300 text-sm shadow-sm" />

        <input type="date" wire:model="fechaFin"
            class="w-full rounded-md border-gray-300 text-sm shadow-sm" />
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($sorteos as $sorteo)
            <div class="p-5 rounded-lg shadow bg-white relative border border-gray-200">
                <div class="mb-2">
                    <h3 class="text-xl font-bold text-gray-800">{{ $sorteo->nombreSorteo }}</h3>
                    <p 
                        class="text-sm text-gray-600"
                    >
                        Fecha: {{ \Carbon\Carbon::parse($sorteo->fechaSorteo)->format('d/m/Y H:i') }}
                    </p>
                    <p 
                        class="text-sm text-blue-600 font-semibold"
                    >
                        Números disponibles: {{ 100 - $sorteo->compras_count }} / 100
                    </p>
                    <p 
                        class="text-sm text-green-600 font-semibold"
                    >
                        Estado: {{ $sorteo->estadoSorteo ? 'Activo' : 'Finalizado' }}
                    </p>
                </div>

                <div class="text-sm text-red-500" wire:ignore>
                    <span id="countdown-{{ $sorteo->id }}"></span>
                </div>

                <div class="mt-4 flex justify-between items-center">
                    <a 
                        href="{{ route('sorteos.comprar', $sorteo->id) }}" 
                        class="text-sm font-medium px-4 py-2 rounded-md bg-indigo-600 text-white hover:bg-indigo-700"
                    >
                        Comprar Número
                    </a>
                    @if(auth()->user()->hasRole('admin'))
                        <button
                            wire:click.prevent="edit({{ $sorteo->id }})" 
                            class="text-sm text-blue-500 hover:underline"
                        >
                            Editar
                        </button>
                    @endif
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        const countdown = document.getElementById('countdown-{{ $sorteo->id }}');
                        const endTime = new Date("{{ $sorteo->fechaSorteo }}").getTime();

                        function updateCountdown{{ $sorteo->id }}() {
                            const now = new Date().getTime();
                            const distance = endTime - now;

                            if (distance <= 0) {
                                countdown.innerText = '¡El sorteo ha cerrado!';
                                return;
                            }

                            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                            countdown.innerText = `${hours}h ${minutes}m ${seconds}s`;
                            setTimeout(updateCountdown{{ $sorteo->id }}, 1000); // <- Aquí sin paréntesis
                        }

                        updateCountdown{{ $sorteo->id }}();
                    });
                </script>
            </div>
        @endforeach
    </div>
    @if ($sorteos->hasPages())
        <div class="mt-6 flex justify-center">
            {{ $sorteos->links() }}
        </div>
    @endif
</div>
