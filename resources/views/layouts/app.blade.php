<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        {{ config('app.name', 'KopiKeun') }}
    </title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-stone-50 text-stone-800 antialiased">

    <div class="min-h-screen">

        {{-- Navigation --}}
        @include('layouts.navigation')

        {{-- Header --}}
        @isset($header)
            <header class="bg-white">
                <div class="mx-auto max-w-7xl px-4 py-5 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        {{-- Main Content --}}
        <main class="pb-24 md:pb-8">
            {{ $slot }}
        </main>

    </div>

    {{-- Mobile Bottom Navigation --}}
    <nav class="fixed inset-x-0 bottom-0 z-50 border-t border-stone-200 bg-white md:hidden">
        <div class="grid h-16 grid-cols-4">

            <a
                href="{{ route('dashboard') }}"
                class="flex flex-col items-center justify-center gap-1 text-amber-900"
            >
                <span class="text-lg">⌂</span>
                <span class="text-[11px] font-medium">Beranda</span>
            </a>

            <a
                href="#"
                class="flex flex-col items-center justify-center gap-1 text-stone-500"
            >
                <span class="text-lg">▣</span>
                <span class="text-[11px] font-medium">Produk</span>
            </a>

            <a
                href="#"
                class="flex flex-col items-center justify-center gap-1 text-stone-500"
            >
                <span class="text-lg">🛒</span>
                <span class="text-[11px] font-medium">Transaksi</span>
            </a>

            <a
                href="#"
                class="flex flex-col items-center justify-center gap-1 text-stone-500"
            >
                <span class="text-lg">●</span>
                <span class="text-[11px] font-medium">Akun</span>
            </a>

        </div>
    </nav>

</body>

</html>