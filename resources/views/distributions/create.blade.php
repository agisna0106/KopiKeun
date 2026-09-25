<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Add Distribution
            </h2>

            <a
                href="{{ route('distributions.index') }}"
                class="inline-flex items-center rounded-md bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-300"
            >
                Back
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto w-full max-w-5xl px-4 sm:px-6 lg:px-8">

            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="mb-6 rounded-md bg-red-50 p-4">
                    <div class="text-sm font-medium text-red-800">
                        Please fix the following errors:
                    </div>

                    <ul class="mt-2 list-disc pl-5 text-sm text-red-700">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form
                method="POST"
                action="{{ route('distributions.store') }}"
                class="space-y-6"
            >
                @csrf

                {{-- Distribution Information --}}
                <div class="rounded-lg bg-white p-6 shadow-sm">

                    <h3 class="mb-4 text-lg font-semibold text-gray-800">
                        Distribution Information
                    </h3>

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                        {{-- Employee --}}
                        <div>
                            <x-input-label
                                for="employee_id"
                                value="Employee"
                            />

                            <select
                                id="employee_id"
                                name="employee_id"
                                required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500"
                            >
                                <option value="">
                                    Select Employee
                                </option>

                                @foreach ($employees as $employee)
                                    <option
                                        value="{{ $employee->id }}"
                                        {{ old('employee_id') == $employee->id ? 'selected' : '' }}
                                    >
                                        {{ $employee->user->name }}
                                        - {{ $employee->employee_code }}
                                    </option>
                                @endforeach
                            </select>

                            <x-input-error
                                :messages="$errors->get('employee_id')"
                                class="mt-2"
                            />
                        </div>

                        {{-- Distribution Date --}}
                        <div>
                            <x-input-label
                                for="distribution_date"
                                value="Distribution Date"
                            />

                            <x-text-input
                                id="distribution_date"
                                name="distribution_date"
                                type="date"
                                class="mt-1 block w-full"
                                value="{{ old('distribution_date', now()->format('Y-m-d')) }}"
                                required
                            />

                            <x-input-error
                                :messages="$errors->get('distribution_date')"
                                class="mt-2"
                            />
                        </div>

                        {{-- Notes --}}
                        <div class="md:col-span-2">
                            <x-input-label
                                for="notes"
                                value="Notes"
                            />

                            <textarea
                                id="notes"
                                name="notes"
                                rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500"
                                placeholder="Optional notes"
                            >{{ old('notes') }}</textarea>

                            <x-input-error
                                :messages="$errors->get('notes')"
                                class="mt-2"
                            />
                        </div>

                    </div>
                </div>

                {{-- Base Drinks --}}
                <div class="rounded-lg bg-white p-6 shadow-sm">

                    <div class="mb-4 flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">
                                Base Drinks
                            </h3>

                            <p class="mt-1 text-sm text-gray-500">
                                Enter the estimated number of servings distributed.
                            </p>
                        </div>

                        <button
                            type="button"
                            id="add-base-drink"
                            class="inline-flex items-center rounded-md px-4 py-2 text-sm font-semibold text-white shadow-sm hover:opacity-90"
                            style="background-color: #ea580c; color: white;"
                        >
                            Add Base Drink
                        </button>
                    </div>

                    <div
                        id="base-drink-list"
                        class="space-y-4"
                    ></div>

                    {{-- Total Servings --}}
                    <div class="mt-6 flex justify-end border-t pt-4">
                        <div class="text-right">
                            <p class="text-sm text-gray-500">
                                Total Estimated Servings
                            </p>

                            <p
                                id="total-quantity"
                                class="text-2xl font-bold text-gray-900"
                            >
                                0
                            </p>
                        </div>
                    </div>

                </div>

                {{-- Buttons --}}
                <div class="flex items-center justify-end gap-3 border-t pt-6">

                    <a
                        href="{{ route('distributions.index') }}"
                        class="inline-flex items-center rounded-md bg-gray-200 px-5 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-300"
                    >
                        Cancel
                    </a>

                    <button
                        type="submit"
                        class="inline-flex items-center rounded-md px-5 py-2.5 text-sm font-semibold text-white"
                        style="background-color: #ea580c;"
                    >
                        Save Distribution
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
                    'bottle_capacity_ml' => (float) $baseDrink->bottle_capacity_ml,
                    'standard_serving_ml' => (float) $baseDrink->standard_serving_ml,
                ];
            })->values()
        );

        const baseDrinkList =
            document.getElementById('base-drink-list');

        const addBaseDrinkButton =
            document.getElementById('add-base-drink');

        const totalQuantityElement =
            document.getElementById('total-quantity');


        // Calculate total estimated servings
        function updateTotalQuantity() {

            let total = 0;

            document
                .querySelectorAll('.quantity-input')
                .forEach(input => {

                    total += parseFloat(input.value) || 0;

                });

            totalQuantityElement.textContent =
                new Intl.NumberFormat('id-ID').format(total);
        }


        // Prevent duplicate Base Drink selection
        function updateBaseDrinkOptions() {

            const selectedValues = Array.from(
                document.querySelectorAll('.base-drink-select')
            )
                .map(select => select.value)
                .filter(value => value !== '');

            document
                .querySelectorAll('.base-drink-select')
                .forEach(select => {

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


        // Create Base Drink row
        function createBaseDrinkRow() {

            const index =
                document.querySelectorAll('.base-drink-row').length;

            const row =
                document.createElement('div');

            row.className =
                'base-drink-row rounded-lg border border-gray-200 p-4';

            row.innerHTML = `
                <div class="grid grid-cols-1 gap-4 md:grid-cols-12 md:items-end">

                    {{-- Base Drink --}}
                    <div class="md:col-span-7">

                        <label class="block text-sm font-medium text-gray-700">
                            Base Drink
                        </label>

                        <select
                            name="base_drinks[${index}][base_drink_id]"
                            class="base-drink-select mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500"
                            required
                        >
                            <option value="">
                                Select Base Drink
                            </option>
                        </select>

                    </div>


                    {{-- Quantity --}}
                    <div class="md:col-span-3">

                        <label class="block text-sm font-medium text-gray-700">
                            Estimated Servings
                        </label>

                        <input
                            type="number"
                            name="base_drinks[${index}][quantity]"
                            value="1"
                            min="0.01"
                            step="0.01"
                            class="quantity-input mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500"
                            required
                        >

                    </div>


                    {{-- Remove --}}
                    <div class="md:col-span-2">

                        <button
                            type="button"
                            class="remove-base-drink w-full rounded-md bg-red-100 px-3 py-2 text-sm font-semibold text-red-700 hover:bg-red-200"
                        >
                            Remove
                        </button>

                    </div>

                </div>

                {{-- Base Drink Information --}}
                <div class="mt-3 text-xs text-gray-500 base-drink-info">
                    Select a base drink to see its serving information.
                </div>
            `;


            const select =
                row.querySelector('.base-drink-select');

            const quantityInput =
                row.querySelector('.quantity-input');

            const info =
                row.querySelector('.base-drink-info');

            const removeButton =
                row.querySelector('.remove-base-drink');


            // Populate Base Drink options
            baseDrinks.forEach(baseDrink => {

                const option =
                    document.createElement('option');

                option.value =
                    baseDrink.id;

                option.textContent =
                    baseDrink.name;

                select.appendChild(option);

            });


            // Update information
            function updateInfo() {

                const selected =
                    baseDrinks.find(
                        baseDrink =>
                            String(baseDrink.id) ===
                            String(select.value)
                    );

                if (!selected) {

                    info.textContent =
                        'Select a base drink to see its serving information.';

                    return;
                }

                info.textContent =
                    `Bottle capacity: ${selected.bottle_capacity_ml} ml | ` +
                    `Standard serving: ${selected.standard_serving_ml} ml`;

                updateBaseDrinkOptions();
            }


            select.addEventListener(
                'change',
                updateInfo
            );


            quantityInput.addEventListener(
                'input',
                updateTotalQuantity
            );


            removeButton.addEventListener(
                'click',
                () => {

                    row.remove();

                    updateTotalQuantity();
                    updateBaseDrinkOptions();

                }
            );


            baseDrinkList.appendChild(row);

            updateInfo();
            updateBaseDrinkOptions();
        }


        // Add Base Drink
        addBaseDrinkButton.addEventListener(
            'click',
            () => {
                createBaseDrinkRow();
            }
        );


        // Start with one row
        createBaseDrinkRow();

        updateTotalQuantity();
    </script>
</x-app-layout>
