<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Financial Report
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto w-full px-4 sm:px-6 lg:px-8 xl:px-10 2xl:px-12">

            {{-- Filter Period --}}
            <div class="mb-6 rounded-xl bg-white p-6 shadow-sm">
                <h3 class="mb-4 text-lg font-semibold text-gray-800">
                    Report Period
                </h3>

                <form
                    action="{{ route('financial-reports.index') }}"
                    method="GET"
                >
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">

                        <div>
                            <label
                                for="start_date"
                                class="mb-2 block text-sm font-medium text-gray-700"
                            >
                                Start Date
                            </label>

                            <input
                                type="date"
                                name="start_date"
                                id="start_date"
                                value="{{ $startDate }}"
                                required
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500"
                            >
                        </div>

                        <div>
                            <label
                                for="end_date"
                                class="mb-2 block text-sm font-medium text-gray-700"
                            >
                                End Date
                            </label>

                            <input
                                type="date"
                                name="end_date"
                                id="end_date"
                                value="{{ $endDate }}"
                                required
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500"
                            >
                        </div>

                        <div class="flex items-end">
                            <button
                                type="submit"
                                class="w-full rounded-md px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:opacity-90"
                                style="background-color: #ea580c;"
                            >
                                Generate Report
                            </button>
                        </div>

                    </div>
                </form>

                <div class="mt-4 rounded-lg border border-gray-200 bg-gray-50 px-4 py-3">
                    <p class="text-sm text-gray-600">
                        Showing financial data from
                        <span class="font-semibold text-gray-800">
                            {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }}
                        </span>
                        to
                        <span class="font-semibold text-gray-800">
                            {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}
                        </span>
                    </p>
                </div>
            </div>

            {{-- Financial Summary --}}
            <div class="mb-6 grid grid-cols-1 gap-6 md:grid-cols-3">

                <div class="rounded-xl bg-white p-6 shadow-sm">
                    <p class="text-sm font-medium text-gray-500">
                        Total Income
                    </p>

                    <p class="mt-2 text-2xl font-bold text-gray-900">
                        Rp {{ number_format($totalIncome, 0, ',', '.') }}
                    </p>
                </div>

                <div class="rounded-xl bg-white p-6 shadow-sm">
                    <p class="text-sm font-medium text-gray-500">
                        Total Expenses
                    </p>

                    <p class="mt-2 text-2xl font-bold text-gray-900">
                        Rp {{ number_format($totalExpense, 0, ',', '.') }}
                    </p>
                </div>

                <div class="rounded-xl bg-white p-6 shadow-sm">
                    <p class="text-sm font-medium text-gray-500">
                        Profit
                    </p>

                    <p class="mt-2 text-2xl font-bold text-gray-900">
                        Rp {{ number_format($profit, 0, ',', '.') }}
                    </p>
                </div>

            </div>

            {{-- Income Summary --}}
            <div class="mb-6 rounded-xl bg-white p-6 shadow-sm">
                <h3 class="mb-5 text-lg font-semibold text-gray-800">
                    Income Summary
                </h3>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

                    <div class="rounded-lg border border-gray-200 p-5">
                        <p class="text-sm text-gray-500">
                            Outlet Sales
                        </p>

                        <p class="mt-2 text-xl font-bold text-gray-900">
                            Rp {{ number_format($outletIncome, 0, ',', '.') }}
                        </p>
                    </div>

                    <div class="rounded-lg border border-gray-200 p-5">
                        <p class="text-sm text-gray-500">
                            Employee Sales
                        </p>

                        <p class="mt-2 text-xl font-bold text-gray-900">
                            Rp {{ number_format($employeeIncome, 0, ',', '.') }}
                        </p>
                    </div>

                </div>
            </div>

            {{-- Expense Summary --}}
            <div class="mb-6 rounded-xl bg-white p-6 shadow-sm">
                <h3 class="mb-5 text-lg font-semibold text-gray-800">
                    Expense Summary
                </h3>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

                    <div class="rounded-lg border border-gray-200 p-5">
                        <p class="text-sm text-gray-500">
                            Incoming Goods
                        </p>

                        <p class="mt-2 text-xl font-bold text-gray-900">
                            Rp {{ number_format($incomingGoodsExpense, 0, ',', '.') }}
                        </p>
                    </div>

                    <div class="rounded-lg border border-gray-200 p-5">
                        <p class="text-sm text-gray-500">
                            Operational Expenses
                        </p>

                        <p class="mt-2 text-xl font-bold text-gray-900">
                            Rp {{ number_format($operationalExpense, 0, ',', '.') }}
                        </p>
                    </div>

                </div>
            </div>

            {{-- Sales Details --}}
            <div class="mb-6 overflow-hidden rounded-xl bg-white shadow-sm">
                <div class="border-b border-gray-200 px-6 py-4">
                    <h3 class="text-lg font-semibold text-gray-800">
                        Sales Transactions
                    </h3>

                    <p class="mt-1 text-sm text-gray-500">
                        Sales recorded during the selected period.
                    </p>
                </div>

                @if ($sales->isEmpty())
                    <div class="px-6 py-10 text-center">
                        <p class="text-sm text-gray-500">
                            No sales transactions found for this period.
                        </p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">

                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                        Date
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                        Source
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                        Employee
                                    </th>

                                    <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-600">
                                        Total
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200 bg-white">

                                @foreach ($sales as $sale)
                                    @php
                                        $saleTotal = $sale->details->sum('subtotal');
                                    @endphp

                                    <tr class="hover:bg-gray-50">

                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-800">
                                            {{ $sale->sale_date->format('d M Y') }}
                                        </td>

                                        <td class="px-6 py-4 text-sm text-gray-800">
                                            {{ $sale->sale_source }}
                                        </td>

                                        <td class="px-6 py-4 text-sm text-gray-600">
                                            @if ($sale->employee)
                                                {{ $sale->employee->user->name }}
                                            @else
                                                -
                                            @endif
                                        </td>

                                        <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-semibold text-gray-800">
                                            Rp {{ number_format($saleTotal, 0, ',', '.') }}
                                        </td>

                                    </tr>
                                @endforeach

                            </tbody>

                        </table>
                    </div>
                @endif
            </div>

            {{-- Incoming Goods Details --}}
            <div class="mb-6 overflow-hidden rounded-xl bg-white shadow-sm">
                <div class="border-b border-gray-200 px-6 py-4">
                    <h3 class="text-lg font-semibold text-gray-800">
                        Incoming Goods
                    </h3>

                    <p class="mt-1 text-sm text-gray-500">
                        Raw material purchases during the selected period.
                    </p>
                </div>

                @if ($incomingGoods->isEmpty())
                    <div class="px-6 py-10 text-center">
                        <p class="text-sm text-gray-500">
                            No incoming goods found for this period.
                        </p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">

                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                        Date
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                        Raw Material
                                    </th>

                                    <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-600">
                                        Quantity
                                    </th>

                                    <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-600">
                                        Unit Cost
                                    </th>

                                    <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-600">
                                        Total
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200 bg-white">

                                @foreach ($incomingGoods as $item)
                                    @php
                                        $itemTotal =
                                            $item->quantity *
                                            $item->unit_cost;
                                    @endphp

                                    <tr class="hover:bg-gray-50">

                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-800">
                                            {{ $item->received_at->format('d M Y') }}
                                        </td>

                                        <td class="px-6 py-4 text-sm text-gray-800">
                                            {{ $item->rawMaterial->name }}
                                        </td>

                                        <td class="whitespace-nowrap px-6 py-4 text-right text-sm text-gray-600">
                                            {{ number_format($item->quantity, 2, ',', '.') }}
                                            {{ $item->rawMaterial->unit }}
                                        </td>

                                        <td class="whitespace-nowrap px-6 py-4 text-right text-sm text-gray-600">
                                            Rp {{ number_format($item->unit_cost, 0, ',', '.') }}
                                        </td>

                                        <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-semibold text-gray-800">
                                            Rp {{ number_format($itemTotal, 0, ',', '.') }}
                                        </td>

                                    </tr>
                                @endforeach

                            </tbody>

                        </table>
                    </div>
                @endif
            </div>

            {{-- Operational Expenses Details --}}
            <div class="overflow-hidden rounded-xl bg-white shadow-sm">
                <div class="border-b border-gray-200 px-6 py-4">
                    <h3 class="text-lg font-semibold text-gray-800">
                        Operational Expenses
                    </h3>

                    <p class="mt-1 text-sm text-gray-500">
                        Operational expenses during the selected period.
                    </p>
                </div>

                @if ($operationalExpenses->isEmpty())
                    <div class="px-6 py-10 text-center">
                        <p class="text-sm text-gray-500">
                            No operational expenses found for this period.
                        </p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">

                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                        Date
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                        Expense
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                        Notes
                                    </th>

                                    <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-600">
                                        Amount
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200 bg-white">

                                @foreach ($operationalExpenses as $expense)
                                    <tr class="hover:bg-gray-50">

                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-800">
                                            {{ $expense->expense_date->format('d M Y') }}
                                        </td>

                                        <td class="px-6 py-4 text-sm text-gray-800">
                                            {{ $expense->name }}
                                        </td>

                                        <td class="px-6 py-4 text-sm text-gray-600">
                                            {{ $expense->notes ?: '-' }}
                                        </td>

                                        <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-semibold text-gray-800">
                                            Rp {{ number_format($expense->amount, 0, ',', '.') }}
                                        </td>

                                    </tr>
                                @endforeach

                            </tbody>

                        </table>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
