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
    @auth
        @php
            $roleName = auth()->user()->role?->nama_role;


            $bottomNavigation = [
                [
                    'label' => 'Beranda',
                    'route' => 'dashboard',
                    'icon' => 'home',
                    'roles' => ['Owner', 'Staff Operasional', 'Karyawan'],
                ],
                [
                    'label' => 'Produk',
                    'route' => 'products.index',
                    'icon' => 'package',
                    'roles' => ['Owner'],
                ],
                [
                    'label' => 'Distribusi',
                    'route' => 'distributions.index',
                    'icon' => 'truck',
                    'roles' => ['Staff Operasional'],
                ],
                [
                    'label' => 'Transaksi',
                    'route' => 'sales.index',
                    'icon' => 'receipt',
                    'roles' => ['Owner', 'Staff Operasional'],
                ],
                [
                    'label' => 'Akun',
                    'route' => 'profile.edit',
                    'icon' => 'user',
                    'roles' => ['Owner', 'Staff Operasional', 'Karyawan'],
                ],
            ];


            $visibleBottomNavigation = collect($bottomNavigation)
                ->filter(fn ($item) => in_array($roleName, $item['roles']))
                ->values();
        @endphp

        <nav
            class="fixed inset-x-0 bottom-0 z-40 border-t border-stone-200 bg-white shadow-[0_-4px_12px_rgba(0,0,0,0.04)] md:hidden"
            style="padding-bottom: env(safe-area-inset-bottom);"
            aria-label="Navigasi utama mobile"
        >
            <div
                class="grid h-[68px] w-full"
                style="grid-template-columns: repeat({{ max($visibleBottomNavigation->count(), 1) }}, minmax(0, 1fr));"
            >
                @foreach ($visibleBottomNavigation as $item)
                    @php
                        $isActive = request()->routeIs($item['route'])
                            || ($item['route'] === 'sales.index'
                                && request()->routeIs('sales.*'))
                            || ($item['route'] === 'products.index'
                                && request()->routeIs('products.*'))
                            || ($item['route'] === 'distributions.index'
                                && request()->routeIs('distributions.*'))
                            || ($item['route'] === 'profile.edit'
                                && request()->routeIs('profile.*'));
                    @endphp

                    <a
                        href="{{ route($item['route']) }}"
                        @if ($isActive)
                            aria-current="page"
                        @endif
                        class="flex min-w-0 flex-col items-center justify-center gap-1 transition
                            {{ $isActive
                                ? 'text-amber-800'
                                : 'text-stone-500 hover:bg-stone-50 hover:text-stone-800' }}"
                    >
                        <span
                            class="flex h-8 w-10 items-center justify-center rounded-xl
                                {{ $isActive ? 'bg-amber-50' : '' }}"
                        >
                            @if ($item['icon'] === 'home')
                                <svg
                                    class="h-5 w-5"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.7"
                                    aria-hidden="true"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="m3 10 9-7 9 7M5 9v11h14V9M9 20v-6h6v6"
                                    />
                                </svg>

                            @elseif ($item['icon'] === 'package')
                                <svg
                                    class="h-5 w-5"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.7"
                                    aria-hidden="true"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="m12 3 9 5-9 5-9-5 9-5ZM3 8v9l9 5 9-5V8M12 13v9"
                                    />
                                </svg>

                            @elseif ($item['icon'] === 'receipt')
                                <svg
                                    class="h-5 w-5"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.7"
                                    aria-hidden="true"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M5 3h14v18l-3-2-4 2-4-2-3 2V3ZM8 8h8M8 12h8M8 16h4"
                                    />
                                </svg>

                            @elseif ($item['icon'] === 'truck')
                                <svg
                                    class="h-5 w-5"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.7"
                                    aria-hidden="true"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M3 6h11v11H3zM14 10h4l3 4v3h-7M7 20a2 2 0 1 0 0-4 2 2 0 0 0 0 4ZM18 20a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z"
                                    />
                                </svg>

                            @elseif ($item['icon'] === 'user')
                                <svg
                                    class="h-5 w-5"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.7"
                                    aria-hidden="true"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M20 21a8 8 0 0 0-16 0M12 13a5 5 0 1 0 0-10 5 5 0 0 0 0 10Z"
                                    />
                                </svg>
                            @endif
                        </span>

                        <span class="truncate px-1 text-[10px] font-medium leading-tight">
                            {{ $item['label'] }}
                        </span>
                    </a>
                @endforeach
            </div>
        </nav>
    @endauth

    @stack('scripts')
</body>

</html>
