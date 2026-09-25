<x-app-layout>

    <x-slot name="header">
        <div>
            <h2 class="text-xl font-bold text-stone-900">
                Edit Stock Record
            </h2>

            <p class="mt-1 text-sm text-stone-500">
                Update a raw material stock recording.
            </p>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">

            <x-app-card>

                <form
                    method="POST"
                    action="{{ route('raw-material-stock-records.update', $rawMaterialStockRecord) }}"
                    class="space-y-5">

                    @csrf
                    @method('PUT')

                    {{-- Raw Material --}}
                    <div>
                        <label
                            for="raw_material_id"
                            class="block text-sm font-medium text-stone-700">
                            Raw Material
                        </label>

                        <select
                            name="raw_material_id"
                            id="raw_material_id"
                            required
                            class="mt-1 block w-full rounded-lg border-stone-300 shadow-sm focus:border-amber-600 focus:ring-amber-600">

                            <option value="">
                                Select Raw Material
                            </option>

                            @foreach ($rawMaterials as $rawMaterial)
                                <option
                                    value="{{ $rawMaterial->id }}"
                                    {{ old(
                                        'raw_material_id',
                                        $rawMaterialStockRecord->raw_material_id
                                    ) == $rawMaterial->id ? 'selected' : '' }}>

                                    {{ $rawMaterial->name }}
                                    ({{ $rawMaterial->unit }})

                                </option>
                            @endforeach

                        </select>

                        @error('raw_material_id')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Stock --}}
                    <div>
                        <label
                            for="stock"
                            class="block text-sm font-medium text-stone-700">
                            Actual Stock
                        </label>

                        <input
                            type="number"
                            name="stock"
                            id="stock"
                            value="{{ old(
                                'stock',
                                $rawMaterialStockRecord->stock
                            ) }}"
                            min="0"
                            step="0.01"
                            required
                            class="mt-1 block w-full rounded-lg border-stone-300 shadow-sm focus:border-amber-600 focus:ring-amber-600">

                        @error('stock')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Recorded Date --}}
                    <div>
                        <label
                            for="recorded_at"
                            class="block text-sm font-medium text-stone-700">
                            Recorded Date
                        </label>

                        <input
                            type="date"
                            name="recorded_at"
                            id="recorded_at"
                            value="{{ old(
                                'recorded_at',
                                $rawMaterialStockRecord->recorded_at->format('Y-m-d')
                            ) }}"
                            required
                            class="mt-1 block w-full rounded-lg border-stone-300 shadow-sm focus:border-amber-600 focus:ring-amber-600">

                        @error('recorded_at')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Notes --}}
                    <div>
                        <label
                            for="notes"
                            class="block text-sm font-medium text-stone-700">
                            Notes
                        </label>

                        <textarea
                            name="notes"
                            id="notes"
                            rows="3"
                            class="mt-1 block w-full rounded-lg border-stone-300 shadow-sm focus:border-amber-600 focus:ring-amber-600">{{ old('notes', $rawMaterialStockRecord->notes) }}</textarea>

                        @error('notes')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Buttons --}}
                    <div class="flex flex-col gap-2 sm:flex-row">

                        <button
                            type="submit"
                            class="inline-flex justify-center rounded-lg bg-amber-700 px-4 py-2 text-sm font-semibold text-white hover:bg-amber-800">
                            Update Stock Record
                        </button>

                        <a
                            href="{{ route('raw-material-stock-records.index') }}"
                            class="inline-flex justify-center rounded-lg bg-stone-200 px-4 py-2 text-sm font-semibold text-stone-700 hover:bg-stone-300">
                            Cancel
                        </a>

                    </div>

                </form>

            </x-app-card>

        </div>
    </div>

</x-app-layout>
