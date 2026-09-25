<x-app-layout>

    <div class="mx-auto max-w-7xl px-4 py-5 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="mb-5 flex items-start justify-between gap-3">

            <div>
                <p class="text-sm text-stone-500">
                    Manajemen
                </p>

                <h1 class="mt-1 text-2xl font-bold text-stone-900">
                    Produk
                </h1>

                <p class="mt-1 text-sm text-stone-500">
                    Kelola produk yang dijual KopiKeun.
                </p>
            </div>

            <a
                href="{{ route('products.create') }}"
                class="inline-flex shrink-0 items-center justify-center rounded-xl bg-amber-900 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-amber-950"
            >
                + Tambah
            </a>

        </div>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="mb-4 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                {{ session('success') }}
            </div>
        @endif

        {{-- Validation Error --}}
        @if($errors->any())
            <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                <ul class="list-inside list-disc">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Product List --}}
        @if($products->isEmpty())

            <x-app-card class="text-center">

                <div class="py-8">

                    <div class="text-4xl">
                        ☕
                    </div>

                    <h2 class="mt-3 text-base font-semibold text-stone-800">
                        Belum ada produk
                    </h2>

                    <p class="mt-1 text-sm text-stone-500">
                        Tambahkan produk pertama KopiKeun.
                    </p>

                    <a
                        href="{{ route('products.create') }}"
                        class="mt-5 inline-flex rounded-xl bg-amber-900 px-4 py-2.5 text-sm font-semibold text-white"
                    >
                        Tambah Produk
                    </a>

                </div>

            </x-app-card>

        @else

            <div class="space-y-3">

                @foreach($products as $product)

                    <x-app-card>

                        <div class="flex items-start justify-between gap-3">

                            <div class="min-w-0">

                                <h2 class="truncate text-base font-bold text-stone-900">
                                    {{ $product->name }}
                                </h2>

                                <p class="mt-1 text-sm text-stone-500">
                                    Dasar: {{ $product->baseDrink?->name ?? 'No Base Drink' }}
                                </p>

                                <p class="mt-1 text-lg font-bold text-amber-900">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </p>

                                <span
                                    class="mt-2 inline-flex rounded-full px-2.5 py-1 text-xs font-semibold
                                    {{ $product->status === 'Active'
                                        ? 'bg-green-100 text-green-700'
                                        : 'bg-stone-100 text-stone-600'
                                    }}"
                                >
                                    {{ $product->status }}
                                </span>

                            </div>

                            <div class="flex shrink-0 items-center gap-2">

                                <a
                                    href="{{ route('products.edit', $product) }}"
                                    class="rounded-lg bg-stone-100 px-3 py-2 text-xs font-semibold text-stone-700 hover:bg-stone-200"
                                >
                                    Ubah
                                </a>

                                <form
                                    action="{{ route('products.destroy', $product) }}"
                                    method="POST"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')"
                                        class="rounded-lg bg-red-50 px-3 py-2 text-xs font-semibold text-red-600 hover:bg-red-100"
                                    >
                                        Hapus
                                    </button>

                                </form>

                            </div>

                        </div>

                    </x-app-card>

                @endforeach

            </div>

        @endif

    </div>

</x-app-layout>
