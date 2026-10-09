
<x-app-layout>

    <div class="mx-auto max-w-3xl px-4 py-5 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="mb-5">

            <a
                href="{{ route('base-drinks.index') }}"
                class="inline-flex items-center text-sm font-medium text-stone-500 transition hover:text-amber-900"
            >
                &larr; Kembali ke Minuman Dasar
            </a>

            <p class="mt-4 text-sm text-stone-500">
                Manajemen
            </p>

            <h1 class="mt-1 text-2xl font-bold text-stone-900">
                Ubah Minuman Dasar
            </h1>

            <p class="mt-1 text-sm text-stone-500">
                Perbarui informasi minuman dasar KopiKeun.
            </p>

        </div>

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

        <x-app-card>

            <form
                action="{{ route('base-drinks.update', $baseDrink) }}"
                method="POST"
                class="space-y-5"
            >
                @csrf
                @method('PUT')

                {{-- Name --}}
                <div>
                    <label
                        for="name"
                        class="mb-1.5 block text-sm font-semibold text-stone-700"
                    >
                        Nama Minuman Dasar
                        <span class="text-red-500">*</span>
                    </label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name', $baseDrink->name) }}"
                        placeholder="Contoh: Es Kopi Susu"
                        maxlength="100"
                        required
                        autofocus
                        class="w-full rounded-xl border border-stone-300 px-4 py-3 text-sm text-stone-900 outline-none transition placeholder:text-stone-400 focus:border-amber-800 focus:ring-2 focus:ring-amber-800/20"
                    >

                    @error('name')
                        <p class="mt-1.5 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Bottle Capacity --}}
                <div>
                    <label
                        for="bottle_capacity_ml"
                        class="mb-1.5 block text-sm font-semibold text-stone-700"
                    >
                        Kapasitas Botol (ml)
                        <span class="text-red-500">*</span>
                    </label>

                    <input
                        type="number"
                        id="bottle_capacity_ml"
                        name="bottle_capacity_ml"
                        value="{{ old('bottle_capacity_ml', $baseDrink->bottle_capacity_ml) }}"
                        min="0.01"
                        max="999999.99"
                        step="0.01"
                        required
                        class="w-full rounded-xl border border-stone-300 px-4 py-3 text-sm text-stone-900 outline-none transition focus:border-amber-800 focus:ring-2 focus:ring-amber-800/20"
                    >

                    <p class="mt-1.5 text-xs text-stone-500">
                        Kapasitas total minuman dalam satu botol.
                    </p>

                    @error('bottle_capacity_ml')
                        <p class="mt-1.5 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Standard Serving --}}
                <div>
                    <label
                        for="standard_serving_ml"
                        class="mb-1.5 block text-sm font-semibold text-stone-700"
                    >
                        Takaran Standar per Sajian (ml)
                        <span class="text-red-500">*</span>
                    </label>

                    <input
                        type="number"
                        id="standard_serving_ml"
                        name="standard_serving_ml"
                        value="{{ old('standard_serving_ml', $baseDrink->standard_serving_ml) }}"
                        min="0.01"
                        max="999999.99"
                        step="0.01"
                        required
                        class="w-full rounded-xl border border-stone-300 px-4 py-3 text-sm text-stone-900 outline-none transition focus:border-amber-800 focus:ring-2 focus:ring-amber-800/20"
                    >

                    <p class="mt-1.5 text-xs text-stone-500">
                        Takaran minuman dasar yang digunakan untuk satu sajian. Nilainya tidak boleh melebihi kapasitas botol.
                    </p>

                    @error('standard_serving_ml')
                        <p class="mt-1.5 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Status --}}
                <div>
                    <label
                        for="status"
                        class="mb-1.5 block text-sm font-semibold text-stone-700"
                    >
                        Status
                        <span class="text-red-500">*</span>
                    </label>

                    <select
                        id="status"
                        name="status"
                        required
                        class="w-full rounded-xl border border-stone-300 bg-white px-4 py-3 text-sm text-stone-900 outline-none transition focus:border-amber-800 focus:ring-2 focus:ring-amber-800/20"
                    >
                        <option
                            value="Active"
                            {{ old('status', $baseDrink->status) === 'Active' ? 'selected' : '' }}
                        >
                            Active
                        </option>

                        <option
                            value="Inactive"
                            {{ old('status', $baseDrink->status) === 'Inactive' ? 'selected' : '' }}
                        >
                            Inactive
                        </option>
                    </select>

                    @error('status')
                        <p class="mt-1.5 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Actions --}}
                <div class="flex flex-col-reverse gap-3 border-t border-stone-100 pt-5 sm:flex-row sm:justify-end">

                    <a
                        href="{{ route('base-drinks.index') }}"
                        class="inline-flex items-center justify-center rounded-xl border border-stone-300 px-5 py-3 text-sm font-semibold text-stone-700 transition hover:bg-stone-50"
                    >
                        Batal
                    </a>

                    <button
                        type="submit"
                        class="inline-flex items-center justify-center rounded-xl bg-amber-900 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-amber-950"
                    >
                        Simpan Perubahan
                    </button>

                </div>

            </form>

        </x-app-card>

    </div>

</x-app-layout>
