<x-app-layout>

    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold leading-tight text-stone-800">
                Financial Report
            </h2>

            <p class="mt-1 text-sm text-stone-500">
                Financial overview based on recorded sales and expenses
            </p>
        </div>
    </x-slot>


    <div class="py-6">

        <div class="mx-auto w-full px-4 sm:px-6 lg:px-8 xl:px-10 2xl:px-12">


            {{-- ========================================================= --}}
            {{-- Report Period --}}
            {{-- ========================================================= --}}

            <div class="mb-6 rounded-xl border border-stone-200 bg-white p-5 shadow-sm">

                <div class="mb-5">

                    <h3 class="text-base font-semibold text-stone-800">
                        Report Period
                    </h3>

                    <p class="mt-1 text-sm text-stone-500">
                        Select the period for the financial report.
                    </p>

                </div>


                <form
                    action="{{ route('financial-reports.index') }}"
                    method="GET"
                >

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">


                        {{-- Start Date --}}

                        <div>

                            <label
                                for="start_date"
                                class="mb-1.5 block text-sm font-semibold text-stone-700"
                            >
                                Start Date
                            </label>

                            <input
                                type="date"
                                name="start_date"
                                id="start_date"
                                value="{{ $startDate }}"
                                required
                                class="w-full rounded-lg border-stone-300
                                       text-sm shadow-sm
                                       focus:border-amber-500
                                       focus:ring-amber-500"
                            >

                        </div>


                        {{-- End Date --}}

                        <div>

                            <label
                                for="end_date"
                                class="mb-1.5 block text-sm font-semibold text-stone-700"
                            >
                                End Date
                            </label>

                            <input
                                type="date"
                                name="end_date"
                                id="end_date"
                                value="{{ $endDate }}"
                                required
                                class="w-full rounded-lg border-stone-300
                                       text-sm shadow-sm
                                       focus:border-amber-500
                                       focus:ring-amber-500"
                            >

                        </div>


                        {{-- Button --}}

                        <div class="flex items-end">

                            <button
                                type="submit"
                                class="w-full rounded-lg bg-amber-700
                                       px-5 py-2.5 text-sm font-semibold
                                       text-white shadow-sm
                                       hover:bg-amber-800"
                            >
                                Generate Report
                            </button>

                        </div>

                    </div>

                </form>


                {{-- Period Information --}}

                <div class="mt-5 rounded-lg border border-stone-200 bg-stone-50 px-4 py-3">

                    <p class="text-sm text-stone-600">

                        Showing financial data from

                        <span class="font-semibold text-stone-800">
                            {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }}
                        </span>

                        to

                        <span class="font-semibold text-stone-800">
                            {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}
                        </span>

                    </p>

                </div>

            </div>


            {{-- ========================================================= --}}
            {{-- Financial Summary --}}
            {{-- ========================================================= --}}

            <div class="mb-6 grid grid-cols-1 gap-4 md:grid-cols-3">


                {{-- Total Income --}}

                <div class="rounded-xl border border-stone-200 bg-white p-5 shadow-sm">

                    <p class="text-sm font-medium text-stone-500">
                        Total Income
                    </p>

                    <p class="mt-2 text-2xl font-bold text-stone-800">
                        Rp {{ number_format($totalIncome, 0, ',', '.') }}
                    </p>

                    <p class="mt-1 text-xs text-stone-500">
                        Outlet + Employee Sales
                    </p>

                </div>


                {{-- Total Expenses --}}

                <div class="rounded-xl border border-stone-200 bg-white p-5 shadow-sm">

                    <p class="text-sm font-medium text-stone-500">
                        Total Expenses
                    </p>

                    <p class="mt-2 text-2xl font-bold text-stone-800">
                        Rp {{ number_format($totalExpense, 0, ',', '.') }}
                    </p>

                    <p class="mt-1 text-xs text-stone-500">
                        Incoming Goods + Operational Expenses
                    </p>

                </div>


                {{-- Profit --}}

                <div class="rounded-xl border border-stone-200 bg-white p-5 shadow-sm">

                    <p class="text-sm font-medium text-stone-500">
                        Profit
                    </p>

                    <p
                        class="mt-2 text-2xl font-bold
                        {{ $profit >= 0
                            ? 'text-green-700'
                            : 'text-red-700'
                        }}"
                    >
                        Rp {{ number_format($profit, 0, ',', '.') }}
                    </p>

                    <p class="mt-1 text-xs text-stone-500">
                        Income - Expenses
                    </p>

                </div>

            </div>


            {{-- ========================================================= --}}
            {{-- Income Summary --}}
            {{-- ========================================================= --}}

            <div class="mb-6 rounded-xl border border-stone-200 bg-white p-5 shadow-sm">

                <div class="mb-5">

                    <h3 class="text-base font-semibold text-stone-800">
                        Income Summary
                    </h3>

                    <p class="mt-1 text-sm text-stone-500">
                        Breakdown of recorded sales income.
                    </p>

                </div>


                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">


                    {{-- Outlet Sales --}}

                    <div class="rounded-lg border border-stone-200 p-5">

                        <p class="text-sm text-stone-500">
                            Outlet Sales
                        </p>

                        <p class="mt-2 text-xl font-bold text-stone-800">
                            Rp {{ number_format($outletIncome, 0, ',', '.') }}
                        </p>

                    </div>


                    {{-- Employee Sales --}}

                    <div class="rounded-lg border border-stone-200 p-5">

                        <p class="text-sm text-stone-500">
                            Employee Sales
                        </p>

                        <p class="mt-2 text-xl font-bold text-stone-800">
                            Rp {{ number_format($employeeIncome, 0, ',', '.') }}
                        </p>

                    </div>

                </div>

            </div>


            {{-- ========================================================= --}}
            {{-- Expense Summary --}}
            {{-- ========================================================= --}}

            <div class="mb-6 rounded-xl border border-stone-200 bg-white p-5 shadow-sm">

                <div class="mb-5">

                    <h3 class="text-base font-semibold text-stone-800">
                        Expense Summary
                    </h3>

                    <p class="mt-1 text-sm text-stone-500">
                        Breakdown of recorded business expenses.
                    </p>

                </div>


                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">


                    {{-- Incoming Goods --}}

                    <div class="rounded-lg border border-stone-200 p-5">

                        <p class="text-sm text-stone-500">
                            Incoming Goods
                        </p>

                        <p class="mt-2 text-xl font-bold text-stone-800">
                            Rp {{ number_format($incomingGoodsExpense, 0, ',', '.') }}
                        </p>

                    </div>


                    {{-- Operational Expenses --}}

                    <div class="rounded-lg border border-stone-200 p-5">

                        <p class="text-sm text-stone-500">
                            Operational Expenses
                        </p>

                        <p class="mt-2 text-xl font-bold text-stone-800">
                            Rp {{ number_format($operationalExpense, 0, ',', '.') }}
                        </p>

                    </div>

                </div>

            </div>


            {{-- ========================================================= --}}
            {{-- Sales Transactions --}}
            {{-- ========================================================= --}}

            <div class="mb-6 overflow-hidden rounded-xl border border-stone-200 bg-white shadow-sm">


                <div class="border-b border-stone-200 px-5 py-4">

                    <h3 class="text-base font-semibold text-stone-800">
                        Sales Transactions
                    </h3>

                    <p class="mt-1 text-sm text-stone-500">
                        Sales recorded during the selected period.
                    </p>

                </div>


                @if ($sales->isEmpty())

                    <div class="px-5 py-10 text-center">

                        <p class="text-sm text-stone-500">
                            No sales transactions found for this period.
                        </p>

                    </div>

                @else

                    <div class="overflow-x-auto">

                        <table class="w-full min-w-[850px] text-left text-sm">

                            <thead class="border-b border-stone-200 bg-stone-50">

                                <tr>

                                    <th class="px-5 py-3 font-semibold text-stone-700">
                                        Date
                                    </th>

                                    <th class="px-5 py-3 font-semibold text-stone-700">
                                        Source
                                    </th>

                                    <th class="px-5 py-3 font-semibold text-stone-700">
                                        Employee
                                    </th>

                                    <th class="px-5 py-3 font-semibold text-stone-700">
                                        Products
                                    </th>

                                    <th class="px-5 py-3 text-right font-semibold text-stone-700">
                                        Total
                                    </th>

                                </tr>

                            </thead>


                            <tbody class="divide-y divide-stone-200">


                                @foreach ($sales as $sale)

                                    @php
                                        $saleTotal = $sale->details->sum('subtotal');

                                        $employee =
                                            $sale->distribution?->assignment?->employee;

                                        $employeeName =
                                            $employee?->user?->name;
                                    @endphp


                                    <tr class="hover:bg-stone-50">


                                        {{-- Date --}}

                                        <td class="whitespace-nowrap px-5 py-3 text-stone-600">

                                            {{ $sale->sale_date->format('d M Y') }}

                                        </td>


                                        {{-- Source --}}

                                        <td class="px-5 py-3">

                                            @if ($sale->sale_source === 'Outlet')

                                                <span
                                                    class="inline-flex rounded-full
                                                           bg-stone-100 px-2.5 py-1
                                                           text-xs font-medium
                                                           text-stone-700"
                                                >
                                                    Outlet
                                                </span>

                                            @else

                                                <span
                                                    class="inline-flex rounded-full
                                                           bg-amber-100 px-2.5 py-1
                                                           text-xs font-medium
                                                           text-amber-800"
                                                >
                                                    Employee
                                                </span>

                                            @endif

                                        </td>


                                        {{-- Employee --}}

                                        <td class="px-5 py-3 text-stone-600">

                                            @if ($sale->sale_source === 'Employee')

                                                {{ $employeeName ?? '-' }}

                                            @else

                                                -

                                            @endif

                                        </td>


                                        {{-- Products --}}

                                        <td class="px-5 py-3 text-stone-600">

                                            @if ($sale->details->isNotEmpty())

                                                <div class="space-y-1">

                                                    @foreach ($sale->details as $detail)

                                                        <div>

                                                            <span class="font-medium text-stone-800">
                                                                {{ $detail->product->name ?? '-' }}
                                                            </span>

                                                            <span class="text-stone-500">
                                                                × {{ $detail->quantity }}
                                                            </span>

                                                        </div>

                                                    @endforeach

                                                </div>

                                            @else

                                                <span class="text-stone-400">
                                                    No products
                                                </span>

                                            @endif

                                        </td>


                                        {{-- Total --}}

                                        <td class="whitespace-nowrap px-5 py-3 text-right font-semibold text-stone-800">

                                            Rp {{ number_format(
                                                $saleTotal,
                                                0,
                                                ',',
                                                '.'
                                            ) }}

                                        </td>

                                    </tr>

                                @endforeach


                            </tbody>

                        </table>

                    </div>


                    {{-- Sales Pagination --}}

                    @if ($sales->hasPages())

                        <div class="border-t border-stone-200 px-5 py-4">

                            {{ $sales->appends(request()->except('sales_page'))->links() }}

                        </div>

                    @endif

                @endif

            </div>


            {{-- ========================================================= --}}
            {{-- Incoming Goods --}}
            {{-- ========================================================= --}}

            <div class="mb-6 overflow-hidden rounded-xl border border-stone-200 bg-white shadow-sm">


                <div class="border-b border-stone-200 px-5 py-4">

                    <h3 class="text-base font-semibold text-stone-800">
                        Incoming Goods
                    </h3>

                    <p class="mt-1 text-sm text-stone-500">
                        Raw material purchases during the selected period.
                    </p>

                </div>


                @if ($incomingGoods->isEmpty())

                    <div class="px-5 py-10 text-center">

                        <p class="text-sm text-stone-500">
                            No incoming goods found for this period.
                        </p>

                    </div>

                @else

                    <div class="overflow-x-auto">

                        <table class="w-full min-w-[800px] text-left text-sm">

                            <thead class="border-b border-stone-200 bg-stone-50">

                                <tr>

                                    <th class="px-5 py-3 font-semibold text-stone-700">
                                        Date
                                    </th>

                                    <th class="px-5 py-3 font-semibold text-stone-700">
                                        Raw Material
                                    </th>

                                    <th class="px-5 py-3 text-right font-semibold text-stone-700">
                                        Quantity
                                    </th>

                                    <th class="px-5 py-3 text-right font-semibold text-stone-700">
                                        Unit Cost
                                    </th>

                                    <th class="px-5 py-3 text-right font-semibold text-stone-700">
                                        Total
                                    </th>

                                </tr>

                            </thead>


                            <tbody class="divide-y divide-stone-200">


                                @foreach ($incomingGoods as $item)

                                    @php
                                        $itemTotal =
                                            $item->quantity *
                                            $item->unit_cost;
                                    @endphp


                                    <tr class="hover:bg-stone-50">


                                        {{-- Date --}}

                                        <td class="whitespace-nowrap px-5 py-3 text-stone-600">

                                            {{ $item->received_at->format('d M Y') }}

                                        </td>


                                        {{-- Raw Material --}}

                                        <td class="px-5 py-3 font-medium text-stone-800">

                                            {{ $item->rawMaterial->name ?? '-' }}

                                        </td>


                                        {{-- Quantity --}}

                                        <td class="whitespace-nowrap px-5 py-3 text-right text-stone-600">

                                            {{ number_format(
                                                $item->quantity,
                                                2,
                                                ',',
                                                '.'
                                            ) }}

                                            {{ $item->rawMaterial->unit ?? '' }}

                                        </td>


                                        {{-- Unit Cost --}}

                                        <td class="whitespace-nowrap px-5 py-3 text-right text-stone-600">

                                            Rp {{ number_format(
                                                $item->unit_cost,
                                                0,
                                                ',',
                                                '.'
                                            ) }}

                                        </td>


                                        {{-- Total --}}

                                        <td class="whitespace-nowrap px-5 py-3 text-right font-semibold text-stone-800">

                                            Rp {{ number_format(
                                                $itemTotal,
                                                0,
                                                ',',
                                                '.'
                                            ) }}

                                        </td>

                                    </tr>

                                @endforeach


                            </tbody>

                        </table>

                    </div>


                    {{-- Incoming Goods Pagination --}}

                    @if ($incomingGoods->hasPages())

                        <div class="border-t border-stone-200 px-5 py-4">

                            {{ $incomingGoods->appends(request()->except('incoming_goods_page'))->links() }}

                        </div>

                    @endif

                @endif

            </div>


            {{-- ========================================================= --}}
            {{-- Operational Expenses --}}
            {{-- ========================================================= --}}

            <div class="overflow-hidden rounded-xl border border-stone-200 bg-white shadow-sm">


                <div class="border-b border-stone-200 px-5 py-4">

                    <h3 class="text-base font-semibold text-stone-800">
                        Operational Expenses
                    </h3>

                    <p class="mt-1 text-sm text-stone-500">
                        Operational expenses during the selected period.
                    </p>

                </div>


                @if ($operationalExpenses->isEmpty())

                    <div class="px-5 py-10 text-center">

                        <p class="text-sm text-stone-500">
                            No operational expenses found for this period.
                        </p>

                    </div>

                @else

                    <div class="overflow-x-auto">

                        <table class="w-full min-w-[750px] text-left text-sm">

                            <thead class="border-b border-stone-200 bg-stone-50">

                                <tr>

                                    <th class="px-5 py-3 font-semibold text-stone-700">
                                        Date
                                    </th>

                                    <th class="px-5 py-3 font-semibold text-stone-700">
                                        Expense
                                    </th>

                                    <th class="px-5 py-3 font-semibold text-stone-700">
                                        Notes
                                    </th>

                                    <th class="px-5 py-3 text-right font-semibold text-stone-700">
                                        Amount
                                    </th>

                                </tr>

                            </thead>


                            <tbody class="divide-y divide-stone-200">


                                @foreach ($operationalExpenses as $expense)

                                    <tr class="hover:bg-stone-50">


                                        {{-- Date --}}

                                        <td class="whitespace-nowrap px-5 py-3 text-stone-600">

                                            {{ $expense->expense_date->format('d M Y') }}

                                        </td>


                                        {{-- Expense --}}

                                        <td class="px-5 py-3 font-medium text-stone-800">

                                            {{ $expense->name }}

                                        </td>


                                        {{-- Notes --}}

                                        <td class="px-5 py-3 text-stone-600">

                                            {{ $expense->notes ?: '-' }}

                                        </td>


                                        {{-- Amount --}}

                                        <td class="whitespace-nowrap px-5 py-3 text-right font-semibold text-stone-800">

                                            Rp {{ number_format(
                                                $expense->amount,
                                                0,
                                                ',',
                                                '.'
                                            ) }}

                                        </td>

                                    </tr>

                                @endforeach


                            </tbody>

                        </table>

                    </div>


                    {{-- Operational Expenses Pagination --}}

                    @if ($operationalExpenses->hasPages())

                        <div class="border-t border-stone-200 px-5 py-4">

                            {{ $operationalExpenses->appends(request()->except('expenses_page'))->links() }}

                        </div>

                    @endif

                @endif

            </div>


        </div>

    </div>

</x-app-layout>
