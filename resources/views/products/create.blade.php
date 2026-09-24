<x-app-layout>

    <div class="mx-auto max-w-2xl px-4 py-5 sm:px-6 lg:px-8">

        <div class="mb-5">

            <a
                href="{{ route('products.index') }}"
                class="text-sm font-medium text-amber-900"
            >
                ← Kembali ke Produk
            </a>

            <h1 class="mt-4 text-2xl font-bold text-stone-900">
                Tambah Produk
            </h1>

            <p class="mt-1 text-sm text-stone-500">
                Tambahkan produk baru yang dijual KopiKeun.
            </p>

        </div>

        <x-app-card>

            <form
                action="{{ route('products.store') }}"
                method="POST"
                class="space-y-5"
            >

                @csrf

                {{-- Nama Produk --}}
                <div>

                    <label
                        for="nama_produk"
                        class="mb-2 block text-sm font-semibold text-stone-700"
                    >
                        Nama Produk
                    </label>

                    <input
                        type="text"
                        id="nama_produk"
                        name="nama_produk"
                        value="{{ old('nama_produk') }}"
                        placeholder="Contoh: Kopi Susu"
                        required
                        class="w-full rounded-xl border-stone-300 px-4 py-3 text-sm focus:border-amber-900 focus:ring-amber-900"
                    >

                    @error('nama_produk')
                        <p class="mt-1 text-xs text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                {{-- Harga --}}
                <div>

                    <label
                        for="harga"
                        class="mb-2 block text-sm font-semibold text-stone-700"
                    >
                        Harga Jual
                    </label>

                    <div class="relative">

                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-sm text-stone-500">
                            Rp
                        </span>

                        <input
                            type="number"
                            id="harga"
                            name="harga"
                            value="{{ old('harga') }}"
                            min="0"
                            step="100"
                            placeholder="10000"
                            required
                            class="w-full rounded-xl border-stone-300 py-3 pl-11 pr-4 text-sm focus:border-amber-900 focus:ring-amber-900"
                        >

                    </div>

                    @error('harga')
                        <p class="mt-1 text-xs text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                {{-- Status --}}
                <div>

                    <label
                        for="status"
                        class="mb-2 block text-sm font-semibold text-stone-700"
                    >
                        Status
                    </label>

                    <select
                        id="status"
                        name="status"
                        required
                        class="w-full rounded-xl border-stone-300 px-4 py-3 text-sm focus:border-amber-900 focus:ring-amber-900"
                    >
                        <option value="Aktif" @selected(old('status', 'Aktif') === 'Aktif')>
                            Aktif
                        </option>

                        <option value="Tidak Aktif" @selected(old('status') === 'Tidak Aktif')>
                            Tidak Aktif
                        </option>
                    </select>

                    @error('status')
                        <p class="mt-1 text-xs text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                {{-- Button --}}
                <div class="flex gap-3 pt-2">

                    <a
                        href="{{ route('products.index') }}"
                        class="flex-1 rounded-xl border border-stone-300 px-4 py-3 text-center text-sm font-semibold text-stone-700"
                    >
                        Batal
                    </a>

                    <button
                        type="submit"
                        class="flex-1 rounded-xl bg-amber-900 px-4 py-3 text-sm font-semibold text-white hover:bg-amber-950"
                    >
                        Simpan Produk
                    </button>

                </div>

            </form>

        </x-app-card>

    </div>

</x-app-layout>