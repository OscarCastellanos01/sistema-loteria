<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistema de Lotería</title>

    <!-- Estilos -->
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased bg-gray-100 text-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        {{-- Navegación superior --}}
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Loto Click</h1>

            <div class="space-x-4">
                @auth
                    <span class="text-gray-700">Hola, {{ Auth::user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-red-500 hover:underline">Cerrar sesión</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Iniciar sesión</a>
                    <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Registrarse</a>
                @endauth
            </div>
        </div>

        {{-- Sorteos activos --}}
        @livewire('welcome')
    </div>
</body>
</html>
