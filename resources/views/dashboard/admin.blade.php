<x-app-layout>

    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold leading-tight text-stone-800">
                Admin Dashboard
            </h2>

            <p class="mt-1 text-sm text-stone-500">
                Operational overview
            </p>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto w-full px-4 sm:px-6 lg:px-8 xl:px-10 2xl:px-12">

            {{-- Summary Cards --}}
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

                {{-- Active Products --}}
                <div class="rounded-xl border border-stone-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-medium text-stone-500">
                        Active Products
                    </p>

                    <p class="mt-2 text-2xl font-bold text-stone-800">
                        {{ $activeProducts }}
                    </p>

                    <p class="mt-1 text-xs text-stone-500">
                        Currently active products
                    </p>
                </div>

                {{-- Active Raw Materials --}}
                <div class="rounded-xl border border-stone-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-medium text-stone-500">
                        Active Raw Materials
                    </p>

                    <p class="mt-2 text-2xl font-bold text-stone-800">
                        {{ $activeRawMaterials }}
                    </p>

                    <p class="mt-1 text-xs text-stone-500">
                        Currently active materials
                    </p>
                </div>

                {{-- Low Stock --}}
                <div class="rounded-xl border border-stone-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-medium text-stone-500">
                        Low Stock
                    </p>

                    <p class="mt-2 text-2xl font-bold {{ $lowStockMaterials > 0 ? 'text-red-700' : 'text-green-700' }}">
                        {{ $lowStockMaterials }}
                    </p>

                    <p class="mt-1 text-xs text-stone-500">
                        Materials requiring attention
                    </p>
                </div>

                {{-- Active Employees --}}
                <div class="rounded-xl border border-stone-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-medium text-stone-500">
                        Active Employees
                    </p>

                    <p class="mt-2 text-2xl font-bold text-stone-800">
                        {{ $activeEmployees }}
                    </p>

                    <p class="mt-1 text-xs text-stone-500">
                        Currently active employees
                    </p>
                </div>

            </div>

        </div>
    </div>

    <div class="px-3 sm:px-4 lg:px-12">
        {{-- Recent Distributions --}}
        <div class="mt-6 rounded-xl border border-stone-200 bg-white shadow-sm">

            <div class="border-b border-stone-200 px-5 py-4">
                <h3 class="text-base font-semibold text-stone-800">
                    Recent Distributions
                </h3>

                <p class="mt-1 text-sm text-stone-500">
                    Latest product distributions to employees
                </p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[700px] text-left text-sm">

                    <thead class="border-b border-stone-200 bg-stone-50">
                        <tr>
                            <th class="px-5 py-3 font-semibold text-stone-700">
                                Date
                            </th>

                            <th class="px-5 py-3 font-semibold text-stone-700">
                                Employee
                            </th>

                            <th class="px-5 py-3 font-semibold text-stone-700">
                                Products
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-stone-200">

                        @forelse($recentDistributions as $distribution)

                            <tr class="hover:bg-stone-50">

                                <td class="whitespace-nowrap px-5 py-3 text-stone-600">
                                    {{ $distribution->distribution_date->format('d M Y') }}
                                </td>

                                <td class="px-5 py-3 font-medium text-stone-800">
                                    {{ $distribution->employee->user->name ?? '-' }}
                                </td>

                                <td class="px-5 py-3 text-stone-600">
                                    {{ $distribution->details->map(function ($detail) {
                                        return $detail->baseDrink->name . ' (' . rtrim(rtrim(number_format($detail->quantity, 2, ',', '.'), '0'), ',') . ')';
                                    })->implode(', ') }}
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="3" class="px-5 py-8 text-center text-sm text-stone-500">
                                    No distribution records found.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>
            </div>

        </div>

        {{-- Recent Sales --}}
        <div class="mt-6 rounded-xl border border-stone-200 bg-white shadow-sm">

            <div class="border-b border-stone-200 px-5 py-4">
                <h3 class="text-base font-semibold text-stone-800">
                    Recent Sales
                </h3>

                <p class="mt-1 text-sm text-stone-500">
                    Latest recorded sales transactions
                </p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[700px] text-left text-sm">

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

                            <th class="px-5 py-3 text-right font-semibold text-stone-700">
                                Total
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-stone-200">

                        @forelse($recentSales as $sale)

                            <tr class="hover:bg-stone-50">

                                <td class="whitespace-nowrap px-5 py-3 text-stone-600">
                                    {{ $sale->sale_date->format('d M Y') }}
                                </td>

                                <td class="px-5 py-3">

                                    @if($sale->sale_source === 'Outlet')

                                        <span class="inline-flex rounded-full bg-stone-100 px-2.5 py-1 text-xs font-medium text-stone-700">
                                            Outlet
                                        </span>

                                    @else

                                        <span class="inline-flex rounded-full bg-amber-100 px-2.5 py-1 text-xs font-medium text-amber-800">
                                            Employee
                                        </span>

                                    @endif

                                </td>

                                <td class="px-5 py-3 text-stone-600">
                                    {{ $sale->employee->user->name ?? '-' }}
                                </td>

                                <td class="whitespace-nowrap px-5 py-3 text-right font-semibold text-stone-800">
                                    Rp {{ number_format($sale->details->sum('subtotal'), 0, ',', '.') }}
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="4" class="px-5 py-8 text-center text-sm text-stone-500">
                                    No sales records found.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>
            </div>

        </div>

        {{-- Recent Remaining Products --}}
        <div class="mt-6 rounded-xl border border-stone-200 bg-white shadow-sm">

            <div class="border-b border-stone-200 px-5 py-4">
                <h3 class="text-base font-semibold text-stone-800">
                    Recent Remaining Products
                </h3>

                <p class="mt-1 text-sm text-stone-500">
                    Latest estimated remaining product records
                </p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[700px] text-left text-sm">

                    <thead class="border-b border-stone-200 bg-stone-50">
                        <tr>
                            <th class="px-5 py-3 font-semibold text-stone-700">
                                Date
                            </th>

                            <th class="px-5 py-3 font-semibold text-stone-700">
                                Remaining Products
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-stone-200">

                        @forelse($recentRemainingProducts as $remainingProduct)

                            <tr class="hover:bg-stone-50">

                                <td class="whitespace-nowrap px-5 py-3 text-stone-600">
                                    {{ $remainingProduct->recorded_at->format('d M Y') }}
                                </td>

                                <td class="px-5 py-3 text-stone-600">
                                    {{ $remainingProduct->details->map(function ($detail) {
                                        return $detail->baseDrink->name . ' (' . rtrim(rtrim(number_format($detail->quantity, 2, ',', '.'), '0'), ',') . ')';
                                    })->implode(', ') }}
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="2" class="px-5 py-8 text-center text-sm text-stone-500">
                                    No remaining product records found.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>
            </div>

        </div>

        {{-- Recent Incoming Goods --}}
        <div class="mt-6 rounded-xl border border-stone-200 bg-white shadow-sm">

            <div class="border-b border-stone-200 px-5 py-4">
                <h3 class="text-base font-semibold text-stone-800">
                    Recent Incoming Goods
                </h3>

                <p class="mt-1 text-sm text-stone-500">
                    Latest incoming raw material records
                </p>
            </div>

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
                                Total Cost
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-stone-200">

                        @forelse($recentIncomingGoods as $incomingGood)

                            <tr class="hover:bg-stone-50">

                                <td class="whitespace-nowrap px-5 py-3 text-stone-600">
                                    {{ $incomingGood->received_at->format('d M Y') }}
                                </td>

                                <td class="px-5 py-3 font-medium text-stone-800">
                                    {{ $incomingGood->rawMaterial->name ?? '-' }}
                                </td>

                                <td class="px-5 py-3 text-right text-stone-600">
                                    {{ rtrim(rtrim(number_format($incomingGood->quantity, 2, ',', '.'), '0'), ',') }}
                                    {{ $incomingGood->rawMaterial->unit ?? '' }}
                                </td>

                                <td class="px-5 py-3 text-right font-semibold text-stone-800">
                                    Rp {{ number_format($incomingGood->quantity * $incomingGood->unit_cost, 0, ',', '.') }}
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="4" class="px-5 py-8 text-center text-sm text-stone-500">
                                    No incoming goods records found.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>
            </div>

        </div>
    </div>




</x-app-layout>
