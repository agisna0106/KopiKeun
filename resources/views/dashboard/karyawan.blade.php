<x-app-layout>

    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold leading-tight text-stone-800">
                Employee Dashboard
            </h2>

            <p class="mt-1 text-sm text-stone-500">
                Your operational activity overview
            </p>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto w-full px-4 sm:px-6 lg:px-10 xl:px-12">

            {{-- Welcome --}}
            <div class="mb-6 rounded-xl border border-stone-200 bg-white p-5 shadow-sm">

                <p class="text-sm text-stone-500">
                    Welcome back,
                </p>

                <h3 class="mt-1 text-xl font-bold text-stone-800">
                    {{ $employee->user->name }}
                </h3>

                <p class="mt-1 text-sm text-stone-500">
                    Employee Code:
                    <span class="font-medium text-stone-700">
                        {{ $employee->employee_code }}
                    </span>
                </p>

            </div>

            {{-- Summary Cards --}}
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">

                {{-- Today's Distribution --}}
                <div class="rounded-xl border border-stone-200 bg-white p-5 shadow-sm">

                    <p class="text-sm font-medium text-stone-500">
                        Today's Distribution
                    </p>

                    <p class="mt-2 text-2xl font-bold text-stone-800">
                        {{ $todayDistribution ? 'Available' : 'None' }}
                    </p>

                    <p class="mt-1 text-xs text-stone-500">
                        Distribution status today
                    </p>

                </div>

                {{-- Today's Sales --}}
                <div class="rounded-xl border border-stone-200 bg-white p-5 shadow-sm">

                    <p class="text-sm font-medium text-stone-500">
                        Today's Sales
                    </p>

                    <p class="mt-2 text-2xl font-bold text-stone-800">
                        {{ $todaySales->count() }}
                    </p>

                    <p class="mt-1 text-xs text-stone-500">
                        Recorded transactions
                    </p>

                </div>

                {{-- Today's Sales Amount --}}
                <div class="rounded-xl border border-stone-200 bg-white p-5 shadow-sm">

                    <p class="text-sm font-medium text-stone-500">
                        Today's Sales Amount
                    </p>

                    <p class="mt-2 text-2xl font-bold text-stone-800">
                        Rp {{ number_format($todaySalesTotal, 0, ',', '.') }}
                    </p>

                    <p class="mt-1 text-xs text-stone-500">
                        Total recorded sales
                    </p>

                </div>

                {{-- Employee Code --}}
                <div class="rounded-xl border border-stone-200 bg-white p-5 shadow-sm">

                    <p class="text-sm font-medium text-stone-500">
                        Employee Code
                    </p>

                    <p class="mt-2 text-2xl font-bold text-stone-800">
                        {{ $employee->employee_code }}
                    </p>

                    <p class="mt-1 text-xs text-stone-500">
                        Your employee identification
                    </p>

                </div>
            </div>



            {{-- Recent Distribution --}}
            <div class="mt-6 rounded-xl border border-stone-200 bg-white shadow-sm">

                <div class="border-b border-stone-200 px-5 py-4">
                    <h3 class="text-base font-semibold text-stone-800">
                        Recent Distribution
                    </h3>

                    <p class="mt-1 text-sm text-stone-500">
                        Your latest product distributions
                    </p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full min-w-[650px] text-left text-sm">

                        <thead class="border-b border-stone-200 bg-stone-50">
                            <tr>
                                <th class="px-5 py-3 font-semibold text-stone-700">
                                    Date
                                </th>

                                <th class="px-5 py-3 font-semibold text-stone-700">
                                    Base Drink
                                </th>

                                <th class="px-5 py-3 text-right font-semibold text-stone-700">
                                    Estimated Servings
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-stone-200">

                            @forelse($recentDistributions as $distribution)

                                @foreach($distribution->details as $detail)

                                    <tr class="hover:bg-stone-50">

                                        <td class="whitespace-nowrap px-5 py-3 text-stone-600">
                                            {{ $distribution->distribution_date->format('d M Y') }}
                                        </td>

                                        <td class="px-5 py-3 font-medium text-stone-800">
                                            {{ $detail->baseDrink->name }}
                                        </td>

                                        <td class="px-5 py-3 text-right text-stone-600">
                                            {{ rtrim(rtrim(number_format($detail->quantity, 2, ',', '.'), '0'), ',') }}
                                        </td>

                                    </tr>

                                @endforeach

                            @empty

                                <tr>
                                    <td
                                        colspan="3"
                                        class="px-5 py-8 text-center text-sm text-stone-500"
                                    >
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
                        Your latest recorded sales
                    </p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full min-w-[750px] text-left text-sm">

                        <thead class="border-b border-stone-200 bg-stone-50">
                            <tr>
                                <th class="px-5 py-3 font-semibold text-stone-700">
                                    Date
                                </th>

                                <th class="px-5 py-3 font-semibold text-stone-700">
                                    Product
                                </th>

                                <th class="px-5 py-3 text-right font-semibold text-stone-700">
                                    Quantity
                                </th>

                                <th class="px-5 py-3 text-right font-semibold text-stone-700">
                                    Total
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-stone-200">

                            @forelse($recentSales as $sale)

                                @foreach($sale->details as $detail)

                                    <tr class="hover:bg-stone-50">

                                        <td class="whitespace-nowrap px-5 py-3 text-stone-600">
                                            {{ $sale->sale_date->format('d M Y') }}
                                        </td>

                                        <td class="px-5 py-3 font-medium text-stone-800">
                                            {{ $detail->product->name }}
                                        </td>

                                        <td class="px-5 py-3 text-right text-stone-600">
                                            {{ rtrim(rtrim(number_format($detail->quantity, 2, ',', '.'), '0'), ',') }}
                                        </td>

                                        <td class="whitespace-nowrap px-5 py-3 text-right font-semibold text-stone-800">
                                            Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                        </td>

                                    </tr>

                                @endforeach

                            @empty

                                <tr>
                                    <td
                                        colspan="4"
                                        class="px-5 py-8 text-center text-sm text-stone-500"
                                    >
                                        No sales records found.
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>
                </div>

            </div>

        </div>
    </div>

</x-app-layout>
