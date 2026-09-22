<x-app-layout>

    <div class="mx-auto max-w-7xl px-4 py-5 sm:px-6 lg:px-8">

        <div class="mb-6">
            <p class="text-sm text-stone-500">
                Selamat datang,
            </p>

            <h1 class="mt-1 text-2xl font-bold text-stone-900">
                {{ auth()->user()->name }}
            </h1>

            <p class="mt-1 text-sm text-stone-500">
                Siap melayani pelanggan hari ini?
            </p>
        </div>

        <div class="mb-4">
            <x-stat-card
                title="Penjualan Hari Ini"
                value="Rp 0"
                description="Belum ada transaksi"
            />
        </div>

        <div class="grid grid-cols-2 gap-3">

            <x-stat-card
                title="Transaksi"
                value="0"
                description="Hari ini"
            />

            <x-stat-card
                title="Produk"
                value="0"
                description="Tersedia"
            />

        </div>

        <div class="mt-6">

            <h2 class="mb-3 text-base font-bold text-stone-900">
                Menu Utama
            </h2>

            <x-app-card>

                <div class="flex items-center justify-between">

                    <div>
                        <div class="text-sm font-semibold text-stone-800">
                            Buat Transaksi
                        </div>

                        <div class="mt-1 text-xs text-stone-500">
                            Catat penjualan pelanggan
                        </div>
                    </div>

                    <div class="text-2xl">
                        🛒
                    </div>

                </div>

            </x-app-card>

        </div>

    </div>

</x-app-layout>