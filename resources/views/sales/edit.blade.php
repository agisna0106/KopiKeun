<x-app-layout>

    <x-slot name="header">
        <div>
            <h2 class="text-xl font-bold text-stone-900">
                Edit Sale
            </h2>

            <p class="mt-1 text-sm text-stone-500">
                Update sales information and products sold.
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
                action="{{ route('sales.update', $sale) }}"
                method="POST"
                id="sale-form"
                class="space-y-6"
            >

                @csrf

                @method('PUT')



                {{-- ========================================================= --}}
                {{-- Sale Information --}}
                {{-- ========================================================= --}}

                <x-app-card>

                    <div class="mb-5">

                        <h3 class="text-base font-bold text-stone-900">
                            Sale Information
                        </h3>

                        <p class="mt-1 text-sm text-stone-500">
                            Update the source and date of this sale.
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
                                    {{ old('sale_source', $sale->sale_source) === 'Employee' ? 'selected' : '' }}
                                >
                                    Employee
                                </option>

                                <option
                                    value="Outlet"
                                    {{ old('sale_source', $sale->sale_source) === 'Outlet' ? 'selected' : '' }}
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
                        <div>

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
                                value="{{ old(
                                    'sale_date',
                                    optional($sale->sale_date)->format('Y-m-d')
                                ) }}"
                                required
                                class="w-full rounded-lg border-stone-300
                                       text-sm shadow-sm
                                       focus:border-amber-500
                                       focus:ring-amber-500"
                            >


                            @error('sale_date')

                                <p class="mt-1 text-xs text-red-600">
                                    {{ $message }}
                                </p>

                            @enderror


                            <p
                                id="sale-date-info"
                                class="mt-1 text-xs text-stone-500"
                            ></p>

                        </div>

                    </div>



                    {{-- ===================================================== --}}
                    {{-- Distribution --}}
                    {{-- ===================================================== --}}

                    <div
                        id="distribution-wrapper"
                        class="mt-5"
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
                                    data-employee="{{ $distribution->assignment?->employee?->user?->name ?? '-' }}"
                                    data-employee-code="{{ $distribution->assignment?->employee?->employee_code ?? '-' }}"
                                    {{ old(
                                        'distribution_id',
                                        $sale->distribution_id
                                    ) == $distribution->id ? 'selected' : '' }}
                                >

                                    #{{ $distribution->id }}

                                    -
                                    {{ $distribution->assignment?->employee?->employee_code ?? '-' }}

                                    -
                                    {{ $distribution->assignment?->employee?->user?->name ?? '-' }}

                                    |
                                    {{ $distribution->distribution_date->format('d M Y') }}

                                </option>

                            @endforeach

                        </select>


                        @error('distribution_id')

                            <p class="mt-1 text-xs text-red-600">
                                {{ $message }}
                            </p>

                        @enderror


                        <p class="mt-1 text-xs text-stone-500">
                            Select the distribution related to this employee sale.
                        </p>


                        {{-- Distribution Information --}}

                        <div
                            id="distribution-info"
                            class="mt-3 hidden rounded-lg bg-stone-50
                                   px-4 py-3 text-sm text-stone-600"
                        >

                            <div class="grid gap-2 sm:grid-cols-3">

                                <div>

                                    <span class="font-semibold text-stone-700">
                                        Employee:
                                    </span>

                                    <span id="distribution-employee">
                                        -
                                    </span>

                                </div>


                                <div>

                                    <span class="font-semibold text-stone-700">
                                        Employee Code:
                                    </span>

                                    <span id="distribution-employee-code">
                                        -
                                    </span>

                                </div>


                                <div>

                                    <span class="font-semibold text-stone-700">
                                        Distribution Date:
                                    </span>

                                    <span id="distribution-date">
                                        -
                                    </span>

                                </div>

                            </div>

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
                        >{{ old('notes', $sale->notes) }}</textarea>


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


                        @foreach ($sale->details as $index => $detail)

                            <div
                                class="product-row rounded-lg
                                       border border-stone-200 p-4"
                            >

                                <div
                                    class="grid gap-3
                                           sm:grid-cols-[1fr_160px_160px_auto]"
                                >


                                    {{-- Product --}}

                                    <div>

                                        <label
                                            class="mb-1 block text-xs font-semibold text-stone-600"
                                        >
                                            Product
                                        </label>


                                        <select
                                            name="products[{{ $index }}][product_id]"
                                            required
                                            class="product-select w-full
                                                   rounded-lg border-stone-300
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
                                                    data-price="{{ $product->price }}"
                                                    {{ $detail->product_id == $product->id ? 'selected' : '' }}
                                                >

                                                    {{ $product->name }}

                                                </option>

                                            @endforeach

                                        </select>


                                        <p
                                            class="product-price mt-1 text-xs text-stone-500"
                                        >
                                            Price:
                                            Rp {{ number_format($detail->product->price ?? 0, 0, ',', '.') }}
                                        </p>

                                    </div>



                                    {{-- Quantity --}}

                                    <div>

                                        <label
                                            class="mb-1 block text-xs font-semibold text-stone-600"
                                        >
                                            Quantity
                                        </label>


                                        <input
                                            type="number"
                                            min="1"
                                            step="1"
                                            name="products[{{ $index }}][quantity]"
                                            value="{{ old(
                                                "products.$index.quantity",
                                                (int) $detail->quantity
                                            ) }}"
                                            required
                                            class="product-quantity w-full
                                                   rounded-lg border-stone-300
                                                   text-sm shadow-sm
                                                   focus:border-amber-500
                                                   focus:ring-amber-500"
                                        >

                                    </div>



                                    {{-- Subtotal --}}

                                    <div>

                                        <label
                                            class="mb-1 block text-xs font-semibold text-stone-600"
                                        >
                                            Subtotal
                                        </label>


                                        <div
                                            class="product-subtotal rounded-lg
                                                   border border-stone-200
                                                   bg-stone-50 px-3 py-2
                                                   text-sm font-semibold
                                                   text-stone-700"
                                        >

                                            Rp
                                            {{ number_format(
                                                $detail->subtotal,
                                                0,
                                                ',',
                                                '.'
                                            ) }}

                                        </div>

                                    </div>



                                    {{-- Remove --}}

                                    <div class="flex items-end">

                                        <button
                                            type="button"
                                            class="remove-product w-full
                                                   rounded-lg bg-red-50 px-3 py-2
                                                   text-xs font-semibold text-red-600
                                                   hover:bg-red-100
                                                   sm:w-auto"
                                        >
                                            Remove
                                        </button>

                                    </div>

                                </div>

                            </div>

                        @endforeach

                    </div>



                    {{-- Empty State --}}

                    <div
                        id="products-empty"
                        class="mt-5 rounded-lg border border-dashed
                               border-stone-300 px-4 py-6 text-center
                               {{ $sale->details->isNotEmpty() ? 'hidden' : '' }}"
                    >

                        <p class="text-sm font-medium text-stone-600">
                            No products added.
                        </p>

                        <p class="mt-1 text-xs text-stone-500">
                            Click "Add Product" to add a product.
                        </p>

                    </div>



                    {{-- Total --}}

                    <div
                        class="mt-5 flex items-center justify-between
                               border-t border-stone-200 pt-4"
                    >

                        <span class="text-sm font-semibold text-stone-700">
                            Total Amount
                        </span>


                        <span
                            id="grand-total"
                            class="text-lg font-bold text-stone-900"
                        >
                            Rp
                            {{ number_format(
                                $sale->details->sum('subtotal'),
                                0,
                                ',',
                                '.'
                            ) }}
                        </span>

                    </div>

                </x-app-card>



                {{-- ========================================================= --}}
                {{-- Actions --}}
                {{-- ========================================================= --}}

                <div class="flex items-center justify-end gap-3">

                    <a
                        href="{{ route('sales.show', $sale) }}"
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
                        Update Sale
                    </button>

                </div>

            </form>

        </div>

    </div>



    {{-- ============================================================= --}}
    {{-- JavaScript --}}
    {{-- ============================================================= --}}

    <script>

        let productIndex =
            {{ $sale->details->count() }};


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

        const distributionInfo =
            document.getElementById('distribution-info');

        const distributionEmployee =
            document.getElementById('distribution-employee');

        const distributionEmployeeCode =
            document.getElementById('distribution-employee-code');

        const distributionDate =
            document.getElementById('distribution-date');

        const saleDate =
            document.getElementById('sale_date');

        const saleDateInfo =
            document.getElementById('sale-date-info');

        const productsContainer =
            document.getElementById('products-container');

        const productsEmpty =
            document.getElementById('products-empty');

        const addProductButton =
            document.getElementById('add-product');

        const grandTotal =
            document.getElementById('grand-total');



        /*
        |--------------------------------------------------------------------------
        | Sale Source
        |--------------------------------------------------------------------------
        */

        function updateSaleSource()
        {
            if (saleSource.value === 'Employee') {

                distributionWrapper.classList.remove('hidden');

                distributionSelect.required = true;

                updateDistributionInfo();

            } else {

                distributionWrapper.classList.add('hidden');

                distributionSelect.required = false;

                distributionInfo.classList.add('hidden');

                saleDateInfo.textContent =
                    'Sale date can be selected manually for outlet sales.';

            }
        }



        /*
        |--------------------------------------------------------------------------
        | Distribution
        |--------------------------------------------------------------------------
        */

        function updateDistributionInfo()
        {
            const selectedOption =
                distributionSelect.options[
                    distributionSelect.selectedIndex
                ];


            if (
                !selectedOption ||
                !selectedOption.value
            ) {

                distributionInfo.classList.add('hidden');

                return;
            }


            const date =
                selectedOption.dataset.date || '';

            const employee =
                selectedOption.dataset.employee || '-';

            const employeeCode =
                selectedOption.dataset.employeeCode || '-';


            distributionEmployee.textContent =
                employee;

            distributionEmployeeCode.textContent =
                employeeCode;

            distributionDate.textContent =
                date;


            distributionInfo.classList.remove('hidden');


            /*
             * Employee sale uses distribution date.
             */

            saleDate.value = date;

            saleDate.readOnly = true;

            saleDate.classList.add(
                'bg-stone-100',
                'cursor-not-allowed'
            );


            saleDateInfo.textContent =
                'Sale date is taken from the selected distribution date.';
        }



        distributionSelect.addEventListener(
            'change',
            updateDistributionInfo
        );


        saleSource.addEventListener(
            'change',
            updateSaleSource
        );



        /*
        |--------------------------------------------------------------------------
        | Add Product
        |--------------------------------------------------------------------------
        */

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
                               sm:grid-cols-[1fr_160px_160px_auto]"
                    >

                        <div>

                            <label
                                class="mb-1 block text-xs font-semibold text-stone-600"
                            >
                                Product
                            </label>

                            <select
                                name="products[${productIndex}][product_id]"
                                required
                                class="product-select w-full
                                       rounded-lg border-stone-300
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
                                        data-price="{{ $product->price }}"
                                    >
                                        {{ $product->name }}
                                    </option>

                                @endforeach

                            </select>

                            <p
                                class="product-price mt-1 text-xs text-stone-500"
                            >
                                Price: -
                            </p>

                        </div>


                        <div>

                            <label
                                class="mb-1 block text-xs font-semibold text-stone-600"
                            >
                                Quantity
                            </label>

                            <input
                                type="number"
                                min="1"
                                step="1"
                                name="products[${productIndex}][quantity]"
                                required
                                class="product-quantity w-full
                                       rounded-lg border-stone-300
                                       text-sm shadow-sm
                                       focus:border-amber-500
                                       focus:ring-amber-500"
                            >

                        </div>


                        <div>

                            <label
                                class="mb-1 block text-xs font-semibold text-stone-600"
                            >
                                Subtotal
                            </label>

                            <div
                                class="product-subtotal rounded-lg
                                       border border-stone-200
                                       bg-stone-50 px-3 py-2
                                       text-sm font-semibold
                                       text-stone-700"
                            >
                                Rp 0
                            </div>

                        </div>


                        <div class="flex items-end">

                            <button
                                type="button"
                                class="remove-product w-full
                                       rounded-lg bg-red-50 px-3 py-2
                                       text-xs font-semibold text-red-600
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

                    const row =
                        event.target.closest(
                            '.product-row'
                        );


                    if (row) {
                        row.remove();
                    }


                    updateProductEmptyState();

                    calculateGrandTotal();

                }

            }
        );



        /*
        |--------------------------------------------------------------------------
        | Product Change
        |--------------------------------------------------------------------------
        */

        document.addEventListener(
            'change',
            (event) => {

                if (
                    event.target.classList.contains(
                        'product-select'
                    )
                ) {

                    updateProductRow(
                        event.target.closest(
                            '.product-row'
                        )
                    );

                }

            }
        );



        /*
        |--------------------------------------------------------------------------
        | Quantity Change
        |--------------------------------------------------------------------------
        */

        document.addEventListener(
            'input',
            (event) => {

                if (
                    event.target.classList.contains(
                        'product-quantity'
                    )
                ) {

                    updateProductRow(
                        event.target.closest(
                            '.product-row'
                        )
                    );

                }

            }
        );



        /*
        |--------------------------------------------------------------------------
        | Update Product Row
        |--------------------------------------------------------------------------
        */

        function updateProductRow(row)
        {
            if (!row) {
                return;
            }


            const select =
                row.querySelector(
                    '.product-select'
                );

            const quantityInput =
                row.querySelector(
                    '.product-quantity'
                );

            const priceDisplay =
                row.querySelector(
                    '.product-price'
                );

            const subtotalDisplay =
                row.querySelector(
                    '.product-subtotal'
                );


            const selectedOption =
                select.options[
                    select.selectedIndex
                ];


            const price =
                parseFloat(
                    selectedOption?.dataset.price || 0
                );


            const quantity =
                parseFloat(
                    quantityInput.value || 0
                );


            const subtotal =
                price * quantity;


            priceDisplay.textContent =
                `Price: Rp ${formatRupiah(price)}`;


            subtotalDisplay.textContent =
                `Rp ${formatRupiah(subtotal)}`;


            calculateGrandTotal();
        }



        /*
        |--------------------------------------------------------------------------
        | Calculate Grand Total
        |--------------------------------------------------------------------------
        */

        function calculateGrandTotal()
        {
            let total = 0;


            document
                .querySelectorAll('.product-row')
                .forEach(row => {

                    const select =
                        row.querySelector(
                            '.product-select'
                        );

                    const quantityInput =
                        row.querySelector(
                            '.product-quantity'
                        );


                    const selectedOption =
                        select?.options[
                            select.selectedIndex
                        ];


                    const price =
                        parseFloat(
                            selectedOption?.dataset.price || 0
                        );


                    const quantity =
                        parseFloat(
                            quantityInput?.value || 0
                        );


                    total +=
                        price * quantity;

                });


            grandTotal.textContent =
                `Rp ${formatRupiah(total)}`;
        }



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
        | Rupiah Formatter
        |--------------------------------------------------------------------------
        */

        function formatRupiah(value)
        {
            return new Intl.NumberFormat(
                'id-ID'
            ).format(
                Math.round(value)
            );
        }



        /*
        |--------------------------------------------------------------------------
        | Initial State
        |--------------------------------------------------------------------------
        */

        document.addEventListener(
            'DOMContentLoaded',
            () => {

                updateSaleSource();


                document
                    .querySelectorAll(
                        '.product-row'
                    )
                    .forEach(row => {

                        updateProductRow(row);

                    });


                calculateGrandTotal();

            }
        );

    </script>

</x-app-layout>
