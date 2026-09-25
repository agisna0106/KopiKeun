<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Sale Details
            </h2>

            <div class="flex gap-2">
                <a
                    href="{{ route('sales.edit', $sale) }}"
                    class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700"
                >
                    Edit
                </a>

                <a
                    href="{{ route('sales.index') }}"
                    class="inline-flex items-center rounded-md bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-300"
                >
                    Back
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Sale Information --}}
            <div class="mb-6 rounded-lg bg-white p-6 shadow-sm">
                <h3 class="mb-4 text-lg font-semibold text-gray-800">
                    Sale Information
                </h3>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

                    <div>
                        <p class="text-sm text-gray-500">Sale Source</p>

                        <p class="mt-1 font-medium text-gray-900">
                            {{ $sale->sale_source }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Employee</p>

                        <p class="mt-1 font-medium text-gray-900">
                            @if ($sale->employee)
                                {{ $sale->employee->user->name }}
                            @else
                                -
                            @endif
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Sale Date</p>

                        <p class="mt-1 font-medium text-gray-900">
                            {{ $sale->sale_date->format('d/m/Y') }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Notes</p>

                        <p class="mt-1 font-medium text-gray-900">
                            {{ $sale->notes ?: '-' }}
                        </p>
                    </div>

                </div>
            </div>

            {{-- Sale Details --}}
            <div class="overflow-hidden rounded-lg bg-white shadow-sm">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800">
                        Sale Items
                    </h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    Product
                                </th>

                                <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    Quantity
                                </th>

                                <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    Unit Price
                                </th>

                                <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    Subtotal
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200 bg-white">
                            @forelse ($sale->details as $detail)
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        {{ $detail->product->name }}
                                    </td>

                                    <td class="px-6 py-4 text-right text-sm text-gray-900">
                                        {{ number_format($detail->quantity, 2, ',', '.') }}
                                    </td>

                                    <td class="px-6 py-4 text-right text-sm text-gray-900">
                                        Rp {{ number_format($detail->unit_price, 0, ',', '.') }}
                                    </td>

                                    <td class="px-6 py-4 text-right text-sm font-medium text-gray-900">
                                        Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td
                                        colspan="4"
                                        class="px-6 py-6 text-center text-sm text-gray-500"
                                    >
                                        No sale items found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                        <tfoot class="bg-gray-50">
                            <tr>
                                <td
                                    colspan="3"
                                    class="px-6 py-4 text-right text-sm font-semibold text-gray-800"
                                >
                                    Grand Total
                                </td>

                                <td class="px-6 py-4 text-right text-base font-bold text-gray-900">
                                    Rp {{ number_format($sale->details->sum('subtotal'), 0, ',', '.') }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
