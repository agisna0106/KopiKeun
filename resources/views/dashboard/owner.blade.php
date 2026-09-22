<x-app-layout>

    <div class="mx-auto max-w-7xl px-4 py-5 sm:px-6 lg:px-8">

        {{-- Welcome --}}
        <div class="mb-6">
            <p class="text-sm text-stone-500">
                Selamat datang kembali,
            </p>

            <h1 class="mt-1 text-2xl font-bold text-stone-900">
                {{ auth()->user()->name }}
            </h1>

            <p class="mt-1 text-sm text-stone-500">
                Kelola operasional KopiKeun dengan mudah.
            </p>
        </div>

        {{-- Main Statistic --}}
        <div class="mb-4">
            <x-stat-card
                title="Penjualan Hari Ini"
                value="Rp 0"
                description="Belum ada transaksi"
            />
        </div>

        {{-- Statistics --}}
        <div class="grid grid-cols-2 gap-3">

            <x-stat-card
                title="Produk"
                value="0"
                description="Produk aktif"
            />

            <x-stat-card
                title="Transaksi"
                value="0"
                description="Hari ini"
            />

            <x-stat-card
                title="Karyawan"
                value="0"
                description="Karyawan aktif"
            />

            <x-stat-card
                title="Stok Bahan"
                value="0"
                description="Perlu diperiksa"
            />

        </div>

        {{-- Quick Actions --}}
        <div class="mt-6">

            <h2 class="mb-3 text-base font-bold text-stone-900">
                Akses Cepat
            </h2>

            <div class="grid grid-cols-2 gap-3">

                <x-app-card class="text-center">
                    <div class="text-2xl">🛒</div>

                    <div class="mt-2 text-sm font-semibold text-stone-800">
                        Transaksi
                    </div>

                    <div class="mt-1 text-xs text-stone-500">
                        Penjualan
                    </div>
                </x-app-card>

                <x-app-card class="text-center">
                    <div class="text-2xl">📦</div>

                    <div class="mt-2 text-sm font-semibold text-stone-800">
                        Produk
                    </div>

                    <div class="mt-1 text-xs text-stone-500">
                        Kelola produk
                    </div>
                </x-app-card>

            </div>

        </div>

    </div>

</x-app-layout>