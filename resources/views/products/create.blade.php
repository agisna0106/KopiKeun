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

            <form method="POST" action="{{ route('products.store') }}" class="space-y-5">
                @csrf

                {{-- Nama Produk --}}
                <div>
                    <label
                        for="name"
                        class="block text-sm font-medium text-stone-700"
                    >
                        Nama Produk
                    </label>

                    <input
                        type="text"
                        name="name"
                        id="name"
                        value="{{ old('name') }}"
                        required
                        class="mt-1 block w-full rounded-lg border-stone-300 shadow-sm
                            focus:border-amber-600 focus:ring-amber-600"
                    >

                    @error('name')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Minuman Dasar --}}
                <div>
                    <label
                        for="base_drink_id"
                        class="block text-sm font-medium text-stone-700"
                    >
                        Minuman Dasar
                    </label>

                    <select
                        name="base_drink_id"
                        id="base_drink_id"
                        required
                        class="mt-1 block w-full rounded-lg border-stone-300 shadow-sm
                            focus:border-amber-600 focus:ring-amber-600"
                    >
                        <option value="">Pilih Minuman Dasar</option>

                        @foreach ($baseDrinks as $baseDrink)
                            <option
                                value="{{ $baseDrink->id }}"
                                {{ old('base_drink_id') == $baseDrink->id ? 'selected' : '' }}
                            >
                                {{ $baseDrink->name }}
                            </option>
                        @endforeach
                    </select>

                    @error('base_drink_id')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Harga --}}
                <div>
                    <label
                        for="price"
                        class="block text-sm font-medium text-stone-700"
                    >
                        Harga
                    </label>

                    <input
                        type="number"
                        name="price"
                        id="price"
                        value="{{ old('price') }}"
                        min="0"
                        step="0.01"
                        required
                        class="mt-1 block w-full rounded-lg border-stone-300 shadow-sm
                            focus:border-amber-600 focus:ring-amber-600"
                    >

                    @error('price')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Status --}}
                <div>
                    <label
                        for="status"
                        class="block text-sm font-medium text-stone-700"
                    >
                        Status
                    </label>

                    <select
                        name="status"
                        id="status"
                        required
                    >
                        <option
                            value="Active"
                            {{ old('status', 'Active') === 'Active' ? 'selected' : '' }}
                        >
                            Active
                        </option>

                        <option
                            value="Inactive"
                            {{ old('status') === 'Inactive' ? 'selected' : '' }}
                        >
                            Inactive
                        </option>
                    </select>

                    @error('status')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Tombol --}}
                <div class="flex flex-col gap-2 sm:flex-row">
                    <button
                        type="submit"
                        class="inline-flex justify-center rounded-lg bg-amber-700
                            px-4 py-2 text-sm font-semibold text-white
                            hover:bg-amber-800"
                    >
                        Simpan Produk
                    </button>

                    <a
                        href="{{ route('products.index') }}"
                        class="inline-flex justify-center rounded-lg bg-stone-200
                            px-4 py-2 text-sm font-semibold text-stone-700
                            hover:bg-stone-300"
                    >
                        Batal
                    </a>
                </div>
            </form>

        </x-app-card>

    </div>

</x-app-layout>
