<x-app-layout>

    <x-slot name="header">
        <div>
            <h2 class="text-xl font-bold text-stone-900">
                Add Raw Material
            </h2>

            <p class="mt-1 text-sm text-stone-500">
                Add a new raw material and define its stock level.
            </p>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">

            <x-app-card>

                <form
                    method="POST"
                    action="{{ route('raw-materials.store') }}"
                    class="space-y-5">

                    @csrf

                    {{-- Name --}}
                    <div>
                        <label
                            for="name"
                            class="block text-sm font-medium text-stone-700">
                            Raw Material Name
                        </label>

                        <input
                            type="text"
                            name="name"
                            id="name"
                            value="{{ old('name') }}"
                            placeholder="e.g. Fresh Milk"
                            required
                            class="mt-1 block w-full rounded-lg border-stone-300 shadow-sm focus:border-amber-600 focus:ring-amber-600">

                        @error('name')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Unit --}}
                    <div>
                        <label
                            for="unit"
                            class="block text-sm font-medium text-stone-700">
                            Unit
                        </label>

                        <input
                            type="text"
                            name="unit"
                            id="unit"
                            value="{{ old('unit') }}"
                            placeholder="e.g. kg, liter, pcs"
                            required
                            class="mt-1 block w-full rounded-lg border-stone-300 shadow-sm focus:border-amber-600 focus:ring-amber-600">

                        @error('unit')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Current Stock --}}
                    <div>
                        <label
                            for="current_stock"
                            class="block text-sm font-medium text-stone-700">
                            Current Stock
                        </label>

                        <input
                            type="number"
                            name="current_stock"
                            id="current_stock"
                            value="{{ old('current_stock', 0) }}"
                            min="0"
                            step="0.01"
                            required
                            class="mt-1 block w-full rounded-lg border-stone-300 shadow-sm focus:border-amber-600 focus:ring-amber-600">

                        @error('current_stock')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Minimum Stock --}}
                    <div>
                        <label
                            for="minimum_stock"
                            class="block text-sm font-medium text-stone-700">
                            Minimum Stock
                        </label>

                        <input
                            type="number"
                            name="minimum_stock"
                            id="minimum_stock"
                            value="{{ old('minimum_stock', 0) }}"
                            min="0"
                            step="0.01"
                            required
                            class="mt-1 block w-full rounded-lg border-stone-300 shadow-sm focus:border-amber-600 focus:ring-amber-600">

                        @error('minimum_stock')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Status --}}
                    <div>
                        <label
                            for="status"
                            class="block text-sm font-medium text-stone-700">
                            Status
                        </label>

                        <select
                            name="status"
                            id="status"
                            required
                            class="mt-1 block w-full rounded-lg border-stone-300 shadow-sm focus:border-amber-600 focus:ring-amber-600">

                            <option
                                value="Active"
                                {{ old('status', 'Active') === 'Active' ? 'selected' : '' }}>
                                Active
                            </option>

                            <option
                                value="Inactive"
                                {{ old('status') === 'Inactive' ? 'selected' : '' }}>
                                Inactive
                            </option>

                        </select>

                        @error('status')
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
                            Save Raw Material
                        </button>

                        <a
                            href="{{ route('raw-materials.index') }}"
                            class="inline-flex justify-center rounded-lg bg-stone-200 px-4 py-2 text-sm font-semibold text-stone-700 hover:bg-stone-300">
                            Cancel
                        </a>

                    </div>

                </form>

            </x-app-card>

        </div>
    </div>

</x-app-layout>
