<x-app-layout>

    <x-slot name="header">
        <div>
            <h2 class="text-xl font-bold text-stone-900">
                Add Distribution
            </h2>

            <p class="mt-1 text-sm text-stone-500">
                Record products and operational items distributed to an employee.
            </p>
        </div>
    </x-slot>


    <div class="py-6">

        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">


            {{-- ========================================================= --}}
            {{-- Validation Errors --}}
            {{-- ========================================================= --}}

            @if ($errors->any())

                <div
                    class="mb-6 rounded-xl border border-red-200
                           bg-red-50 px-4 py-3 text-sm text-red-700"
                >

                    <p class="font-semibold">
                        Please fix the following errors:
                    </p>

                    <ul class="mt-2 list-disc space-y-1 pl-5">

                        @foreach ($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif


            <form
                action="{{ route('distributions.store') }}"
                method="POST"
                id="distribution-form"
                class="space-y-6"
            >

                @csrf


                {{-- ========================================================= --}}
                {{-- Distribution Information --}}
                {{-- ========================================================= --}}

                <x-app-card>

                    <div class="mb-5">

                        <h3 class="text-base font-bold text-stone-900">
                            Distribution Information
                        </h3>

                        <p class="mt-1 text-sm text-stone-500">
                            Select the assignment and distribution date.
                        </p>

                    </div>


                    <div class="grid gap-5 sm:grid-cols-2">


                        {{-- Assignment --}}

                        <div>

                            <label
                                for="assignment_id"
                                class="mb-1.5 block text-sm font-semibold text-stone-700"
                            >
                                Assignment
                            </label>


                            <select
                                id="assignment_id"
                                name="assignment_id"
                                required
                                class="w-full rounded-lg border-stone-300
                                       text-sm shadow-sm
                                       focus:border-amber-500
                                       focus:ring-amber-500"
                            >

                                <option value="">
                                    Select assignment
                                </option>


                                @foreach ($assignments as $assignment)

                                    <option
                                        value="{{ $assignment->id }}"
                                        {{ old('assignment_id') == $assignment->id ? 'selected' : '' }}
                                    >

                                        {{ $assignment->employee->employee_code }}
                                        -
                                        {{ $assignment->employee->user->name }}

                                        |

                                        {{ $assignment->cart->name ?? '-' }}

                                        -

                                        {{ $assignment->region->name ?? '-' }}

                                    </option>

                                @endforeach

                            </select>


                            @error('assignment_id')

                                <p class="mt-1 text-xs text-red-600">
                                    {{ $message }}
                                </p>

                            @enderror


                            <p class="mt-1 text-xs text-stone-500">
                                Select the assignment carried out by the employee.
                            </p>

                        </div>


                        {{-- Distribution Date --}}

                        <div>

                            <label
                                for="distribution_date"
                                class="mb-1.5 block text-sm font-semibold text-stone-700"
                            >
                                Distribution Date
                            </label>


                            <input
                                type="date"
                                id="distribution_date"
                                name="distribution_date"
                                value="{{ old('distribution_date', now()->toDateString()) }}"
                                required
                                class="w-full rounded-lg border-stone-300
                                       text-sm shadow-sm
                                       focus:border-amber-500
                                       focus:ring-amber-500"
                            >


                            @error('distribution_date')

                                <p class="mt-1 text-xs text-red-600">
                                    {{ $message }}
                                </p>

                            @enderror

                        </div>

                    </div>


                    {{-- Notes --}}

                    <div class="mt-5">

                        <label
                            for="notes"
                            class="mb-1.5 block text-sm font-semibold text-stone-700"
                        >
                            Notes
                        </label>


                        <textarea
                            id="notes"
                            name="notes"
                            rows="3"
                            placeholder="Optional notes..."
                            class="w-full rounded-lg border-stone-300
                                   text-sm shadow-sm
                                   focus:border-amber-500
                                   focus:ring-amber-500"
                        >{{ old('notes') }}</textarea>


                        @error('notes')

                            <p class="mt-1 text-xs text-red-600">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>

                </x-app-card>



                {{-- ========================================================= --}}
                {{-- Base Drinks --}}
                {{-- ========================================================= --}}

                <x-app-card>


                    <div
                        class="flex flex-col gap-3
                               sm:flex-row sm:items-center
                               sm:justify-between"
                    >

                        <div>

                            <h3 class="text-base font-bold text-stone-900">
                                Base Drinks
                            </h3>

                            <p class="mt-1 text-sm text-stone-500">
                                Record the quantity of base drinks given to the employee.
                                This does not affect stock.
                            </p>

                        </div>


                        <button
                            type="button"
                            id="add-product"
                            class="rounded-lg bg-amber-700 px-3 py-2
                                   text-xs font-semibold text-white
                                   hover:bg-amber-800"
                        >
                            Add Base Drink
                        </button>

                    </div>



                    <div
                        id="products-container"
                        class="mt-5 space-y-3"
                    >

                        @if (old('products'))

                            @foreach (old('products') as $index => $product)

                                <div
                                    class="product-row rounded-lg
                                           border border-stone-200 p-4"
                                >

                                    <div
                                        class="grid gap-3
                                               sm:grid-cols-[1fr_150px_150px_auto]"
                                    >


                                        {{-- Base Drink --}}

                                        <div>

                                            <label
                                                class="mb-1 block text-xs
                                                       font-semibold text-stone-600"
                                            >
                                                Base Drink
                                            </label>


                                            <select
                                                name="products[{{ $index }}][base_drink_id]"
                                                required
                                                class="w-full rounded-lg
                                                       border-stone-300
                                                       text-sm shadow-sm
                                                       focus:border-amber-500
                                                       focus:ring-amber-500"
                                            >

                                                <option value="">
                                                    Select base drink
                                                </option>


                                                @foreach ($baseDrinks as $baseDrink)

                                                    <option
                                                        value="{{ $baseDrink->id }}"
                                                        {{ ($product['base_drink_id'] ?? '') == $baseDrink->id ? 'selected' : '' }}
                                                    >
                                                        {{ $baseDrink->name }}
                                                    </option>

                                                @endforeach

                                            </select>

                                        </div>



                                        {{-- Distributed --}}

                                        <div>

                                            <label
                                                class="mb-1 block text-xs
                                                       font-semibold text-stone-600"
                                            >
                                                Distributed
                                            </label>


                                            <input
                                                type="number"
                                                min="1"
                                                name="products[{{ $index }}][quantity_distributed]"
                                                value="{{ $product['quantity_distributed'] ?? '' }}"
                                                required
                                                class="w-full rounded-lg
                                                       border-stone-300
                                                       text-sm shadow-sm
                                                       focus:border-amber-500
                                                       focus:ring-amber-500"
                                            >

                                        </div>



                                        {{-- Returned --}}

                                        <div>

                                            <label
                                                class="mb-1 block text-xs
                                                       font-semibold text-stone-600"
                                            >
                                                Returned
                                            </label>


                                            <input
                                                type="number"
                                                min="0"
                                                name="products[{{ $index }}][quantity_returned]"
                                                value="{{ $product['quantity_returned'] ?? 0 }}"
                                                required
                                                class="w-full rounded-lg
                                                       border-stone-300
                                                       text-sm shadow-sm
                                                       focus:border-amber-500
                                                       focus:ring-amber-500"
                                            >

                                        </div>



                                        {{-- Remove --}}

                                        <div class="flex items-end">

                                            <button
                                                type="button"
                                                class="remove-product w-full
                                                       rounded-lg bg-red-50
                                                       px-3 py-2
                                                       text-xs font-semibold
                                                       text-red-600
                                                       hover:bg-red-100
                                                       sm:w-auto"
                                            >
                                                Remove
                                            </button>

                                        </div>

                                    </div>

                                </div>

                            @endforeach

                        @endif

                    </div>



                    {{-- Empty state --}}

                    <div
                        id="products-empty"
                        class="mt-5 rounded-lg border border-dashed
                               border-stone-300 px-4 py-6 text-center
                               {{ old('products') ? 'hidden' : '' }}"
                    >

                        <p class="text-sm font-medium text-stone-600">
                            No base drinks added.
                        </p>

                        <p class="mt-1 text-xs text-stone-500">
                            Click "Add Base Drink" to add an item.
                        </p>

                    </div>

                </x-app-card>



                {{-- ========================================================= --}}
                {{-- Operational Items --}}
                {{-- ========================================================= --}}

                <x-app-card>


                    <div
                        class="flex flex-col gap-3
                               sm:flex-row sm:items-center
                               sm:justify-between"
                    >

                        <div>

                            <h3 class="text-base font-bold text-stone-900">
                                Operational Items
                            </h3>

                            <p class="mt-1 text-sm text-stone-500">
                                Distributed quantities will be deducted from operational item stock.
                            </p>

                        </div>


                        <button
                            type="button"
                            id="add-operational-item"
                            class="rounded-lg bg-amber-700 px-3 py-2
                                   text-xs font-semibold text-white
                                   hover:bg-amber-800"
                        >
                            Add Operational Item
                        </button>

                    </div>



                    <div
                        id="operational-items-container"
                        class="mt-5 space-y-3"
                    >

                        @if (old('operational_items'))

                            @foreach (old('operational_items') as $index => $item)

                                @php

                                    $selectedItem =
                                        $operationalItems->firstWhere(
                                            'id',
                                            $item['operational_item_id'] ?? null
                                        );

                                @endphp


                                <div
                                    class="operational-item-row rounded-lg
                                           border border-stone-200 p-4"
                                >

                                    <div
                                        class="grid gap-3
                                               sm:grid-cols-[1fr_150px_150px_auto]"
                                    >


                                        {{-- Operational Item --}}

                                        <div>

                                            <label
                                                class="mb-1 block text-xs
                                                       font-semibold text-stone-600"
                                            >
                                                Operational Item
                                            </label>


                                            <select
                                                name="operational_items[{{ $index }}][operational_item_id]"
                                                required
                                                class="operational-item-select
                                                       w-full rounded-lg
                                                       border-stone-300
                                                       text-sm shadow-sm
                                                       focus:border-amber-500
                                                       focus:ring-amber-500"
                                            >

                                                <option value="">
                                                    Select item
                                                </option>


                                                @foreach ($operationalItems as $operationalItem)

                                                    <option
                                                        value="{{ $operationalItem->id }}"
                                                        data-stock="{{ $operationalItem->stock }}"
                                                        {{ ($item['operational_item_id'] ?? '') == $operationalItem->id ? 'selected' : '' }}
                                                    >

                                                        {{ $operationalItem->name }}

                                                        (Stock:
                                                        {{ $operationalItem->stock }}
                                                        {{ $operationalItem->unit }})

                                                    </option>

                                                @endforeach

                                            </select>


                                            <p
                                                class="operational-stock mt-1
                                                       text-xs text-stone-500"
                                            >

                                                @if ($selectedItem)

                                                    Available stock:
                                                    {{ $selectedItem->stock }}
                                                    {{ $selectedItem->unit }}

                                                @endif

                                            </p>

                                        </div>



                                        {{-- Distributed --}}

                                        <div>

                                            <label
                                                class="mb-1 block text-xs
                                                       font-semibold text-stone-600"
                                            >
                                                Distributed
                                            </label>


                                            <input
                                                type="number"
                                                min="1"
                                                name="operational_items[{{ $index }}][quantity_distributed]"
                                                value="{{ $item['quantity_distributed'] ?? '' }}"
                                                required
                                                class="operational-quantity
                                                       w-full rounded-lg
                                                       border-stone-300
                                                       text-sm shadow-sm
                                                       focus:border-amber-500
                                                       focus:ring-amber-500"
                                            >

                                        </div>



                                        {{-- Returned --}}

                                        <div>

                                            <label
                                                class="mb-1 block text-xs
                                                       font-semibold text-stone-600"
                                            >
                                                Returned
                                            </label>


                                            <input
                                                type="number"
                                                min="0"
                                                name="operational_items[{{ $index }}][quantity_returned]"
                                                value="{{ $item['quantity_returned'] ?? 0 }}"
                                                required
                                                class="w-full rounded-lg
                                                       border-stone-300
                                                       text-sm shadow-sm
                                                       focus:border-amber-500
                                                       focus:ring-amber-500"
                                            >

                                        </div>



                                        {{-- Remove --}}

                                        <div class="flex items-end">

                                            <button
                                                type="button"
                                                class="remove-operational-item
                                                       w-full rounded-lg
                                                       bg-red-50 px-3 py-2
                                                       text-xs font-semibold
                                                       text-red-600
                                                       hover:bg-red-100
                                                       sm:w-auto"
                                            >
                                                Remove
                                            </button>

                                        </div>

                                    </div>

                                </div>

                            @endforeach

                        @endif

                    </div>



                    {{-- Empty state --}}

                    <div
                        id="operational-items-empty"
                        class="mt-5 rounded-lg border border-dashed
                               border-stone-300 px-4 py-6 text-center
                               {{ old('operational_items') ? 'hidden' : '' }}"
                    >

                        <p class="text-sm font-medium text-stone-600">
                            No operational items added.
                        </p>

                        <p class="mt-1 text-xs text-stone-500">
                            Click "Add Operational Item" to add an item.
                        </p>

                    </div>

                </x-app-card>



                {{-- ========================================================= --}}
                {{-- Actions --}}
                {{-- ========================================================= --}}

                <div class="flex items-center justify-end gap-3">

                    <a
                        href="{{ route('distributions.index') }}"
                        class="rounded-lg bg-stone-100 px-4 py-2
                               text-sm font-semibold text-stone-700
                               hover:bg-stone-200"
                    >
                        Cancel
                    </a>


                    <button
                        type="submit"
                        class="rounded-lg bg-amber-700 px-5 py-2
                               text-sm font-semibold text-white
                               hover:bg-amber-800"
                    >
                        Save Distribution
                    </button>

                </div>

            </form>

        </div>

    </div>



    {{-- ========================================================= --}}
    {{-- JavaScript --}}
    {{-- ========================================================= --}}

    <script>

        let productIndex =
            {{ old('products') ? count(old('products')) : 0 }};


        let operationalItemIndex =
            {{ old('operational_items') ? count(old('operational_items')) : 0 }};



        /*
        |--------------------------------------------------------------------------
        | Base Drinks
        |--------------------------------------------------------------------------
        */

        const addProductButton =
            document.getElementById('add-product');

        const productsContainer =
            document.getElementById('products-container');

        const productsEmpty =
            document.getElementById('products-empty');


        addProductButton.addEventListener(
            'click',
            () => {

                const row =
                    document.createElement('div');


                row.className =
                    'product-row rounded-lg border border-stone-200 p-4';


                row.innerHTML = `

                    <div
                        class="grid gap-3
                               sm:grid-cols-[1fr_150px_150px_auto]"
                    >


                        <div>

                            <label
                                class="mb-1 block text-xs
                                       font-semibold text-stone-600"
                            >
                                Base Drink
                            </label>


                            <select
                                name="products[${productIndex}][base_drink_id]"
                                required
                                class="w-full rounded-lg
                                       border-stone-300
                                       text-sm shadow-sm
                                       focus:border-amber-500
                                       focus:ring-amber-500"
                            >

                                <option value="">
                                    Select base drink
                                </option>


                                @foreach ($baseDrinks as $baseDrink)

                                    <option value="{{ $baseDrink->id }}">
                                        {{ $baseDrink->name }}
                                    </option>

                                @endforeach

                            </select>

                        </div>



                        <div>

                            <label
                                class="mb-1 block text-xs
                                       font-semibold text-stone-600"
                            >
                                Distributed
                            </label>


                            <input
                                type="number"
                                min="1"
                                name="products[${productIndex}][quantity_distributed]"
                                required
                                class="w-full rounded-lg
                                       border-stone-300
                                       text-sm shadow-sm
                                       focus:border-amber-500
                                       focus:ring-amber-500"
                            >

                        </div>



                        <div>

                            <label
                                class="mb-1 block text-xs
                                       font-semibold text-stone-600"
                            >
                                Returned
                            </label>


                            <input
                                type="number"
                                min="0"
                                name="products[${productIndex}][quantity_returned]"
                                value="0"
                                required
                                class="w-full rounded-lg
                                       border-stone-300
                                       text-sm shadow-sm
                                       focus:border-amber-500
                                       focus:ring-amber-500"
                            >

                        </div>



                        <div class="flex items-end">

                            <button
                                type="button"
                                class="remove-product w-full
                                       rounded-lg bg-red-50
                                       px-3 py-2
                                       text-xs font-semibold
                                       text-red-600
                                       hover:bg-red-100
                                       sm:w-auto"
                            >
                                Remove
                            </button>

                        </div>

                    </div>
                `;


                productsContainer.appendChild(row);

                productIndex++;

                updateProductEmptyState();

            }
        );



        document.addEventListener(
            'click',
            (event) => {

                if (
                    event.target.classList.contains(
                        'remove-product'
                    )
                ) {

                    event.target
                        .closest('.product-row')
                        .remove();


                    updateProductEmptyState();

                }

            }
        );



        function updateProductEmptyState()
        {
            const hasRows =
                productsContainer.querySelector(
                    '.product-row'
                );


            productsEmpty.classList.toggle(
                'hidden',
                !!hasRows
            );
        }



        /*
        |--------------------------------------------------------------------------
        | Operational Items
        |--------------------------------------------------------------------------
        */

        const addOperationalItemButton =
            document.getElementById(
                'add-operational-item'
            );


        const operationalItemsContainer =
            document.getElementById(
                'operational-items-container'
            );


        const operationalItemsEmpty =
            document.getElementById(
                'operational-items-empty'
            );


        addOperationalItemButton.addEventListener(
            'click',
            () => {

                const row =
                    document.createElement('div');


                row.className =
                    'operational-item-row rounded-lg border border-stone-200 p-4';


                row.innerHTML = `

                    <div
                        class="grid gap-3
                               sm:grid-cols-[1fr_150px_150px_auto]"
                    >


                        <div>

                            <label
                                class="mb-1 block text-xs
                                       font-semibold text-stone-600"
                            >
                                Operational Item
                            </label>


                            <select
                                name="operational_items[${operationalItemIndex}][operational_item_id]"
                                required
                                class="operational-item-select
                                       w-full rounded-lg
                                       border-stone-300
                                       text-sm shadow-sm
                                       focus:border-amber-500
                                       focus:ring-amber-500"
                            >

                                <option value="">
                                    Select item
                                </option>


                                @foreach ($operationalItems as $operationalItem)

                                    <option
                                        value="{{ $operationalItem->id }}"
                                        data-stock="{{ $operationalItem->stock }}"
                                    >

                                        {{ $operationalItem->name }}

                                        (Stock:
                                        {{ $operationalItem->stock }}
                                        {{ $operationalItem->unit }})

                                    </option>

                                @endforeach

                            </select>


                            <p
                                class="operational-stock mt-1
                                       text-xs text-stone-500"
                            >
                            </p>

                        </div>



                        <div>

                            <label
                                class="mb-1 block text-xs
                                       font-semibold text-stone-600"
                            >
                                Distributed
                            </label>


                            <input
                                type="number"
                                min="1"
                                name="operational_items[${operationalItemIndex}][quantity_distributed]"
                                required
                                class="operational-quantity
                                       w-full rounded-lg
                                       border-stone-300
                                       text-sm shadow-sm
                                       focus:border-amber-500
                                       focus:ring-amber-500"
                            >

                        </div>



                        <div>

                            <label
                                class="mb-1 block text-xs
                                       font-semibold text-stone-600"
                            >
                                Returned
                            </label>


                            <input
                                type="number"
                                min="0"
                                name="operational_items[${operationalItemIndex}][quantity_returned]"
                                value="0"
                                required
                                class="w-full rounded-lg
                                       border-stone-300
                                       text-sm shadow-sm
                                       focus:border-amber-500
                                       focus:ring-amber-500"
                            >

                        </div>



                        <div class="flex items-end">

                            <button
                                type="button"
                                class="remove-operational-item
                                       w-full rounded-lg
                                       bg-red-50 px-3 py-2
                                       text-xs font-semibold
                                       text-red-600
                                       hover:bg-red-100
                                       sm:w-auto"
                            >
                                Remove
                            </button>

                        </div>

                    </div>

                `;


                operationalItemsContainer.appendChild(row);

                operationalItemIndex++;

                updateOperationalItemEmptyState();

            }
        );



        document.addEventListener(
            'click',
            (event) => {

                if (
                    event.target.classList.contains(
                        'remove-operational-item'
                    )
                ) {

                    event.target
                        .closest(
                            '.operational-item-row'
                        )
                        .remove();


                    updateOperationalItemEmptyState();

                }

            }
        );



        /*
        |--------------------------------------------------------------------------
        | Show Available Stock
        |--------------------------------------------------------------------------
        */

        document.addEventListener(
            'change',
            (event) => {

                if (
                    event.target.classList.contains(
                        'operational-item-select'
                    )
                ) {

                    const select =
                        event.target;


                    const row =
                        select.closest(
                            '.operational-item-row'
                        );


                    const stockDisplay =
                        row.querySelector(
                            '.operational-stock'
                        );


                    const selectedOption =
                        select.options[
                            select.selectedIndex
                        ];


                    if (
                        selectedOption &&
                        selectedOption.dataset.stock
                    ) {

                        stockDisplay.textContent =
                            `Available stock: ${selectedOption.dataset.stock}`;

                    } else {

                        stockDisplay.textContent =
                            '';

                    }

                }

            }
        );



        function updateOperationalItemEmptyState()
        {
            const hasRows =
                operationalItemsContainer.querySelector(
                    '.operational-item-row'
                );


            operationalItemsEmpty.classList.toggle(
                'hidden',
                !!hasRows
            );
        }

    </script>

</x-app-layout><x-app-layout>

    <x-slot name="header">
        <div>
            <h2 class="text-xl font-bold text-stone-900">
                Add Distribution
            </h2>

            <p class="mt-1 text-sm text-stone-500">
                Record products and operational items distributed to an employee.
            </p>
        </div>
    </x-slot>


    <div class="py-6">

        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">


            {{-- ========================================================= --}}
            {{-- Validation Errors --}}
            {{-- ========================================================= --}}

            @if ($errors->any())

                <div
                    class="mb-6 rounded-xl border border-red-200
                           bg-red-50 px-4 py-3 text-sm text-red-700"
                >

                    <p class="font-semibold">
                        Please fix the following errors:
                    </p>

                    <ul class="mt-2 list-disc space-y-1 pl-5">

                        @foreach ($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif


            <form
                action="{{ route('distributions.store') }}"
                method="POST"
                id="distribution-form"
                class="space-y-6"
            >

                @csrf


                {{-- ========================================================= --}}
                {{-- Distribution Information --}}
                {{-- ========================================================= --}}

                <x-app-card>

                    <div class="mb-5">

                        <h3 class="text-base font-bold text-stone-900">
                            Distribution Information
                        </h3>

                        <p class="mt-1 text-sm text-stone-500">
                            Select the assignment and distribution date.
                        </p>

                    </div>


                    <div class="grid gap-5 sm:grid-cols-2">


                        {{-- Assignment --}}

                        <div>

                            <label
                                for="assignment_id"
                                class="mb-1.5 block text-sm font-semibold text-stone-700"
                            >
                                Assignment
                            </label>


                            <select
                                id="assignment_id"
                                name="assignment_id"
                                required
                                class="w-full rounded-lg border-stone-300
                                       text-sm shadow-sm
                                       focus:border-amber-500
                                       focus:ring-amber-500"
                            >

                                <option value="">
                                    Select assignment
                                </option>


                                @foreach ($assignments as $assignment)

                                    <option
                                        value="{{ $assignment->id }}"
                                        {{ old('assignment_id') == $assignment->id ? 'selected' : '' }}
                                    >

                                        {{ $assignment->employee->employee_code }}
                                        -
                                        {{ $assignment->employee->user->name }}

                                        |

                                        {{ $assignment->cart->name ?? '-' }}

                                        -

                                        {{ $assignment->region->name ?? '-' }}

                                    </option>

                                @endforeach

                            </select>


                            @error('assignment_id')

                                <p class="mt-1 text-xs text-red-600">
                                    {{ $message }}
                                </p>

                            @enderror


                            <p class="mt-1 text-xs text-stone-500">
                                Select the assignment carried out by the employee.
                            </p>

                        </div>


                        {{-- Distribution Date --}}

                        <div>

                            <label
                                for="distribution_date"
                                class="mb-1.5 block text-sm font-semibold text-stone-700"
                            >
                                Distribution Date
                            </label>


                            <input
                                type="date"
                                id="distribution_date"
                                name="distribution_date"
                                value="{{ old('distribution_date', now()->toDateString()) }}"
                                required
                                class="w-full rounded-lg border-stone-300
                                       text-sm shadow-sm
                                       focus:border-amber-500
                                       focus:ring-amber-500"
                            >


                            @error('distribution_date')

                                <p class="mt-1 text-xs text-red-600">
                                    {{ $message }}
                                </p>

                            @enderror

                        </div>

                    </div>


                    {{-- Notes --}}

                    <div class="mt-5">

                        <label
                            for="notes"
                            class="mb-1.5 block text-sm font-semibold text-stone-700"
                        >
                            Notes
                        </label>


                        <textarea
                            id="notes"
                            name="notes"
                            rows="3"
                            placeholder="Optional notes..."
                            class="w-full rounded-lg border-stone-300
                                   text-sm shadow-sm
                                   focus:border-amber-500
                                   focus:ring-amber-500"
                        >{{ old('notes') }}</textarea>


                        @error('notes')

                            <p class="mt-1 text-xs text-red-600">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>

                </x-app-card>



                {{-- ========================================================= --}}
                {{-- Base Drinks --}}
                {{-- ========================================================= --}}

                <x-app-card>


                    <div
                        class="flex flex-col gap-3
                               sm:flex-row sm:items-center
                               sm:justify-between"
                    >

                        <div>

                            <h3 class="text-base font-bold text-stone-900">
                                Base Drinks
                            </h3>

                            <p class="mt-1 text-sm text-stone-500">
                                Record the quantity of base drinks given to the employee.
                                This does not affect stock.
                            </p>

                        </div>


                        <button
                            type="button"
                            id="add-product"
                            class="rounded-lg bg-amber-700 px-3 py-2
                                   text-xs font-semibold text-white
                                   hover:bg-amber-800"
                        >
                            Add Base Drink
                        </button>

                    </div>



                    <div
                        id="products-container"
                        class="mt-5 space-y-3"
                    >

                        @if (old('products'))

                            @foreach (old('products') as $index => $product)

                                <div
                                    class="product-row rounded-lg
                                           border border-stone-200 p-4"
                                >

                                    <div
                                        class="grid gap-3
                                               sm:grid-cols-[1fr_150px_150px_auto]"
                                    >


                                        {{-- Base Drink --}}

                                        <div>

                                            <label
                                                class="mb-1 block text-xs
                                                       font-semibold text-stone-600"
                                            >
                                                Base Drink
                                            </label>


                                            <select
                                                name="products[{{ $index }}][base_drink_id]"
                                                required
                                                class="w-full rounded-lg
                                                       border-stone-300
                                                       text-sm shadow-sm
                                                       focus:border-amber-500
                                                       focus:ring-amber-500"
                                            >

                                                <option value="">
                                                    Select base drink
                                                </option>


                                                @foreach ($baseDrinks as $baseDrink)

                                                    <option
                                                        value="{{ $baseDrink->id }}"
                                                        {{ ($product['base_drink_id'] ?? '') == $baseDrink->id ? 'selected' : '' }}
                                                    >
                                                        {{ $baseDrink->name }}
                                                    </option>

                                                @endforeach

                                            </select>

                                        </div>



                                        {{-- Distributed --}}

                                        <div>

                                            <label
                                                class="mb-1 block text-xs
                                                       font-semibold text-stone-600"
                                            >
                                                Distributed
                                            </label>


                                            <input
                                                type="number"
                                                min="1"
                                                name="products[{{ $index }}][quantity_distributed]"
                                                value="{{ $product['quantity_distributed'] ?? '' }}"
                                                required
                                                class="w-full rounded-lg
                                                       border-stone-300
                                                       text-sm shadow-sm
                                                       focus:border-amber-500
                                                       focus:ring-amber-500"
                                            >

                                        </div>



                                        {{-- Returned --}}

                                        <div>

                                            <label
                                                class="mb-1 block text-xs
                                                       font-semibold text-stone-600"
                                            >
                                                Returned
                                            </label>


                                            <input
                                                type="number"
                                                min="0"
                                                name="products[{{ $index }}][quantity_returned]"
                                                value="{{ $product['quantity_returned'] ?? 0 }}"
                                                required
                                                class="w-full rounded-lg
                                                       border-stone-300
                                                       text-sm shadow-sm
                                                       focus:border-amber-500
                                                       focus:ring-amber-500"
                                            >

                                        </div>



                                        {{-- Remove --}}

                                        <div class="flex items-end">

                                            <button
                                                type="button"
                                                class="remove-product w-full
                                                       rounded-lg bg-red-50
                                                       px-3 py-2
                                                       text-xs font-semibold
                                                       text-red-600
                                                       hover:bg-red-100
                                                       sm:w-auto"
                                            >
                                                Remove
                                            </button>

                                        </div>

                                    </div>

                                </div>

                            @endforeach

                        @endif

                    </div>



                    {{-- Empty state --}}

                    <div
                        id="products-empty"
                        class="mt-5 rounded-lg border border-dashed
                               border-stone-300 px-4 py-6 text-center
                               {{ old('products') ? 'hidden' : '' }}"
                    >

                        <p class="text-sm font-medium text-stone-600">
                            No base drinks added.
                        </p>

                        <p class="mt-1 text-xs text-stone-500">
                            Click "Add Base Drink" to add an item.
                        </p>

                    </div>

                </x-app-card>



                {{-- ========================================================= --}}
                {{-- Operational Items --}}
                {{-- ========================================================= --}}

                <x-app-card>


                    <div
                        class="flex flex-col gap-3
                               sm:flex-row sm:items-center
                               sm:justify-between"
                    >

                        <div>

                            <h3 class="text-base font-bold text-stone-900">
                                Operational Items
                            </h3>

                            <p class="mt-1 text-sm text-stone-500">
                                Distributed quantities will be deducted from operational item stock.
                            </p>

                        </div>


                        <button
                            type="button"
                            id="add-operational-item"
                            class="rounded-lg bg-amber-700 px-3 py-2
                                   text-xs font-semibold text-white
                                   hover:bg-amber-800"
                        >
                            Add Operational Item
                        </button>

                    </div>



                    <div
                        id="operational-items-container"
                        class="mt-5 space-y-3"
                    >

                        @if (old('operational_items'))

                            @foreach (old('operational_items') as $index => $item)

                                @php

                                    $selectedItem =
                                        $operationalItems->firstWhere(
                                            'id',
                                            $item['operational_item_id'] ?? null
                                        );

                                @endphp


                                <div
                                    class="operational-item-row rounded-lg
                                           border border-stone-200 p-4"
                                >

                                    <div
                                        class="grid gap-3
                                               sm:grid-cols-[1fr_150px_150px_auto]"
                                    >


                                        {{-- Operational Item --}}

                                        <div>

                                            <label
                                                class="mb-1 block text-xs
                                                       font-semibold text-stone-600"
                                            >
                                                Operational Item
                                            </label>


                                            <select
                                                name="operational_items[{{ $index }}][operational_item_id]"
                                                required
                                                class="operational-item-select
                                                       w-full rounded-lg
                                                       border-stone-300
                                                       text-sm shadow-sm
                                                       focus:border-amber-500
                                                       focus:ring-amber-500"
                                            >

                                                <option value="">
                                                    Select item
                                                </option>


                                                @foreach ($operationalItems as $operationalItem)

                                                    <option
                                                        value="{{ $operationalItem->id }}"
                                                        data-stock="{{ $operationalItem->stock }}"
                                                        {{ ($item['operational_item_id'] ?? '') == $operationalItem->id ? 'selected' : '' }}
                                                    >

                                                        {{ $operationalItem->name }}

                                                        (Stock:
                                                        {{ $operationalItem->stock }}
                                                        {{ $operationalItem->unit }})

                                                    </option>

                                                @endforeach

                                            </select>


                                            <p
                                                class="operational-stock mt-1
                                                       text-xs text-stone-500"
                                            >

                                                @if ($selectedItem)

                                                    Available stock:
                                                    {{ $selectedItem->stock }}
                                                    {{ $selectedItem->unit }}

                                                @endif

                                            </p>

                                        </div>



                                        {{-- Distributed --}}

                                        <div>

                                            <label
                                                class="mb-1 block text-xs
                                                       font-semibold text-stone-600"
                                            >
                                                Distributed
                                            </label>


                                            <input
                                                type="number"
                                                min="1"
                                                name="operational_items[{{ $index }}][quantity_distributed]"
                                                value="{{ $item['quantity_distributed'] ?? '' }}"
                                                required
                                                class="operational-quantity
                                                       w-full rounded-lg
                                                       border-stone-300
                                                       text-sm shadow-sm
                                                       focus:border-amber-500
                                                       focus:ring-amber-500"
                                            >

                                        </div>



                                        {{-- Returned --}}

                                        <div>

                                            <label
                                                class="mb-1 block text-xs
                                                       font-semibold text-stone-600"
                                            >
                                                Returned
                                            </label>


                                            <input
                                                type="number"
                                                min="0"
                                                name="operational_items[{{ $index }}][quantity_returned]"
                                                value="{{ $item['quantity_returned'] ?? 0 }}"
                                                required
                                                class="w-full rounded-lg
                                                       border-stone-300
                                                       text-sm shadow-sm
                                                       focus:border-amber-500
                                                       focus:ring-amber-500"
                                            >

                                        </div>



                                        {{-- Remove --}}

                                        <div class="flex items-end">

                                            <button
                                                type="button"
                                                class="remove-operational-item
                                                       w-full rounded-lg
                                                       bg-red-50 px-3 py-2
                                                       text-xs font-semibold
                                                       text-red-600
                                                       hover:bg-red-100
                                                       sm:w-auto"
                                            >
                                                Remove
                                            </button>

                                        </div>

                                    </div>

                                </div>

                            @endforeach

                        @endif

                    </div>



                    {{-- Empty state --}}

                    <div
                        id="operational-items-empty"
                        class="mt-5 rounded-lg border border-dashed
                               border-stone-300 px-4 py-6 text-center
                               {{ old('operational_items') ? 'hidden' : '' }}"
                    >

                        <p class="text-sm font-medium text-stone-600">
                            No operational items added.
                        </p>

                        <p class="mt-1 text-xs text-stone-500">
                            Click "Add Operational Item" to add an item.
                        </p>

                    </div>

                </x-app-card>



                {{-- ========================================================= --}}
                {{-- Actions --}}
                {{-- ========================================================= --}}

                <div class="flex items-center justify-end gap-3">

                    <a
                        href="{{ route('distributions.index') }}"
                        class="rounded-lg bg-stone-100 px-4 py-2
                               text-sm font-semibold text-stone-700
                               hover:bg-stone-200"
                    >
                        Cancel
                    </a>


                    <button
                        type="submit"
                        class="rounded-lg bg-amber-700 px-5 py-2
                               text-sm font-semibold text-white
                               hover:bg-amber-800"
                    >
                        Save Distribution
                    </button>

                </div>

            </form>

        </div>

    </div>



    {{-- ========================================================= --}}
    {{-- JavaScript --}}
    {{-- ========================================================= --}}

    <script>

        let productIndex =
            {{ old('products') ? count(old('products')) : 0 }};


        let operationalItemIndex =
            {{ old('operational_items') ? count(old('operational_items')) : 0 }};



        /*
        |--------------------------------------------------------------------------
        | Base Drinks
        |--------------------------------------------------------------------------
        */

        const addProductButton =
            document.getElementById('add-product');

        const productsContainer =
            document.getElementById('products-container');

        const productsEmpty =
            document.getElementById('products-empty');


        addProductButton.addEventListener(
            'click',
            () => {

                const row =
                    document.createElement('div');


                row.className =
                    'product-row rounded-lg border border-stone-200 p-4';


                row.innerHTML = `

                    <div
                        class="grid gap-3
                               sm:grid-cols-[1fr_150px_150px_auto]"
                    >


                        <div>

                            <label
                                class="mb-1 block text-xs
                                       font-semibold text-stone-600"
                            >
                                Base Drink
                            </label>


                            <select
                                name="products[${productIndex}][base_drink_id]"
                                required
                                class="w-full rounded-lg
                                       border-stone-300
                                       text-sm shadow-sm
                                       focus:border-amber-500
                                       focus:ring-amber-500"
                            >

                                <option value="">
                                    Select base drink
                                </option>


                                @foreach ($baseDrinks as $baseDrink)

                                    <option value="{{ $baseDrink->id }}">
                                        {{ $baseDrink->name }}
                                    </option>

                                @endforeach

                            </select>

                        </div>



                        <div>

                            <label
                                class="mb-1 block text-xs
                                       font-semibold text-stone-600"
                            >
                                Distributed
                            </label>


                            <input
                                type="number"
                                min="1"
                                name="products[${productIndex}][quantity_distributed]"
                                required
                                class="w-full rounded-lg
                                       border-stone-300
                                       text-sm shadow-sm
                                       focus:border-amber-500
                                       focus:ring-amber-500"
                            >

                        </div>



                        <div>

                            <label
                                class="mb-1 block text-xs
                                       font-semibold text-stone-600"
                            >
                                Returned
                            </label>


                            <input
                                type="number"
                                min="0"
                                name="products[${productIndex}][quantity_returned]"
                                value="0"
                                required
                                class="w-full rounded-lg
                                       border-stone-300
                                       text-sm shadow-sm
                                       focus:border-amber-500
                                       focus:ring-amber-500"
                            >

                        </div>



                        <div class="flex items-end">

                            <button
                                type="button"
                                class="remove-product w-full
                                       rounded-lg bg-red-50
                                       px-3 py-2
                                       text-xs font-semibold
                                       text-red-600
                                       hover:bg-red-100
                                       sm:w-auto"
                            >
                                Remove
                            </button>

                        </div>

                    </div>
                `;


                productsContainer.appendChild(row);

                productIndex++;

                updateProductEmptyState();

            }
        );



        document.addEventListener(
            'click',
            (event) => {

                if (
                    event.target.classList.contains(
                        'remove-product'
                    )
                ) {

                    event.target
                        .closest('.product-row')
                        .remove();


                    updateProductEmptyState();

                }

            }
        );



        function updateProductEmptyState()
        {
            const hasRows =
                productsContainer.querySelector(
                    '.product-row'
                );


            productsEmpty.classList.toggle(
                'hidden',
                !!hasRows
            );
        }



        /*
        |--------------------------------------------------------------------------
        | Operational Items
        |--------------------------------------------------------------------------
        */

        const addOperationalItemButton =
            document.getElementById(
                'add-operational-item'
            );


        const operationalItemsContainer =
            document.getElementById(
                'operational-items-container'
            );


        const operationalItemsEmpty =
            document.getElementById(
                'operational-items-empty'
            );


        addOperationalItemButton.addEventListener(
            'click',
            () => {

                const row =
                    document.createElement('div');


                row.className =
                    'operational-item-row rounded-lg border border-stone-200 p-4';


                row.innerHTML = `

                    <div
                        class="grid gap-3
                               sm:grid-cols-[1fr_150px_150px_auto]"
                    >


                        <div>

                            <label
                                class="mb-1 block text-xs
                                       font-semibold text-stone-600"
                            >
                                Operational Item
                            </label>


                            <select
                                name="operational_items[${operationalItemIndex}][operational_item_id]"
                                required
                                class="operational-item-select
                                       w-full rounded-lg
                                       border-stone-300
                                       text-sm shadow-sm
                                       focus:border-amber-500
                                       focus:ring-amber-500"
                            >

                                <option value="">
                                    Select item
                                </option>


                                @foreach ($operationalItems as $operationalItem)

                                    <option
                                        value="{{ $operationalItem->id }}"
                                        data-stock="{{ $operationalItem->stock }}"
                                    >

                                        {{ $operationalItem->name }}

                                        (Stock:
                                        {{ $operationalItem->stock }}
                                        {{ $operationalItem->unit }})

                                    </option>

                                @endforeach

                            </select>


                            <p
                                class="operational-stock mt-1
                                       text-xs text-stone-500"
                            >
                            </p>

                        </div>



                        <div>

                            <label
                                class="mb-1 block text-xs
                                       font-semibold text-stone-600"
                            >
                                Distributed
                            </label>


                            <input
                                type="number"
                                min="1"
                                name="operational_items[${operationalItemIndex}][quantity_distributed]"
                                required
                                class="operational-quantity
                                       w-full rounded-lg
                                       border-stone-300
                                       text-sm shadow-sm
                                       focus:border-amber-500
                                       focus:ring-amber-500"
                            >

                        </div>



                        <div>

                            <label
                                class="mb-1 block text-xs
                                       font-semibold text-stone-600"
                            >
                                Returned
                            </label>


                            <input
                                type="number"
                                min="0"
                                name="operational_items[${operationalItemIndex}][quantity_returned]"
                                value="0"
                                required
                                class="w-full rounded-lg
                                       border-stone-300
                                       text-sm shadow-sm
                                       focus:border-amber-500
                                       focus:ring-amber-500"
                            >

                        </div>



                        <div class="flex items-end">

                            <button
                                type="button"
                                class="remove-operational-item
                                       w-full rounded-lg
                                       bg-red-50 px-3 py-2
                                       text-xs font-semibold
                                       text-red-600
                                       hover:bg-red-100
                                       sm:w-auto"
                            >
                                Remove
                            </button>

                        </div>

                    </div>

                `;


                operationalItemsContainer.appendChild(row);

                operationalItemIndex++;

                updateOperationalItemEmptyState();

            }
        );



        document.addEventListener(
            'click',
            (event) => {

                if (
                    event.target.classList.contains(
                        'remove-operational-item'
                    )
                ) {

                    event.target
                        .closest(
                            '.operational-item-row'
                        )
                        .remove();


                    updateOperationalItemEmptyState();

                }

            }
        );



        /*
        |--------------------------------------------------------------------------
        | Show Available Stock
        |--------------------------------------------------------------------------
        */

        document.addEventListener(
            'change',
            (event) => {

                if (
                    event.target.classList.contains(
                        'operational-item-select'
                    )
                ) {

                    const select =
                        event.target;


                    const row =
                        select.closest(
                            '.operational-item-row'
                        );


                    const stockDisplay =
                        row.querySelector(
                            '.operational-stock'
                        );


                    const selectedOption =
                        select.options[
                            select.selectedIndex
                        ];


                    if (
                        selectedOption &&
                        selectedOption.dataset.stock
                    ) {

                        stockDisplay.textContent =
                            `Available stock: ${selectedOption.dataset.stock}`;

                    } else {

                        stockDisplay.textContent =
                            '';

                    }

                }

            }
        );



        function updateOperationalItemEmptyState()
        {
            const hasRows =
                operationalItemsContainer.querySelector(
                    '.operational-item-row'
                );


            operationalItemsEmpty.classList.toggle(
                'hidden',
                !!hasRows
            );
        }

    </script>

</x-app-layout>
