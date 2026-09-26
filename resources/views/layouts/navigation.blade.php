<nav class="border-b border-stone-200 bg-white">
    <div class="mx-auto w-full px-4 sm:px-6 lg:px-8">
        <div class="flex min-h-16 items-center justify-between gap-4">

            {{-- Logo --}}
            <a href="{{ route('dashboard') }}" class="flex shrink-0 items-center gap-2">
                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-amber-900 text-sm font-bold text-white">
                    K
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

                {{-- Owner & Admin --}}
                @if(in_array(auth()->user()->role?->nama_role, ['Owner', 'Admin']))

                    {{-- Master Data --}}
                    <div class="relative group">
                        <button
                            type="button"
                            class="flex items-center gap-1 rounded-lg px-3 py-2 text-sm font-medium text-stone-600 transition hover:bg-stone-100 hover:text-stone-900"
                        >
                            Master Data
                            <svg
                                class="h-4 w-4"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M19 9l-7 7-7-7"
                                />
                            </svg>
                        </button>

                        <div
                            class="invisible absolute left-0 top-full z-50 w-48 rounded-xl border border-stone-200 bg-white p-1 opacity-0 shadow-lg transition-all group-hover:visible group-hover:opacity-100"
                        >

                            {{-- Products --}}
                            <a
                                href="{{ route('products.index') }}"
                                class="block rounded-lg px-3 py-2 text-sm text-stone-600 hover:bg-stone-100 hover:text-stone-900"
                            >
                                Produk
                            </a>

                            {{-- Employees - Owner Only --}}
                            @if(auth()->user()->role?->nama_role === 'Owner')
                                <a
                                    href="{{ route('employees.index') }}"
                                    class="block rounded-lg px-3 py-2 text-sm text-stone-600 hover:bg-stone-100 hover:text-stone-900"
                                >
                                    Karyawan
                                </a>
                            @endif

                            {{-- Raw Materials --}}
                            <a
                                href="{{ route('raw-materials.index') }}"
                                class="block rounded-lg px-3 py-2 text-sm text-stone-600 hover:bg-stone-100 hover:text-stone-900"
                            >
                                Bahan Baku
                            </a>

                        </div>
                    </div>

                    {{-- Inventory --}}
                    <div class="relative group">
                        <button
                            type="button"
                            class="flex items-center gap-1 rounded-lg px-3 py-2 text-sm font-medium text-stone-600 transition hover:bg-stone-100 hover:text-stone-900"
                        >
                            Persediaan
                            <svg
                                class="h-4 w-4"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M19 9l-7 7-7-7"
                                />
                            </svg>
                        </button>

                        <div
                            class="invisible absolute left-0 top-full z-50 w-52 rounded-xl border border-stone-200 bg-white p-1 opacity-0 shadow-lg transition-all group-hover:visible group-hover:opacity-100"
                        >

                            <a
                                href="{{ route('raw-material-stock-records.index') }}"
                                class="block rounded-lg px-3 py-2 text-sm text-stone-600 hover:bg-stone-100 hover:text-stone-900"
                            >
                                Catatan Stok
                            </a>

                            <a
                                href="{{ route('incoming-goods.index') }}"
                                class="block rounded-lg px-3 py-2 text-sm text-stone-600 hover:bg-stone-100 hover:text-stone-900"
                            >
                                Barang Masuk
                            </a>

                        </div>
                    </div>

                    {{-- Operations --}}
                    <div class="relative group">
                        <button
                            type="button"
                            class="flex items-center gap-1 rounded-lg px-3 py-2 text-sm font-medium text-stone-600 transition hover:bg-stone-100 hover:text-stone-900"
                        >
                            Operasional
                            <svg
                                class="h-4 w-4"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M19 9l-7 7-7-7"
                                />
                            </svg>
                        </button>

                        <div
                            class="invisible absolute left-0 top-full z-50 w-56 rounded-xl border border-stone-200 bg-white p-1 opacity-0 shadow-lg transition-all group-hover:visible group-hover:opacity-100"
                        >

                            <a
                                href="{{ route('sales.index') }}"
                                class="block rounded-lg px-3 py-2 text-sm text-stone-600 hover:bg-stone-100 hover:text-stone-900"
                            >
                                Penjualan
                            </a>

                            <a
                                href="{{ route('distributions.index') }}"
                                class="block rounded-lg px-3 py-2 text-sm text-stone-600 hover:bg-stone-100 hover:text-stone-900"
                            >
                                Distribusi
                            </a>

                            <a
                                href="{{ route('remaining-products.index') }}"
                                class="block rounded-lg px-3 py-2 text-sm text-stone-600 hover:bg-stone-100 hover:text-stone-900"
                            >
                                Produk Tersisa
                            </a>

                            <a
                                href="{{ route('operational-expenses.index') }}"
                                class="block rounded-lg px-3 py-2 text-sm text-stone-600 hover:bg-stone-100 hover:text-stone-900"
                            >
                                Pengeluaran Operasional
                            </a>

                        </div>
                    </div>

                    {{-- Financial Report - Owner Only --}}
                    @if(auth()->user()->role?->nama_role === 'Owner')
                        <a
                            href="{{ route('financial-reports.index') }}"
                            class="rounded-lg px-3 py-2 text-sm font-medium text-stone-600 transition hover:bg-stone-100 hover:text-stone-900"
                        >
                            Laporan Keuangan
                        </a>
                    @endif

                @endif

                {{-- Employee --}}
                @if(auth()->user()->role?->nama_role === 'Karyawan')

                    <a
                        href="{{ route('distributions.index') }}"
                        class="rounded-lg px-3 py-2 text-sm font-medium text-stone-600 transition hover:bg-stone-100 hover:text-stone-900"
                    >
                        Distribusi
                    </a>

                    <a
                        href="{{ route('sales.index') }}"
                        class="rounded-lg px-3 py-2 text-sm font-medium text-stone-600 transition hover:bg-stone-100 hover:text-stone-900"
                    >
                        Penjualan
                    </a>

                @endif

            </div>

            {{-- User Menu --}}
            <div
                x-data="{ open: false }"
                class="relative shrink-0"
            >
                <button
                    type="button"
                    @click="open = !open"
                    class="flex items-center gap-3 rounded-xl px-2 py-1.5 transition hover:bg-stone-100 focus:outline-none"
                >
                    {{-- Avatar --}}
                    <div
                        class="flex h-10 w-10 items-center justify-center rounded-full text-sm font-bold text-white"
                        style="background-color: #92400e;"
                    >
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>

                    {{-- User Information --}}
                    <div class="hidden text-left sm:block">
                        <div class="text-sm font-semibold text-stone-800">
                            {{ auth()->user()->name }}
                        </div>

                        <div class="text-xs text-stone-500">
                            {{ auth()->user()->role?->nama_role }}
                        </div>
                    </div>

                    {{-- Chevron --}}
                    <svg
                        class="hidden h-4 w-4 text-stone-400 transition-transform sm:block"
                        :class="{ 'rotate-180': open }"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M19 9l-7 7-7-7"
                        />
                    </svg>
                </button>

                {{-- Dropdown --}}
                <div
                    x-show="open"
                    x-cloak
                    @click.away="open = false"
                    x-transition:enter="transition ease-out duration-150"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-100"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="absolute right-0 top-full z-50 mt-2 w-56 origin-top-right rounded-2xl border border-stone-200 bg-white p-2 shadow-xl"
                >

                    {{-- User Header --}}
                    <div class="border-b border-stone-100 px-3 py-3">
                        <p class="text-sm font-semibold text-stone-800">
                            {{ auth()->user()->name }}
                        </p>

                        <p class="mt-0.5 text-xs text-stone-500">
                            {{ auth()->user()->role?->nama_role }}
                        </p>
                    </div>

                    {{-- Profile --}}
                    <a
                        href="{{ route('profile.edit') }}"
                        class="mt-2 flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-stone-700 transition hover:bg-stone-100"
                    >
                        <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-stone-100 text-stone-600">
                            <svg
                                class="h-5 w-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z
                                    M4.5 20.25a8.25 8.25 0 0115 0"
                                />
                            </svg>
                        </span>

                        <span>Profile</span>
                    </a>

                    {{-- Logout --}}
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <button
                            type="submit"
                            class="mt-1 flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-left text-sm font-medium text-red-600 transition hover:bg-red-50"
                        >
                            <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-red-50 text-red-500">
                                <svg
                                    class="h-5 w-5"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6A2.25 2.25 0 005.25 5.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15
                                    M18 15l3-3m0 0l-3-3m3 3H9"
                                    />
                                </svg>
                            </span>

                            <span>Logout</span>
                        </button>
                    </form>

                </div>
            </div>

        </div>
    </div>
</nav>
