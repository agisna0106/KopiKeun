<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Incoming Goods
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form
                        action="{{ route('incoming-goods.update', $incomingGood) }}"
                        method="POST"
                        class="space-y-6"
                    >
                        @csrf
                        @method('PUT')

                        {{-- Raw Material --}}
                        <div>
                            <label
                                for="raw_material_id"
                                class="block text-sm font-medium text-gray-700"
                            >
                                Raw Material
                            </label>

                            <select
                                id="raw_material_id"
                                name="raw_material_id"
                                required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >
                                @foreach ($rawMaterials as $rawMaterial)
                                    <option
                                        value="{{ $rawMaterial->id }}"
                                        {{ old('raw_material_id', $incomingGood->raw_material_id) == $rawMaterial->id ? 'selected' : '' }}
                                    >
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

                        {{-- Quantity --}}
                        <div>
                            <label
                                for="quantity"
                                class="block text-sm font-medium text-gray-700"
                            >
                                Quantity
                            </label>

                            <input
                                type="number"
                                id="quantity"
                                name="quantity"
                                value="{{ old('quantity', $incomingGood->quantity) }}"
                                step="0.01"
                                min="0.01"
                                required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >

                            @error('quantity')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Unit Cost --}}
                        <div>
                            <label
                                for="unit_cost"
                                class="block text-sm font-medium text-gray-700"
                            >
                                Unit Cost
                            </label>

                            <input
                                type="number"
                                id="unit_cost"
                                name="unit_cost"
                                value="{{ old('unit_cost', $incomingGood->unit_cost) }}"
                                step="0.01"
                                min="0"
                                required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >

                            @error('unit_cost')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Received At --}}
                        <div>
                            <label
                                for="received_at"
                                class="block text-sm font-medium text-gray-700"
                            >
                                Received At
                            </label>

                            <input
                                type="date"
                                id="received_at"
                                name="received_at"
                                value="{{ old('received_at', $incomingGood->received_at->format('Y-m-d')) }}"
                                required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >

                            @error('received_at')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Supplier --}}
                        <div>
                            <label
                                for="supplier"
                                class="block text-sm font-medium text-gray-700"
                            >
                                Supplier
                            </label>

                            <input
                                type="text"
                                id="supplier"
                                name="supplier"
                                value="{{ old('supplier', $incomingGood->supplier) }}"
                                maxlength="100"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >

                            @error('supplier')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Notes --}}
                        <div>
                            <label
                                for="notes"
                                class="block text-sm font-medium text-gray-700"
                            >
                                Notes
                            </label>

                            <textarea
                                id="notes"
                                name="notes"
                                rows="4"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >{{ old('notes', $incomingGood->notes) }}</textarea>

                            @error('notes')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Buttons --}}
                        <div class="flex items-center justify-end gap-3">
                            <a
                                href="{{ route('incoming-goods.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-200"
                            >
                                Cancel
                            </a>

                            <button
                                type="submit"
                                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700"
                            >
                                Update Incoming Goods
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
