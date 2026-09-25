<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Add Sale
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @if ($errors->any())
                <div class="mb-4 rounded-lg bg-red-100 border border-red-200 px-4 py-3 text-sm text-red-800">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form
                        action="{{ route('sales.store') }}"
                        method="POST"
                        id="sale-form"
                        class="space-y-6"
                    >
                        @csrf

                        {{-- Sale Source --}}
                        <div>
                            <label
                                for="sale_source"
                                class="block text-sm font-medium text-gray-700"
                            >
                                Sale Source
                            </label>

                            <select
                                id="sale_source"
                                name="sale_source"
                                required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >
                                <option value="">Select Source</option>

                                <option
                                    value="Outlet"
                                    {{ old('sale_source') === 'Outlet' ? 'selected' : '' }}
                                >
                                    Outlet
                                </option>

                                <option
                                    value="Employee"
                                    {{ old('sale_source') === 'Employee' ? 'selected' : '' }}
                                >
                                    Employee
                                </option>
                            </select>

                            @error('sale_source')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Employee --}}
                        <div id="employee-field" class="hidden">
                            <label
                                for="employee_id"
                                class="block text-sm font-medium text-gray-700"
                            >
                                Employee
                            </label>

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
                                        {{ old('employee_id') == $employee->id ? 'selected' : '' }}
                                    >
                                        {{ $employee->employee_code }}
                                        -
                                        {{ $employee->user->name }}
                                    </option>
                                @endforeach
                            </select>

                            @error('employee_id')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Sale Date --}}
                        <div>
                            <label
                                for="sale_date"
                                class="block text-sm font-medium text-gray-700"
                            >
                                Sale Date
                            </label>

                            <input
                                type="date"
                                id="sale_date"
                                name="sale_date"
                                value="{{ old('sale_date', now()->toDateString()) }}"
                                required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >

                            @error('sale_date')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Products --}}
                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <h3 class="text-sm font-semibold text-gray-800">
                                    Products
                                </h3>

                                <button
                                    type="button"
                                    id="add-product"
                                    class="px-3 py-2 bg-gray-800 text-white text-xs font-semibold rounded-md hover:bg-gray-700"
                                >
                                    Add Product
                                </button>
                            </div>

                            <div
                                id="product-list"
                                class="space-y-3"
                            ></div>

                            @error('products')
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
                                placeholder="Enter notes (optional)"
                            >{{ old('notes') }}</textarea>

                            @error('notes')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Buttons --}}
                        <div class="flex items-center justify-end gap-3">

                            <a
                                href="{{ route('sales.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-200"
                            >
                                Cancel
                            </a>

                            <button
                                type="submit"
                                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700"
                            >
                                Save Sale
                            </button>

                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

    <script>
        const saleSource = document.getElementById('sale_source');
        const employeeField = document.getElementById('employee-field');
        const employeeSelect = document.getElementById('employee_id');

        const productList = document.getElementById('product-list');
        const addProductButton = document.getElementById('add-product');

        const products = {{ Js::from(
            $products->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                ];
            })->values()
        ) }};

        let productIndex = 0;

        function updateEmployeeField() {
            if (saleSource.value === 'Employee') {
                employeeField.classList.remove('hidden');
                employeeSelect.required = true;
            } else {
                employeeField.classList.add('hidden');
                employeeSelect.required = false;
                employeeSelect.value = '';
            }
        }

        function createProductRow() {
            const row = document.createElement('div');

            row.className =
                'grid grid-cols-1 md:grid-cols-12 gap-3 items-end border rounded-lg p-4';

            let productOptions = `
                <option value="">Select Product</option>
            `;

            products.forEach(product => {
                productOptions += `
                    <option value="${product.id}">
                        ${product.name}
                    </option>
                `;
            });

            row.innerHTML = `
                <div class="md:col-span-6">
                    <label class="block text-sm font-medium text-gray-700">
                        Product
                    </label>

                    <select
                        name="products[${productIndex}][product_id]"
                        required
                        class="product-select mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    >
                        ${productOptions}
                    </select>
                </div>

                <div class="md:col-span-3">
                    <label class="block text-sm font-medium text-gray-700">
                        Quantity
                    </label>

                    <input
                        type="number"
                        name="products[${productIndex}][quantity]"
                        value="1"
                        min="0.01"
                        step="0.01"
                        required
                        class="quantity-input mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    >
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">
                        Subtotal
                    </label>

                    <input
                        type="text"
                        readonly
                        value="Rp 0"
                        class="subtotal-display mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm"
                    >
                </div>

                <div class="md:col-span-1">
                    <button
                        type="button"
                        class="remove-product w-full px-3 py-2 bg-red-600 text-white text-xs font-semibold rounded-md hover:bg-red-700"
                    >
                        Remove
                    </button>
                </div>
            `;

            productList.appendChild(row);

            const productSelect =
                row.querySelector('.product-select');

            const quantityInput =
                row.querySelector('.quantity-input');

            const subtotalDisplay =
                row.querySelector('.subtotal-display');

            function updateSubtotal() {
                const selectedProduct = products.find(
                    product =>
                        product.id == productSelect.value
                );

                const quantity =
                    parseFloat(quantityInput.value) || 0;

                if (!selectedProduct) {
                    subtotalDisplay.value = 'Rp 0';
                    return;
                }

                const subtotal =
                    quantity * parseFloat(selectedProduct.price);

                subtotalDisplay.value =
                    'Rp ' +
                    new Intl.NumberFormat('id-ID').format(
                        subtotal
                    );
            }

            productSelect.addEventListener(
                'change',
                updateSubtotal
            );

            quantityInput.addEventListener(
                'input',
                updateSubtotal
            );

            row.querySelector('.remove-product')
                .addEventListener('click', function () {
                    row.remove();
                });

            productIndex++;
        }

        saleSource.addEventListener(
            'change',
            updateEmployeeField
        );

        addProductButton.addEventListener(
            'click',
            createProductRow
        );

        updateEmployeeField();

        createProductRow();
    </script>
</x-app-layout>
