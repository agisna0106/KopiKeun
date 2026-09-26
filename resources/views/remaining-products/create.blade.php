<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Add Remaining Product
            </h2>

            <a
                href="{{ route('remaining-products.index') }}"
                class="rounded-md border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
            >
                Back
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto w-full max-w-5xl px-4 sm:px-6 lg:px-8">

            @if ($errors->any())
                <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3">
                    <ul class="list-disc space-y-1 pl-5 text-sm text-red-700">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form
                action="{{ route('remaining-products.store') }}"
                method="POST"
                class="space-y-6"
            >
                @csrf

                {{-- General Information --}}
                <div class="rounded-xl bg-white p-6 shadow-sm">
                    <h3 class="mb-4 text-lg font-semibold text-gray-800">
                        General Information
                    </h3>

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                        <div>
                            <label
                                for="recorded_at"
                                class="mb-2 block text-sm font-medium text-gray-700"
                            >
                                Date
                            </label>

                            <input
                                type="date"
                                name="recorded_at"
                                id="recorded_at"
                                value="{{ old('recorded_at', now()->format('Y-m-d')) }}"
                                required
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500"
                            >
                        </div>

                        <div>
                            <label
                                for="notes"
                                class="mb-2 block text-sm font-medium text-gray-700"
                            >
                                Notes
                            </label>

                            <input
                                type="text"
                                name="notes"
                                id="notes"
                                value="{{ old('notes') }}"
                                placeholder="Optional notes"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500"
                            >
                        </div>

                    </div>
                </div>

                {{-- Base Drinks --}}
                <div class="rounded-xl bg-white p-6 shadow-sm">

                    <div class="mb-4 flex items-center justify-between gap-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">
                                Remaining Base Drinks
                            </h3>

                            <p class="mt-1 text-sm text-gray-500">
                                Enter the estimated remaining servings for each base drink.
                            </p>
                        </div>

                        <button
                            type="button"
                            id="add-base-drink"
                            class="shrink-0 rounded-md px-4 py-2 text-sm font-semibold text-white shadow-sm hover:opacity-90"
                            style="background-color: #ea580c;"
                        >
                            Add Base Drink
                        </button>
                    </div>

                    <div
                        id="base-drink-list"
                        class="space-y-4"
                    ></div>

                    <div class="mt-6 rounded-lg border border-orange-200 bg-orange-50 p-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-700">
                                Total Estimated Servings
                            </span>

                            <span
                                id="total-quantity"
                                class="text-lg font-bold text-gray-900"
                            >
                                0
                            </span>
                        </div>
                    </div>

                </div>

                {{-- Actions --}}
                <div class="flex items-center justify-end gap-3">

                    <a
                        href="{{ route('remaining-products.index') }}"
                        class="rounded-md border border-gray-300 px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50"
                    >
                        Cancel
                    </a>

                    <button
                        type="submit"
                        class="rounded-md px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:opacity-90"
                        style="background-color: #ea580c;"
                    >
                        Save Remaining Product
                    </button>

                </div>

            </form>

        </div>
    </div>

    <script>
        const baseDrinks = @js(
            $baseDrinks->map(function ($baseDrink) {
                return [
                    'id' => $baseDrink->id,
                    'name' => $baseDrink->name,
                    'bottle_capacity_ml' => $baseDrink->bottle_capacity_ml,
                    'standard_serving_ml' => $baseDrink->standard_serving_ml,
                ];
            })->values()
        );

        const baseDrinkList = document.getElementById('base-drink-list');
        const addBaseDrinkButton = document.getElementById('add-base-drink');
        const totalQuantityElement = document.getElementById('total-quantity');

        function updateTotalQuantity() {
            const quantityInputs = document.querySelectorAll(
                '.base-drink-quantity'
            );

            let total = 0;

            quantityInputs.forEach((input) => {
                const quantity = parseFloat(input.value);

                if (!isNaN(quantity)) {
                    total += quantity;
                }
            });

            totalQuantityElement.textContent =
                new Intl.NumberFormat('en-US', {
                    maximumFractionDigits: 2
                }).format(total);
        }

        function updateBaseDrinkOptions() {
            const selectedValues = Array.from(
                document.querySelectorAll('.base-drink-select')
            )
                .map(select => select.value)
                .filter(value => value !== '');

            document.querySelectorAll('.base-drink-select').forEach(select => {
                const currentValue = select.value;

                Array.from(select.options).forEach(option => {
                    if (option.value === '') {
                        return;
                    }

                    option.disabled =
                        selectedValues.includes(option.value) &&
                        option.value !== currentValue;
                });
            });
        }

        function createBaseDrinkRow() {
            const index = document.querySelectorAll(
                '.base-drink-row'
            ).length;

            const row = document.createElement('div');

            row.className =
                'base-drink-row rounded-lg border border-gray-200 p-4';

            row.innerHTML = `
                <div class="grid grid-cols-1 gap-4 md:grid-cols-12">

                    <div class="md:col-span-6">
                        <label class="mb-2 block text-sm font-medium text-gray-700">
                            Base Drink
                        </label>

                        <select
                            name="base_drinks[${index}][base_drink_id]"
                            class="base-drink-select w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500"
                            required
                        >
                            <option value="">
                                Select Base Drink
                            </option>
                        </select>

                        <div class="base-drink-info mt-2 text-xs text-gray-500">
                            Select a base drink to see its information.
                        </div>
                    </div>

                    <div class="md:col-span-4">
                        <label class="mb-2 block text-sm font-medium text-gray-700">
                            Remaining Servings
                        </label>

                        <input
                            type="number"
                            name="base_drinks[${index}][quantity]"
                            class="base-drink-quantity w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500"
                            min="0"
                            step="0.01"
                            value="0"
                            required
                        >
                    </div>

                    <div class="flex items-end justify-end md:col-span-2">
                        <button
                            type="button"
                            class="remove-base-drink w-full rounded-md border border-red-300 px-3 py-2 text-sm font-medium text-red-600 hover:bg-red-50 md:w-auto"
                        >
                            Remove
                        </button>
                    </div>

                </div>
            `;

            const select = row.querySelector('.base-drink-select');
            const quantityInput = row.querySelector('.base-drink-quantity');
            const info = row.querySelector('.base-drink-info');
            const removeButton = row.querySelector('.remove-base-drink');

            baseDrinks.forEach((baseDrink) => {
                const option = document.createElement('option');

                option.value = baseDrink.id;
                option.textContent = baseDrink.name;

                select.appendChild(option);
            });

            function updateInfo() {
                const selectedId = parseInt(select.value);

                const baseDrink = baseDrinks.find(
                    item => item.id === selectedId
                );

                if (!baseDrink) {
                    info.textContent =
                        'Select a base drink to see its information.';
                    return;
                }

                info.textContent =
                    `Bottle capacity: ${baseDrink.bottle_capacity_ml} ml | ` +
                    `Standard serving: ${baseDrink.standard_serving_ml} ml`;
            }

            select.addEventListener('change', () => {
                updateInfo();
                updateBaseDrinkOptions();
            });

            quantityInput.addEventListener(
                'input',
                updateTotalQuantity
            );

            removeButton.addEventListener('click', () => {
                row.remove();

                updateBaseDrinkOptions();
                updateTotalQuantity();
            });

            baseDrinkList.appendChild(row);

            updateBaseDrinkOptions();
            updateTotalQuantity();
        }

        addBaseDrinkButton.addEventListener(
            'click',
            createBaseDrinkRow
        );

        createBaseDrinkRow();
    </script>
</x-app-layout>
