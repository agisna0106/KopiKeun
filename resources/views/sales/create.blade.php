<x-app-layout>

    <x-slot name="header">
        <div>
            <h2 class="text-xl font-bold text-stone-900">
                Add Sale
            </h2>

            <p class="mt-1 text-sm text-stone-500">
                Record product sales from an employee distribution or outlet.
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
                action="{{ route('sales.store') }}"
                method="POST"
                id="sale-form"
                class="space-y-6"
            >

                @csrf


                {{-- ========================================================= --}}
                {{-- Sale Information --}}
                {{-- ========================================================= --}}

                <x-app-card>

                    <div class="mb-5">

                        <h3 class="text-base font-bold text-stone-900">
                            Sale Information
                        </h3>

                        <p class="mt-1 text-sm text-stone-500">
                            Select whether this sale comes from an employee
                            distribution or an outlet.
                        </p>

                    </div>


                    <div class="grid gap-5 sm:grid-cols-2">


                        {{-- Sale Source --}}
                        <div>

                            <label
                                for="sale_source"
                                class="mb-1.5 block text-sm font-semibold text-stone-700"
                            >
                                Sale Source
                            </label>

                            <select
                                id="sale_source"
                                name="sale_source"
                                required
                                class="w-full rounded-lg border-stone-300
                                       text-sm shadow-sm
                                       focus:border-amber-500
                                       focus:ring-amber-500"
                            >

                                <option value="">
                                    Select source
                                </option>

                                <option
                                    value="Employee"
                                    {{ old('sale_source') === 'Employee' ? 'selected' : '' }}
                                >
                                    Employee
                                </option>

                                <option
                                    value="Outlet"
                                    {{ old('sale_source') === 'Outlet' ? 'selected' : '' }}
                                >
                                    Outlet
                                </option>

                            </select>

                            @error('sale_source')

                                <p class="mt-1 text-xs text-red-600">
                                    {{ $message }}
                                </p>

                            @enderror

                        </div>


                        {{-- Sale Date --}}
                        <div id="sale-date-wrapper">

                            <label
                                for="sale_date"
                                class="mb-1.5 block text-sm font-semibold text-stone-700"
                            >
                                Sale Date
                            </label>

                            <input
                                type="date"
                                id="sale_date"
                                name="sale_date"
                                value="{{ old('sale_date', now()->toDateString()) }}"
                                class="w-full rounded-lg border-stone-300
                                       text-sm shadow-sm
                                       focus:border-amber-500
                                       focus:ring-amber-500"
                            >

                            <p
                                id="employee-date-info"
                                class="mt-1 hidden text-xs text-stone-500"
                            >
                                For employee sales, the date is taken
                                automatically from the selected distribution.
                            </p>

                            @error('sale_date')

                                <p class="mt-1 text-xs text-red-600">
                                    {{ $message }}
                                </p>

                            @enderror

                        </div>

                    </div>


                    {{-- ========================================================= --}}
                    {{-- Distribution --}}
                    {{-- ========================================================= --}}

                    <div
                        id="distribution-wrapper"
                        class="mt-5 hidden"
                    >

                        <label
                            for="distribution_id"
                            class="mb-1.5 block text-sm font-semibold text-stone-700"
                        >
                            Distribution
                        </label>


                        <select
                            id="distribution_id"
                            name="distribution_id"
                            class="w-full rounded-lg border-stone-300
                                   text-sm shadow-sm
                                   focus:border-amber-500
                                   focus:ring-amber-500"
                        >

                            <option value="">
                                Select distribution
                            </option>


                            @foreach ($distributions as $distribution)

                                <option
                                    value="{{ $distribution->id }}"
                                    data-date="{{ $distribution->distribution_date->format('Y-m-d') }}"
                                    {{ old('distribution_id') == $distribution->id ? 'selected' : '' }}
                                >

                                    {{ $distribution->distribution_date->format('d M Y') }}

                                    -

                                    {{ $distribution->assignment?->employee?->employee_code ?? '-' }}

                                    -

                                    {{ $distribution->assignment?->employee?->user?->name ?? '-' }}

                                    |

                                    {{ $distribution->assignment?->cart?->name ?? '-' }}

                                    -

                                    {{ $distribution->assignment?->region?->name ?? '-' }}

                                </option>

                            @endforeach

                        </select>


                        @error('distribution_id')

                            <p class="mt-1 text-xs text-red-600">
                                {{ $message }}
                            </p>

                        @enderror


                        <p class="mt-1 text-xs text-stone-500">
                            The employee and sale date will be taken
                            automatically from this distribution.
                        </p>

                    </div>


                    {{-- ========================================================= --}}
                    {{-- Employee Preview --}}
                    {{-- ========================================================= --}}

                    <div
                        id="employee-preview"
                        class="mt-4 hidden rounded-lg bg-stone-50
                               px-4 py-3 text-sm text-stone-600"
                    >

                        <p>
                            <span class="font-semibold text-stone-700">
                                Employee:
                            </span>

                            <span id="employee-name">
                                -
                            </span>
                        </p>

                    </div>


                    {{-- ========================================================= --}}
                    {{-- Notes --}}
                    {{-- ========================================================= --}}

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
                {{-- Products --}}
                {{-- ========================================================= --}}

                <x-app-card>

                    <div
                        class="flex flex-col gap-3
                               sm:flex-row sm:items-center
                               sm:justify-between"
                    >

                        <div>

                            <h3 class="text-base font-bold text-stone-900">
                                Products
                            </h3>

                            <p class="mt-1 text-sm text-stone-500">
                                Record the products sold and their quantities.
                            </p>

                        </div>


                        <button
                            type="button"
                            id="add-product"
                            class="rounded-lg bg-amber-700 px-3 py-2
                                   text-xs font-semibold text-white
                                   hover:bg-amber-800"
                        >
                            Add Product
                        </button>

                    </div>


                    <div
                        id="products-container"
                        class="mt-5 space-y-3"
                    >

                        @if (old('products'))

                            @foreach (old('products') as $index => $item)

                                <div
                                    class="product-row rounded-lg
                                           border border-stone-200 p-4"
                                >

                                    <div
                                        class="grid gap-3
                                               sm:grid-cols-[1fr_180px_auto]"
                                    >


                                        {{-- Product --}}
                                        <div>

                                            <label
                                                class="mb-1 block text-xs
                                                       font-semibold text-stone-600"
                                            >
                                                Product
                                            </label>


                                            <select
                                                name="products[{{ $index }}][product_id]"
                                                required
                                                class="w-full rounded-lg
                                                       border-stone-300
                                                       text-sm shadow-sm
                                                       focus:border-amber-500
                                                       focus:ring-amber-500"
                                            >

                                                <option value="">
                                                    Select product
                                                </option>


                                                @foreach ($products as $product)

                                                    <option
                                                        value="{{ $product->id }}"
                                                        {{ ($item['product_id'] ?? '') == $product->id ? 'selected' : '' }}
                                                    >
                                                        {{ $product->name }}
                                                        -
                                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                                    </option>

                                                @endforeach

                                            </select>

                                        </div>


                                        {{-- Quantity --}}
                                        <div>

                                            <label
                                                class="mb-1 block text-xs
                                                       font-semibold text-stone-600"
                                            >
                                                Quantity
                                            </label>


                                            <input
                                                type="number"
                                                step="0.01"
                                                min="0.01"
                                                name="products[{{ $index }}][quantity]"
                                                value="{{ $item['quantity'] ?? '' }}"
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


                    {{-- Empty --}}
                    <div
                        id="products-empty"
                        class="mt-5 rounded-lg border border-dashed
                               border-stone-300 px-4 py-6 text-center
                               {{ old('products') ? 'hidden' : '' }}"
                    >

                        <p class="text-sm font-medium text-stone-600">
                            No products added.
                        </p>

                        <p class="mt-1 text-xs text-stone-500">
                            Click "Add Product" to add a product.
                        </p>

                    </div>

                </x-app-card>



                {{-- ========================================================= --}}
                {{-- Actions --}}
                {{-- ========================================================= --}}

                <div class="flex items-center justify-end gap-3">

                    <a
                        href="{{ route('sales.index') }}"
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
                        Save Sale
                    </button>

                </div>

            </form>

        </div>

    </div>



    {{-- ============================================================= --}}
    {{-- JavaScript --}}
    {{-- ============================================================= --}}

    <script>

        /*
        |--------------------------------------------------------------------------
        | Elements
        |--------------------------------------------------------------------------
        */

        const saleSource =
            document.getElementById('sale_source');

        const distributionWrapper =
            document.getElementById('distribution-wrapper');

        const distributionSelect =
            document.getElementById('distribution_id');

        const saleDate =
            document.getElementById('sale_date');

        const saleDateWrapper =
            document.getElementById('sale-date-wrapper');

        const employeeDateInfo =
            document.getElementById('employee-date-info');

        const employeePreview =
            document.getElementById('employee-preview');

        const employeeName =
            document.getElementById('employee-name');


        /*
        |--------------------------------------------------------------------------
        | Distribution Employee Data
        |--------------------------------------------------------------------------
        |
        | Data employee diambil dari option distribution.
        |
        */

        const distributionData = {

            @foreach ($distributions as $distribution)

                "{{ $distribution->id }}": {
                    date: "{{ $distribution->distribution_date->format('Y-m-d') }}",
                    employee: @json(
                        $distribution->assignment?->employee?->user?->name ?? '-'
                    )
                },

            @endforeach

        };


        /*
        |--------------------------------------------------------------------------
        | Sale Source Change
        |--------------------------------------------------------------------------
        */

        function updateSaleSource()
        {
            const source =
                saleSource.value;


            /*
            |--------------------------------------------------------------------------
            | Employee
            |--------------------------------------------------------------------------
            */

            if (source === 'Employee') {

                distributionWrapper.classList.remove(
                    'hidden'
                );

                distributionSelect.required =
                    true;


                saleDate.readOnly =
                    true;

                saleDate.classList.add(
                    'bg-stone-100'
                );

                employeeDateInfo.classList.remove(
                    'hidden'
                );


                updateDistribution();

            }


            /*
            |--------------------------------------------------------------------------
            | Outlet
            |--------------------------------------------------------------------------
            */

            else if (source === 'Outlet') {

                distributionWrapper.classList.add(
                    'hidden'
                );

                distributionSelect.required =
                    false;

                distributionSelect.value =
                    '';


                saleDate.readOnly =
                    false;

                saleDate.classList.remove(
                    'bg-stone-100'
                );

                employeeDateInfo.classList.add(
                    'hidden'
                );


                employeePreview.classList.add(
                    'hidden'
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Nothing Selected
            |--------------------------------------------------------------------------
            */

            else {

                distributionWrapper.classList.add(
                    'hidden'
                );

                distributionSelect.required =
                    false;

                saleDate.readOnly =
                    false;

                saleDate.classList.remove(
                    'bg-stone-100'
                );

                employeeDateInfo.classList.add(
                    'hidden'
                );

                employeePreview.classList.add(
                    'hidden'
                );

            }
        }


        /*
        |--------------------------------------------------------------------------
        | Distribution Change
        |--------------------------------------------------------------------------
        */

        function updateDistribution()
        {
            const distributionId =
                distributionSelect.value;


            if (!distributionId) {

                employeePreview.classList.add(
                    'hidden'
                );

                saleDate.value =
                    '';

                return;
            }


            const data =
                distributionData[
                    distributionId
                ];


            if (!data) {
                return;
            }


            /*
            |--------------------------------------------------------------------------
            | Sale Date
            |--------------------------------------------------------------------------
            */

            saleDate.value =
                data.date;


            /*
            |--------------------------------------------------------------------------
            | Employee
            |--------------------------------------------------------------------------
            */

            employeeName.textContent =
                data.employee;


            employeePreview.classList.remove(
                'hidden'
            );
        }


        saleSource.addEventListener(
            'change',
            updateSaleSource
        );


        distributionSelect.addEventListener(
            'change',
            updateDistribution
        );


        /*
        |--------------------------------------------------------------------------
        | Products
        |--------------------------------------------------------------------------
        */

        let productIndex =
            {{ old('products') ? count(old('products')) : 0 }};


        const addProductButton =
            document.getElementById(
                'add-product'
            );

        const productsContainer =
            document.getElementById(
                'products-container'
            );

        const productsEmpty =
            document.getElementById(
                'products-empty'
            );


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
                               sm:grid-cols-[1fr_180px_auto]"
                    >

                        <div>

                            <label
                                class="mb-1 block text-xs
                                       font-semibold text-stone-600"
                            >
                                Product
                            </label>


                            <select
                                name="products[${productIndex}][product_id]"
                                required
                                class="w-full rounded-lg
                                       border-stone-300
                                       text-sm shadow-sm
                                       focus:border-amber-500
                                       focus:ring-amber-500"
                            >

                                <option value="">
                                    Select product
                                </option>

                                @foreach ($products as $product)

                                    <option
                                        value="{{ $product->id }}"
                                    >
                                        {{ $product->name }}
                                        -
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        <div>

                            <label
                                class="mb-1 block text-xs
                                       font-semibold text-stone-600"
                            >
                                Quantity
                            </label>


                            <input
                                type="number"
                                step="0.01"
                                min="0.01"
                                name="products[${productIndex}][quantity]"
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


                productsContainer.appendChild(
                    row
                );


                productIndex++;


                updateProductEmptyState();
            }
        );


        /*
        |--------------------------------------------------------------------------
        | Remove Product
        |--------------------------------------------------------------------------
        */

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


        /*
        |--------------------------------------------------------------------------
        | Empty State
        |--------------------------------------------------------------------------
        */

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
        | Initial State
        |--------------------------------------------------------------------------
        */

        updateSaleSource();

    </script>

</x-app-layout>
