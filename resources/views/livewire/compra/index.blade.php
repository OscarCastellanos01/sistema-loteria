<div>
    <div class="max-w-xl mx-auto py-6">
    <div class="mb-6">
        <h2 
            class="text-xl font-bold"
        >
            Compra de Números
        </h2>
        <p 
            class="text-sm text-gray-600"
        >
            Nombre del sorteo: <span class="font-semibold">{{ $sorteo->nombreSorteo }}</span>
        </p>
        <p class="text-sm text-gray-600">
            Fecha del sorteo:
            <span class="font-semibold">
                {{ \Carbon\Carbon::parse($sorteo->fechaSorteo)->format('d/m/Y H:i') }}
            </span>
        </p>
        @if($sorteo->numeroGanador)
            <p class="text-sm text-green-700 font-bold mt-2">
                🎉 Número ganador: {{ $sorteo->numeroGanador }} 
                - {{ $sorteo->compras->first()->user->name }}
            </p>
        @endif
        <p class="text-sm text-red-500" wire:ignore>
            Tiempo restante:
            <span id="countdown" class="font-semibold"></span>
        </p>
        @if(auth()->user()->hasRole('admin') && is_null($sorteo->numeroGanador) && now()->gte($sorteo->fechaSorteo))
            <button wire:click="seleccionarGanador({{ $sorteo->id }})"
                class="mt-3 text-sm px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                Seleccionar ganador
            </button>
        @endif
    </div>

    @if ($mensaje)
        <div class="my-3 px-4 py-2 rounded bg-green-100 text-green-800 text-sm">
            {{ $mensaje }}
        </div>
    @endif

    @if (session()->has('message'))
        <div class="my-3 px-4 py-2 rounded bg-green-100 text-green-800 text-sm">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="my-3 px-4 py-2 rounded bg-red-100 text-green-800 text-sm">
            {{ session('error') }}
        </div>
    @endif

    <form wire:submit.prevent="comprar" class="space-y-4">
        <div>
            <label 
                for="numeroCompra" 
                class="block text-sm font-medium text-gray-700"
            >
                Número a comprar
            </label>
            <input 
                type="number" 
                id="numeroCompra" 
                wire:model.live="numeroCompra" 
                min="1" 
                max="100"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500"
                {{ !$sorteoActivo ? 'disabled' : '' }}
            >
            @error('numeroCompra') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <x-primary-button type="submit" :disabled="!$sorteoActivo">
            {{ $sorteoActivo ? 'Comprar' : 'Sorteo Finalizado' }}
        </x-primary-button>
    </form>

    <div class="mt-6">
        <h3 class="text-lg font-semibold mb-2">Números comprados:</h3>
        <div class="grid grid-cols-10 gap-2">
            @for ($i = 1; $i <= 100; $i++)
                <div wire:click="setNumero({{ $i }})"
                    class="cursor-pointer text-center text-sm font-semibold py-1 rounded shadow-sm transition duration-200 select-none
                        @if (in_array($i, $numerosComprados))
                            bg-red-500 text-white cursor-not-allowed
                        @elseif ($numeroCompra == $i)
                            bg-red-400 text-white
                        @else
                            bg-green-500 text-white hover:bg-green-600
                        @endif">
                    {{ $i }}
                </div>
            @endfor
        </div>
    </div>
</div>
    @push('js')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const countdownEl = document.getElementById('countdown');
                const endTime = new Date("{{ $sorteo->fechaSorteo }}").getTime();

                function updateCountdown() {
                    const now = new Date().getTime();
                    const distance = endTime - now;

                    if (distance <= 0) {
                        countdownEl.innerText = '¡El sorteo ha cerrado!';
                        Livewire.dispatch('finalizarSorteo');
                        return;
                    }

                    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    countdownEl.innerText = `${hours}h ${minutes}m ${seconds}s`;
                    setTimeout(updateCountdown, 1000);
                }

                updateCountdown();
            });
        </script>
    @endpush
</div>
