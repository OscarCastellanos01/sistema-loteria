<div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-10">
        <h2 class="text-2xl font-bold text-center mb-6">Sorteos disponibles</h2>

        <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
            <input type="text" wire:model.live.debounce.500ms="searchNombre"
                placeholder="Buscar por nombre"
                class="w-full rounded-md border-gray-300 text-sm shadow-sm" />

            <input type="date" wire:model.live="fechaInicio"
                class="w-full rounded-md border-gray-300 text-sm shadow-sm" />

            <input type="date" wire:model.live="fechaFin"
                class="w-full rounded-md border-gray-300 text-sm shadow-sm" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($sorteos as $sorteo)
                <div class="p-5 rounded-lg shadow bg-white relative border border-gray-200">
                    <div class="mb-2">
                        <h3 class="text-xl font-bold text-gray-800">{{ $sorteo->nombreSorteo }}</h3>
                        <p class="text-sm text-gray-600">
                            Fecha: {{ \Carbon\Carbon::parse($sorteo->fechaSorteo)->format('d/m/Y H:i') }}
                        </p>
                        <p class="text-sm text-blue-600 font-semibold">
                            Números disponibles: {{ 100 - $sorteo->compras_count }} / 100
                        </p>
                        <p class="text-sm font-semibold {{ $sorteo->estadoSorteo ? 'text-green-600' : 'text-red-600' }}">
                            Estado: {{ $sorteo->estadoSorteo ? 'Activo' : 'Finalizado' }}
                        </p>

                        @if($sorteo->numeroGanador)
                            <p class="text-sm text-green-700 font-bold mt-2">
                                🎉 Número ganador: {{ $sorteo->numeroGanador }} 
                                - {{ optional($sorteo->compras->first()->user)->name }}
                            </p>
                        @endif
                    </div>

                    <div class="text-sm text-red-500" wire:ignore>
                        <span id="countdown-{{ $sorteo->id }}"></span>
                    </div>

                    <div class="mt-4 flex justify-between items-center">
                        @auth
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
                        @else
                            <p class="text-sm text-red-600 font-semibold">
                                <a href="{{ route('login') }}" class="underline">Inicia sesión</a> o 
                                <a href="{{ route('register') }}" class="underline">regístrate</a> para comprar un número.
                            </p>
                        @endauth
                    </div>
                </div>
            @endforeach
        </div>
        @if ($sorteos->hasPages())
            <div class="mt-6 flex justify-center">
                {{ $sorteos->links() }}
            </div>
        @endif
    </div>
</div>
