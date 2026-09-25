<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Sale
            </h2>

            <a
                href="{{ route('sales.index') }}"
                class="inline-flex items-center rounded-md bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-300"
            >
                Back
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">

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
                action="{{ route('sales.update', $sale) }}"
                class="space-y-6"
            >
                @csrf
                @method('PUT')

                {{-- Sale Information --}}
                <div class="rounded-lg bg-white p-6 shadow-sm">
                    <h3 class="mb-4 text-lg font-semibold text-gray-800">
                        Sale Information
                    </h3>

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                        {{-- Sale Source --}}
                        <div>
                            <x-input-label
                                for="sale_source"
                                value="Sale Source"
                            />

                            <select
                                id="sale_source"
                                name="sale_source"
                                required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >
                                <option value="">
                                    Select Source
                                </option>

                                <option
                                    value="Outlet"
                                    {{ old('sale_source', $sale->sale_source) === 'Outlet' ? 'selected' : '' }}
                                >
                                    Outlet
                                </option>

                                <option
                                    value="Employee"
                                    {{ old('sale_source', $sale->sale_source) === 'Employee' ? 'selected' : '' }}
                                >
                                    Employee
                                </option>
                            </select>

                            <x-input-error
                                :messages="$errors->get('sale_source')"
                                class="mt-2"
                            />
                        </div>

                        {{-- Employee --}}
                        <div id="employee-wrapper">
                            <x-input-label
                                for="employee_id"
                                value="Employee"
                            />

                            <select
                                id="employee_id"
                                name="employee_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >
                                <option value="">
                                    Select Employee
                                </option>

                                @foreach ($employees as $employee)
                                    <option
                                        value="{{ $employee->id }}"
                                        {{ (string) old('employee_id', $sale->employee_id) === (string) $employee->id ? 'selected' : '' }}
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

                        {{-- Sale Date --}}
                        <div>
                            <x-input-label
                                for="sale_date"
                                value="Sale Date"
                            />

                            <x-text-input
                                id="sale_date"
                                name="sale_date"
                                type="date"
                                class="mt-1 block w-full"
                                value="{{ old('sale_date', $sale->sale_date->format('Y-m-d')) }}"
                                required
                            />

                            <x-input-error
                                :messages="$errors->get('sale_date')"
                                class="mt-2"
                            />
                        </div>

                        {{-- Notes --}}
                        <div>
                            <x-input-label
                                for="notes"
                                value="Notes"
                            />

                            <textarea
                                id="notes"
                                name="notes"
                                rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >{{ old('notes', $sale->notes) }}</textarea>

                            <x-input-error
                                :messages="$errors->get('notes')"
                                class="mt-2"
                            />
                        </div>

                    </div>
                </div>

                {{-- Products --}}
                <div class="rounded-lg bg-white p-6 shadow-sm">

                    <div class="mb-4 flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">
                                Products
                            </h3>

                            <p class="mt-1 text-sm text-gray-500">
                                Add products and adjust quantities.
                            </p>
                        </div>

                        <button
                            type="button"
                            id="add-product"
                            class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700"
                        >
                            Add Product
                        </button>
                    </div>

                    <div
                        id="product-list"
                        class="space-y-4"
                    ></div>

                    {{-- Grand Total --}}
                    <div class="mt-6 flex justify-end border-t pt-4">
                        <div class="text-right">
                            <p class="text-sm text-gray-500">
                                Grand Total
                            </p>

                            <p
                                id="grand-total"
                                class="text-2xl font-bold text-gray-900"
                            >
                                Rp 0
                            </p>
                        </div>
                    </div>

                </div>

                {{-- Buttons --}}
                    <div class="mt-6 flex items-center justify-end gap-3 border-t pt-6">

                        <a
                            href="{{ route('sales.index') }}"
                            class="inline-flex items-center rounded-md bg-gray-200 px-5 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-300"
                        >
                            Cancel
                        </a>

                        <button
                            type="submit"
                            class="inline-flex items-center rounded-md bg-orange-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-orange-700"
                            style="background-color: #ea580c; color: white;"
                        >
                            Update Sale
                        </button>

                    </div>

            </form>

        </div>
    </div>

    <script>
        const products = @js(
            $products->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => (float) $product->price,
                ];
            })->values()
        );

        const existingDetails = @js(
            $sale->details->map(function ($detail) {
                return [
                    'product_id' => $detail->product_id,
                    'quantity' => (float) $detail->quantity,
                ];
            })->values()
        );

        const productList = document.getElementById('product-list');
        const addProductButton = document.getElementById('add-product');
        const grandTotalElement = document.getElementById('grand-total');

        const saleSource = document.getElementById('sale_source');
        const employeeWrapper = document.getElementById('employee-wrapper');
        const employeeSelect = document.getElementById('employee_id');


        // Format number to Indonesian Rupiah format
        function formatRupiah(value) {
            return new Intl.NumberFormat('id-ID').format(value);
        }


        // Show or hide Employee field based on Sale Source
        function updateEmployeeVisibility() {
            if (saleSource.value === 'Employee') {
                employeeWrapper.classList.remove('hidden');
                employeeSelect.required = true;
            } else {
                employeeWrapper.classList.add('hidden');
                employeeSelect.required = false;
                employeeSelect.value = '';
            }
        }


        // Calculate Grand Total
        function updateGrandTotal() {
            let total = 0;

            document.querySelectorAll('.product-row').forEach(row => {
                const quantityInput =
                    row.querySelector('.quantity-input');

                const subtotalElement =
                    row.querySelector('.subtotal');

                const quantity =
                    parseFloat(quantityInput.value) || 0;

                const price =
                    parseFloat(row.dataset.price) || 0;

                const subtotal =
                    quantity * price;

                subtotalElement.textContent =
                    `Rp ${formatRupiah(subtotal)}`;

                total += subtotal;
            });

            grandTotalElement.textContent =
                `Rp ${formatRupiah(total)}`;
        }


        // Prevent selecting the same product more than once
        function updateProductOptions() {
            const selectedValues = Array.from(
                document.querySelectorAll('.product-select')
            )
                .map(select => select.value)
                .filter(value => value !== '');

            document.querySelectorAll('.product-select').forEach(select => {

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


        // Create product row
        function createProductRow(productId = '', quantity = 1) {

            const index =
                document.querySelectorAll('.product-row').length;

            const row =
                document.createElement('div');

            row.className =
                'product-row rounded-lg border border-gray-200 p-4';

            row.dataset.price = '0';

            row.innerHTML = `
                <div class="grid grid-cols-1 gap-4 md:grid-cols-12 md:items-end">

                    {{-- Product --}}
                    <div class="md:col-span-5">
                        <label class="block text-sm font-medium text-gray-700">
                            Product
                        </label>

                        <select
                            name="products[${index}][product_id]"
                            class="product-select mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            required
                        >
                            <option value="">
                                Select Product
                            </option>
                        </select>
                    </div>


                    {{-- Quantity --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">
                            Quantity
                        </label>

                        <input
                            type="number"
                            name="products[${index}][quantity]"
                            value="${quantity}"
                            min="0.01"
                            step="0.01"
                            class="quantity-input mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            required
                        >
                    </div>


                    {{-- Unit Price --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">
                            Unit Price
                        </label>

                        <div
                            class="unit-price mt-1 rounded-md bg-gray-50 px-3 py-2 text-sm text-gray-700"
                        >
                            Rp 0
                        </div>
                    </div>


                    {{-- Subtotal --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">
                            Subtotal
                        </label>

                        <div
                            class="subtotal mt-1 rounded-md bg-gray-50 px-3 py-2 text-sm font-semibold text-gray-900"
                        >
                            Rp 0
                        </div>
                    </div>


                    {{-- Remove --}}
                    <div class="md:col-span-1">
                        <button
                            type="button"
                            class="remove-product w-full rounded-md bg-red-100 px-3 py-2 text-sm font-semibold text-red-700 hover:bg-red-200"
                        >
                            Remove
                        </button>
                    </div>

                </div>
            `;


            const productSelect =
                row.querySelector('.product-select');

            const quantityInput =
                row.querySelector('.quantity-input');

            const unitPriceElement =
                row.querySelector('.unit-price');

            const removeButton =
                row.querySelector('.remove-product');


            // Add products to select
            products.forEach(product => {

                const option =
                    document.createElement('option');

                option.value =
                    product.id;

                option.textContent =
                    `${product.name} - Rp ${formatRupiah(product.price)}`;

                if (
                    String(product.id) ===
                    String(productId)
                ) {
                    option.selected = true;
                }

                productSelect.appendChild(option);
            });


            // Update product row
            function updateRow() {

                const selectedProduct =
                    products.find(
                        product =>
                            String(product.id) ===
                            String(productSelect.value)
                    );

                if (!selectedProduct) {

                    row.dataset.price = '0';

                    unitPriceElement.textContent =
                        'Rp 0';

                } else {

                    row.dataset.price =
                        selectedProduct.price;

                    unitPriceElement.textContent =
                        `Rp ${formatRupiah(selectedProduct.price)}`;
                }

                updateGrandTotal();
                updateProductOptions();
            }


            // Product changed
            productSelect.addEventListener(
                'change',
                updateRow
            );


            // Quantity changed
            quantityInput.addEventListener(
                'input',
                updateGrandTotal
            );


            // Remove product
            removeButton.addEventListener(
                'click',
                () => {

                    row.remove();

                    updateGrandTotal();
                    updateProductOptions();
                }
            );


            productList.appendChild(row);

            updateRow();
        }


        // Add new product
        addProductButton.addEventListener(
            'click',
            () => {
                createProductRow();
            }
        );


        // Sale Source changed
        saleSource.addEventListener(
            'change',
            updateEmployeeVisibility
        );


        // Load existing sale details
        existingDetails.forEach(detail => {

            createProductRow(
                detail.product_id,
                detail.quantity
            );

        });


        // Create empty row if no details exist
        if (existingDetails.length === 0) {
            createProductRow();
        }


        // Initial state
        updateEmployeeVisibility();
        updateGrandTotal();
    </script>
</x-app-layout>
