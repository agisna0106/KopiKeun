<nav class="border-b border-stone-200 bg-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">

            {{-- Logo --}}
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
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

                <a
                    href="{{ route('dashboard') }}"
                    class="rounded-lg px-3 py-2 text-sm font-medium text-stone-600 transition hover:bg-stone-100 hover:text-stone-900"
                >
                    Dashboard
                </a>

               @if(in_array(auth()->user()->role?->nama_role, ['Owner', 'Admin']))
                    <a
                        href="{{ route('products.index') }}"
                        class="rounded-lg px-3 py-2 text-sm font-medium text-stone-600 transition hover:bg-stone-100 hover:text-stone-900"
                    >
                        Produk
                    </a>
                @endif

                <a
                    href="#"
                    class="rounded-lg px-3 py-2 text-sm font-medium text-stone-600 transition hover:bg-stone-100 hover:text-stone-900"
                >
                    Transaksi
                </a>

            </div>

            {{-- User --}}
            <div class="flex items-center gap-3">

                <div class="hidden text-right sm:block">
                    <div class="text-sm font-semibold text-stone-800">
                        {{ auth()->user()->name }}
                    </div>

                    <div class="text-xs text-stone-500">
                        {{ auth()->user()->role?->nama_role }}
                    </div>
                </div>

                <div class="flex h-9 w-9 items-center justify-center rounded-full bg-stone-200 text-sm font-semibold text-stone-700">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>

            </div>
        </div>
    </div>
</nav>