
<x-app-layout>

    <div class="mx-auto max-w-7xl px-4 py-5 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="mb-5 flex items-start justify-between gap-3">

            <div>
                <p class="text-sm text-stone-500">
                    Manajemen
                </p>

                <h1 class="mt-1 text-2xl font-bold text-stone-900">
                    Minuman Dasar
                </h1>

                <p class="mt-1 text-sm text-stone-500">
                    Kelola minuman dasar yang digunakan dalam produk KopiKeun.
                </p>
            </div>

            <a
                href="{{ route('base-drinks.create') }}"
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

        {{-- Error Message --}}
        @if(session('error'))
            <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                {{ session('error') }}
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

        {{-- Base Drink List --}}
        @if($baseDrinks->isEmpty())

            <x-app-card class="text-center">

                <div class="py-8">

                    <div class="text-4xl">
                        🥤
                    </div>

                    <h2 class="mt-3 text-base font-semibold text-stone-800">
                        Belum ada minuman dasar
                    </h2>

                    <p class="mt-1 text-sm text-stone-500">
                        Tambahkan minuman dasar pertama KopiKeun.
                    </p>

                    <a
                        href="{{ route('base-drinks.create') }}"
                        class="mt-5 inline-flex rounded-xl bg-amber-900 px-4 py-2.5 text-sm font-semibold text-white"
                    >
                        Tambah Minuman Dasar
                    </a>

                </div>

            </x-app-card>

        @else

            <div class="space-y-3">

                @foreach($baseDrinks as $baseDrink)

                    <x-app-card>

                        <div class="flex items-start justify-between gap-3">

                            <div class="min-w-0 flex-1">

                                <h2 class="truncate text-base font-bold text-stone-900">
                                    {{ $baseDrink->name }}
                                </h2>

                                <div class="mt-2 space-y-1 text-sm text-stone-500">

                                    <p>
                                        Kapasitas botol:
                                        <span class="font-medium text-stone-700">
                                            {{ number_format((float) $baseDrink->bottle_capacity_ml, 2, ',', '.') }} ml
                                        </span>
                                    </p>

                                    <p>
                                        Takaran standar:
                                        <span class="font-medium text-stone-700">
                                            {{ number_format((float) $baseDrink->standard_serving_ml, 2, ',', '.') }} ml
                                        </span>
                                    </p>

                                    <p>
                                        Produk terkait:
                                        <span class="font-medium text-stone-700">
                                            {{ $baseDrink->products_count ?? $baseDrink->products()->count() }} produk
                                        </span>
                                    </p>

                                </div>

                                <span
                                    class="mt-3 inline-flex rounded-full px-2.5 py-1 text-xs font-semibold
                                    {{ $baseDrink->status === 'Active'
                                        ? 'bg-green-100 text-green-700'
                                        : 'bg-stone-100 text-stone-600'
                                    }}"
                                >
                                    {{ $baseDrink->status }}
                                </span>

                            </div>

                            <div class="flex shrink-0 items-center gap-2">

                                <a
                                    href="{{ route('base-drinks.edit', $baseDrink) }}"
                                    class="rounded-lg bg-stone-100 px-3 py-2 text-xs font-semibold text-stone-700 hover:bg-stone-200"
                                >
                                    Ubah
                                </a>

                                <form
                                    action="{{ route('base-drinks.destroy', $baseDrink) }}"
                                    method="POST"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus minuman dasar ini?')"
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
