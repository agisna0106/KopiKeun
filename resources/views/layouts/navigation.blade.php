
<nav
    x-data="{ mobileOpen: false }"
    class="border-b border-stone-200 bg-white"
>
    <div class="mx-auto w-full px-4 sm:px-6 lg:px-8">

        {{-- Main Navigation --}}
        <div class="flex min-h-16 items-center justify-between gap-3">

            {{-- Logo --}}
            <a href="{{ route('dashboard') }}" class="flex shrink-0 items-center gap-2">
                <div class="flex h-14 w-14 items-center justify-center sm:h-16 sm:w-16">
                    <img
                        src="{{ asset('images/logo_kopikeun.png') }}"
                        alt="Logo KopiKeun"
                        class="max-h-full max-w-full object-contain"
                    >
                </div>

                <div class="hidden sm:block">
                    <div class="text-base font-bold text-stone-800">
                        KopiKeun
                    </div>
                    <div class="text-xs text-stone-500">
                        Sistem Informasi Operasional
                    </div>
                </div>
            </a>

            {{-- Desktop Navigation --}}
            <div class="hidden items-center gap-1 md:flex">

                {{-- Dashboard --}}
                <a
                    href="{{ route('dashboard') }}"
                    class="rounded-lg px-3 py-2 text-sm font-medium text-stone-600 transition hover:bg-stone-100 hover:text-stone-900"
                >
                    Dashboard
                </a>

                {{-- Owner and Staff Operasional --}}
                @if(in_array(auth()->user()->role?->nama_role, ['Owner', 'Staff Operasional']))

                    {{-- Master Data --}}
                    <div class="relative group">
                        <button
                            type="button"
                            class="flex items-center gap-1 rounded-lg px-3 py-2 text-sm font-medium text-stone-600 transition hover:bg-stone-100 hover:text-stone-900"
                        >
                            Master Data
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <div class="invisible absolute left-0 top-full z-50 w-48 rounded-xl border border-stone-200 bg-white p-1 opacity-0 shadow-lg transition-all group-hover:visible group-hover:opacity-100">
                            <a href="{{ route('products.index') }}" class="block rounded-lg px-3 py-2 text-sm text-stone-600 hover:bg-stone-100 hover:text-stone-900">
                                Produk
                            </a>

                            @if(auth()->user()->role?->nama_role === 'Owner')
                                <a href="{{ route('employees.index') }}" class="block rounded-lg px-3 py-2 text-sm text-stone-600 hover:bg-stone-100 hover:text-stone-900">
                                    Karyawan
                                </a>
                            @endif

                            <a href="{{ route('carts.index') }}" class="block rounded-lg px-3 py-2 text-sm text-stone-600 hover:bg-stone-100 hover:text-stone-900">
                                Gerobak
                            </a>

                            <a href="{{ route('raw-materials.index') }}" class="block rounded-lg px-3 py-2 text-sm text-stone-600 hover:bg-stone-100 hover:text-stone-900">
                                Bahan Baku
                            </a>

                            <a href="{{ route('regions.index') }}" class="block rounded-lg px-3 py-2 text-sm text-stone-600 hover:bg-stone-100 hover:text-stone-900">
                                Wilayah
                            </a>

                            <a href="{{ route('base-drinks.index') }}" class="block rounded-lg px-3 py-2 text-sm text-stone-600 hover:bg-stone-100 hover:text-stone-900">
                                Minuman Dasar
                            </a>

                            <a href="{{ route('operational-items.index') }}" class="block rounded-lg px-3 py-2 text-sm text-stone-600 hover:bg-stone-100 hover:text-stone-900">
                                Barang Operasional
                            </a>
                        </div>
                    </div>

                    {{-- Inventory --}}
                    @if(auth()->user()->role?->nama_role === 'Staff Operasional')

                        <div class="relative group">
                            <button
                                type="button"
                                class="flex items-center gap-1 rounded-lg px-3 py-2 text-sm font-medium text-stone-600 transition hover:bg-stone-100 hover:text-stone-900"
                            >
                                Persediaan
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>

                            <div class="invisible absolute left-0 top-full z-50 w-52 rounded-xl border border-stone-200 bg-white p-1 opacity-0 shadow-lg transition-all group-hover:visible group-hover:opacity-100">
                                <a href="{{ route('raw-material-stock-records.index') }}" class="block rounded-lg px-3 py-2 text-sm text-stone-600 hover:bg-stone-100 hover:text-stone-900">
                                    Catatan Stok
                                </a>

                                <a href="{{ route('incoming-goods.index') }}" class="block rounded-lg px-3 py-2 text-sm text-stone-600 hover:bg-stone-100 hover:text-stone-900">
                                    Barang Masuk
                                </a>
                            </div>
                        </div>
                    @endif

                    {{-- Operations --}}
                    <div class="relative group">
                        <button
                            type="button"
                            class="flex items-center gap-1 rounded-lg px-3 py-2 text-sm font-medium text-stone-600 transition hover:bg-stone-100 hover:text-stone-900"
                        >
                            Operasional
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <div class="invisible absolute left-0 top-full z-50 w-56 rounded-xl border border-stone-200 bg-white p-1 opacity-0 shadow-lg transition-all group-hover:visible group-hover:opacity-100">
                            <a href="{{ route('sales.index') }}" class="block rounded-lg px-3 py-2 text-sm text-stone-600 hover:bg-stone-100 hover:text-stone-900">
                                Penjualan
                            </a>

                            <a href="{{ route('assignments.index') }}" class="block rounded-lg px-3 py-2 text-sm text-stone-600 hover:bg-stone-100 hover:text-stone-900">
                                Penugasan
                            </a>

                            @if(auth()->user()->role?->nama_role === 'Staff Operasional')
                                <a href="{{ route('distributions.index') }}" class="block rounded-lg px-3 py-2 text-sm text-stone-600 hover:bg-stone-100 hover:text-stone-900">
                                    Distribusi
                                </a>

                                <a href="{{ route('operational-expenses.index') }}" class="block rounded-lg px-3 py-2 text-sm text-stone-600 hover:bg-stone-100 hover:text-stone-900">
                                    Pengeluaran Operasional
                                </a>
                            @endif

                        </div>
                    </div>

                @endif

                {{-- Owner Reports --}}
                @if(auth()->user()->role?->nama_role === 'Owner')
                    <a
                        href="{{ route('financial-reports.index') }}"
                        class="rounded-lg px-3 py-2 text-sm font-medium text-stone-600 transition hover:bg-stone-100 hover:text-stone-900"
                    >
                        Laporan Keuangan
                    </a>


                @endif
                <a
                    href="{{ route('sales-analytics.index') }}"
                    class="rounded-lg px-3 py-2 text-sm font-medium text-stone-600 transition hover:bg-stone-100 hover:text-stone-900"
                >
                    Analitik Penjualan
                </a>

            </div>

            {{-- Right Actions --}}
            <div class="flex shrink-0 items-center gap-1 sm:gap-2">

                {{-- User Menu --}}
                <div x-data="{ open: false }" class="relative shrink-0">
                    <button
                        type="button"
                        @click="open = !open"
                        :aria-expanded="open.toString()"
                        aria-label="Menu pengguna"
                        class="flex items-center gap-2 rounded-xl px-1.5 py-1.5 transition hover:bg-stone-100 focus:outline-none sm:gap-3 sm:px-2"
                    >
                        <div
                            class="flex h-9 w-9 items-center justify-center rounded-full text-sm font-bold text-white sm:h-10 sm:w-10"
                            style="background-color: #92400e;"
                        >
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>

                        <div class="hidden text-left sm:block">
                            <div class="text-sm font-semibold text-stone-800">
                                {{ auth()->user()->name }}
                            </div>
                            <div class="text-xs text-stone-500">
                                {{ auth()->user()->role?->nama_role }}
                            </div>
                        </div>

                        <svg
                            class="hidden h-4 w-4 text-stone-400 transition-transform sm:block"
                            :class="{ 'rotate-180': open }"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    {{-- User Dropdown --}}
                    <div
                        x-show="open"
                        x-cloak
                        @click.outside="open = false"
                        @keydown.escape.window="open = false"
                        x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-100"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-95"
                        class="absolute right-0 top-full z-50 mt-2 w-56 origin-top-right rounded-2xl border border-stone-200 bg-white p-2 shadow-xl"
                    >
                        <div class="border-b border-stone-100 px-3 py-3">
                            <p class="text-sm font-semibold text-stone-800">
                                {{ auth()->user()->name }}
                            </p>
                            <p class="mt-0.5 text-xs text-stone-500">
                                {{ auth()->user()->role?->nama_role }}
                            </p>
                        </div>

                        <a
                            href="{{ route('profile.edit') }}"
                            class="mt-2 flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-stone-700 transition hover:bg-stone-100"
                        >
                            <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-stone-100 text-stone-600">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z M4.5 20.25a8.25 8.25 0 0115 0"/>
                                </svg>
                            </span>
                            <span>Profile</span>
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button
                                type="submit"
                                class="mt-1 flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-left text-sm font-medium text-red-600 transition hover:bg-red-50"
                            >
                                <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-red-50 text-red-500">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6A2.25 2.25 0 005.25 5.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15 M18 15l3-3m0 0l-3-3m3 3H9"/>
                                    </svg>
                                </span>
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Hamburger Button --}}
                <button
                    type="button"
                    @click="mobileOpen = !mobileOpen"
                    :aria-expanded="mobileOpen.toString()"
                    aria-label="Buka atau tutup navigasi"
                    class="inline-flex h-10 w-10 items-center justify-center rounded-lg text-stone-700 transition hover:bg-stone-100 focus:outline-none focus:ring-2 focus:ring-stone-400 md:hidden"
                >
                    <svg
                        x-show="!mobileOpen"
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>

                    <svg
                        x-show="mobileOpen"
                        x-cloak
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>

            </div>
        </div>

        {{-- Mobile Navigation --}}
        <div
            x-show="mobileOpen"
            x-cloak
            x-transition:enter="transition ease-out duration-150"
            x-transition:enter-start="opacity-0 -translate-y-1"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-100"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-1"
            @keydown.escape.window="mobileOpen = false"
            class="max-h-[calc(100dvh-4rem)] overflow-y-auto border-t border-stone-200 py-3 md:hidden"
        >
            <div class="space-y-1">

                {{-- Dashboard --}}
                <a
                    href="{{ route('dashboard') }}"
                    @click="mobileOpen = false"
                    class="block rounded-lg px-4 py-3 text-sm font-medium text-stone-700 hover:bg-stone-100"
                >
                    Dashboard
                </a>

                {{-- Owner and Staff --}}
                @if(in_array(auth()->user()->role?->nama_role, ['Owner', 'Staff Operasional']))

                    <div class="px-4 pb-1 pt-4 text-xs font-semibold uppercase tracking-wider text-stone-400">
                        Master Data
                    </div>

                    <a href="{{ route('products.index') }}" @click="mobileOpen = false" class="block rounded-lg px-4 py-3 text-sm text-stone-700 hover:bg-stone-100">
                        Produk
                    </a>

                    @if(auth()->user()->role?->nama_role === 'Owner')
                        <a href="{{ route('employees.index') }}" @click="mobileOpen = false" class="block rounded-lg px-4 py-3 text-sm text-stone-700 hover:bg-stone-100">
                            Karyawan
                        </a>
                    @endif

                    <a href="{{ route('carts.index') }}" @click="mobileOpen = false" class="block rounded-lg px-4 py-3 text-sm text-stone-700 hover:bg-stone-100">
                        Gerobak
                    </a>

                    <a href="{{ route('regions.index') }}" @click="mobileOpen = false" class="block rounded-lg px-4 py-3 text-sm text-stone-700 hover:bg-stone-100">
                        Wilayah
                    </a>

                    <a href="{{ route('base-drinks.index') }}" @click="mobileOpen = false" class="block rounded-lg px-4 py-3 text-sm text-stone-700 hover:bg-stone-100">
                        Minuman Dasar
                    </a>

                    <a href="{{ route('operational-items.index') }}" @click="mobileOpen = false" class="block rounded-lg px-4 py-3 text-sm text-stone-700 hover:bg-stone-100">
                        Barang Operasional
                    </a>

                    <a href="{{ route('raw-materials.index') }}" @click="mobileOpen = false" class="block rounded-lg px-4 py-3 text-sm text-stone-700 hover:bg-stone-100">
                        Bahan Baku
                    </a>

                    @if(auth()->user()->role?->nama_role === 'Staff Operasional')
                        <div class="px-4 pb-1 pt-4 text-xs font-semibold uppercase tracking-wider text-stone-400">
                            Persediaan
                        </div>

                        <a href="{{ route('raw-material-stock-records.index') }}" @click="mobileOpen = false" class="block rounded-lg px-4 py-3 text-sm text-stone-700 hover:bg-stone-100">
                            Catatan Stok
                        </a>

                        <a href="{{ route('incoming-goods.index') }}" @click="mobileOpen = false" class="block rounded-lg px-4 py-3 text-sm text-stone-700 hover:bg-stone-100">
                            Barang Masuk
                        </a>
                    @endif

                    <div class="px-4 pb-1 pt-4 text-xs font-semibold uppercase tracking-wider text-stone-400">
                        Operasional
                    </div>

                    @if(auth()->user()->role?->nama_role === 'Staff Operasional')
                        <a href="{{ route('distributions.index') }}" @click="mobileOpen = false" class="block rounded-lg px-4 py-3 text-sm text-stone-700 hover:bg-stone-100">
                            Distribusi
                        </a>

                        <a href="{{ route('operational-expenses.index') }}" @click="mobileOpen = false" class="block rounded-lg px-4 py-3 text-sm text-stone-700 hover:bg-stone-100">
                            Pengeluaran Operasional
                        </a>
                    @endif

                    <a href="{{ route('sales.index') }}" @click="mobileOpen = false" class="block rounded-lg px-4 py-3 text-sm text-stone-700 hover:bg-stone-100">
                        Penjualan
                    </a>

                    <a href="{{ route('assignments.index') }}" @click="mobileOpen = false" class="block rounded-lg px-4 py-3 text-sm text-stone-700 hover:bg-stone-100">
                        Penugasan
                    </a>

                    {{-- Owner Only --}}
                    @if(auth()->user()->role?->nama_role === 'Owner')
                        <div class="px-4 pb-1 pt-4 text-xs font-semibold uppercase tracking-wider text-stone-400">
                            Laporan & Analitik
                        </div>

                        <a href="{{ route('financial-reports.index') }}" @click="mobileOpen = false" class="block rounded-lg px-4 py-3 text-sm text-stone-700 hover:bg-stone-100">
                            Laporan Keuangan
                        </a>

                        <a href="{{ route('sales-analytics.index') }}" @click="mobileOpen = false" class="block rounded-lg px-4 py-3 text-sm text-stone-700 hover:bg-stone-100">
                            Analitik Penjualan
                        </a>
                    @endif

                @endif

                {{-- Mobile Profile and Logout --}}
                <div class="mt-3 border-t border-stone-200 pt-3">
                    <div class="px-4 py-2">
                        <p class="text-sm font-semibold text-stone-800">
                            {{ auth()->user()->name }}
                        </p>
                        <p class="mt-0.5 text-xs text-stone-500">
                            {{ auth()->user()->role?->nama_role }}
                        </p>
                    </div>

                    <a
                        href="{{ route('profile.edit') }}"
                        @click="mobileOpen = false"
                        class="block rounded-lg px-4 py-3 text-sm font-medium text-stone-700 hover:bg-stone-100"
                    >
                        Profile
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button
                            type="submit"
                            class="w-full rounded-lg px-4 py-3 text-left text-sm font-medium text-red-600 hover:bg-red-50"
                        >
                            Logout
                        </button>
                    </form>
                </div>

            </div>
        </div>

    </div>
</nav>

