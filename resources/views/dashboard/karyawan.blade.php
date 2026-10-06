<x-app-layout>

    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold leading-tight text-stone-800">
                Employee Dashboard
            </h2>

            <p class="mt-1 text-sm text-stone-500">
                Your distribution and sales overview
            </p>
        </div>
    </x-slot>


    <div class="py-6">

        <div class="mx-auto w-full px-4 sm:px-6 lg:px-8 xl:px-10 2xl:px-12">


            {{-- ========================================================= --}}
            {{-- Summary Cards --}}
            {{-- ========================================================= --}}

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3">


                {{-- Employee --}}

                <div class="rounded-xl border border-stone-200 bg-white p-5 shadow-sm">

                    <p class="text-sm font-medium text-stone-500">
                        Employee
                    </p>

                    <p class="mt-2 text-xl font-bold text-stone-800">
                        {{ $employee->user->name ?? '-' }}
                    </p>

                    <p class="mt-1 text-xs text-stone-500">
                        {{ $employee->employee_code ?? '-' }}
                    </p>

                </div>


                {{-- Today's Distribution --}}

                <div class="rounded-xl border border-stone-200 bg-white p-5 shadow-sm">

                    <p class="text-sm font-medium text-stone-500">
                        Today's Distribution
                    </p>

                    <p class="mt-2 text-2xl font-bold text-stone-800">
                        {{ $todayDistribution ? 'Available' : 'None' }}
                    </p>

                    <p class="mt-1 text-xs text-stone-500">
                        Distribution for today
                    </p>

                </div>


                {{-- Today's Sales --}}

                <div class="rounded-xl border border-stone-200 bg-white p-5 shadow-sm">

                    <p class="text-sm font-medium text-stone-500">
                        Today's Sales
                    </p>

                    <p class="mt-2 text-2xl font-bold text-green-700">
                        Rp {{ number_format($todaySalesTotal, 0, ',', '.') }}
                    </p>

                    <p class="mt-1 text-xs text-stone-500">
                        Total sales recorded today
                    </p>

                </div>

            </div>


            {{-- ========================================================= --}}
            {{-- Today's Distribution --}}
            {{-- ========================================================= --}}

            <div class="mt-6 rounded-xl border border-stone-200 bg-white shadow-sm">


                <div class="border-b border-stone-200 px-5 py-4">

                    <h3 class="text-base font-semibold text-stone-800">
                        Today's Distribution
                    </h3>

                    <p class="mt-1 text-sm text-stone-500">
                        Products and operational items distributed to you today
                    </p>

                </div>


                @if ($todayDistribution)

                    {{-- Distribution Information --}}

                    <div class="grid grid-cols-1 gap-4 border-b border-stone-200 px-5 py-4 sm:grid-cols-3">

                        <div>

                            <p class="text-xs font-medium text-stone-500">
                                Date
                            </p>

                            <p class="mt-1 text-sm font-semibold text-stone-800">
                                {{ $todayDistribution->distribution_date->format('d M Y') }}
                            </p>

                        </div>


                        <div>

                            <p class="text-xs font-medium text-stone-500">
                                Cart
                            </p>

                            <p class="mt-1 text-sm font-semibold text-stone-800">
                                {{ $todayDistribution->assignment->cart->name ?? '-' }}
                            </p>

                        </div>


                        <div>

                            <p class="text-xs font-medium text-stone-500">
                                Region
                            </p>

                            <p class="mt-1 text-sm font-semibold text-stone-800">
                                {{ $todayDistribution->assignment->region->name ?? '-' }}
                            </p>

                        </div>

                    </div>


                    {{-- Distributed Items --}}

                    <div class="overflow-x-auto">

                        <table class="w-full min-w-[700px] text-left text-sm">

                            <thead class="border-b border-stone-200 bg-stone-50">

                                <tr>

                                    <th class="px-5 py-3 font-semibold text-stone-700">
                                        Item
                                    </th>

                                    <th class="px-5 py-3 font-semibold text-stone-700">
                                        Type
                                    </th>

                                    <th class="px-5 py-3 text-right font-semibold text-stone-700">
                                        Quantity
                                    </th>

                                </tr>

                            </thead>


                            <tbody class="divide-y divide-stone-200">


                                {{-- Base Drinks --}}

                                @forelse ($todayDistribution->productDetails as $detail)

                                    <tr class="hover:bg-stone-50">

                                        <td class="px-5 py-3 font-medium text-stone-800">
                                            {{ $detail->baseDrink->name ?? '-' }}
                                        </td>

                                        <td class="px-5 py-3 text-stone-600">
                                            Base Drink
                                        </td>

                                        <td class="px-5 py-3 text-right font-semibold text-stone-800">

                                            {{ rtrim(
                                                rtrim(
                                                    number_format(
                                                        $detail->quantity_distributed,
                                                        2,
                                                        ',',
                                                        '.'
                                                    ),
                                                    '0'
                                                ),
                                                ','
                                            ) }}

                                        </td>

                                    </tr>

                                @empty

                                @endforelse


                                {{-- Operational Items --}}

                                @foreach ($todayDistribution->operationalDetails as $detail)

                                    <tr class="hover:bg-stone-50">

                                        <td class="px-5 py-3 font-medium text-stone-800">
                                            {{ $detail->operationalItem->name ?? '-' }}
                                        </td>

                                        <td class="px-5 py-3 text-stone-600">
                                            Operational Item
                                        </td>

                                        <td class="px-5 py-3 text-right font-semibold text-stone-800">

                                            {{ rtrim(
                                                rtrim(
                                                    number_format(
                                                        $detail->quantity_distributed,
                                                        2,
                                                        ',',
                                                        '.'
                                                    ),
                                                    '0'
                                                ),
                                                ','
                                            ) }}

                                            {{ $detail->operationalItem->unit ?? '' }}

                                        </td>

                                    </tr>

                                @endforeach


                                {{-- Empty State --}}

                                @if (
                                    $todayDistribution->productDetails->isEmpty()
                                    &&
                                    $todayDistribution->operationalDetails->isEmpty()
                                )

                                    <tr>

                                        <td
                                            colspan="3"
                                            class="px-5 py-8 text-center text-sm text-stone-500"
                                        >
                                            No items recorded in today's distribution.
                                        </td>

                                    </tr>

                                @endif


                            </tbody>

                        </table>

                    </div>

                @else

                    <div class="px-5 py-10 text-center">

                        <p class="text-sm font-medium text-stone-600">
                            No distribution recorded today.
                        </p>

                        <p class="mt-1 text-xs text-stone-500">
                            Your distribution for today has not been recorded yet.
                        </p>

                    </div>

                @endif

            </div>


            {{-- ========================================================= --}}
            {{-- Today's Sales --}}
            {{-- ========================================================= --}}

            <div class="mt-6 rounded-xl border border-stone-200 bg-white shadow-sm">


                <div class="flex items-center justify-between border-b border-stone-200 px-5 py-4">

                    <div>

                        <h3 class="text-base font-semibold text-stone-800">
                            Today's Sales
                        </h3>

                        <p class="mt-1 text-sm text-stone-500">
                            Sales recorded from your distribution today
                        </p>

                    </div>


                    <div class="text-right">

                        <p class="text-xs text-stone-500">
                            Total Revenue
                        </p>

                        <p class="mt-1 text-base font-bold text-green-700">
                            Rp {{ number_format($todaySalesTotal, 0, ',', '.') }}
                        </p>

                    </div>

                </div>


                <div class="overflow-x-auto">

                    <table class="w-full min-w-[800px] text-left text-sm">

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
                                    Unit Price
                                </th>

                                <th class="px-5 py-3 text-right font-semibold text-stone-700">
                                    Subtotal
                                </th>

                            </tr>

                        </thead>


                        <tbody class="divide-y divide-stone-200">

                            @forelse ($todaySales as $sale)

                                @foreach ($sale->details as $detail)

                                    <tr class="hover:bg-stone-50">

                                        <td class="whitespace-nowrap px-5 py-3 text-stone-600">

                                            {{ $sale->sale_date->format('d M Y') }}

                                        </td>


                                        <td class="px-5 py-3 font-medium text-stone-800">

                                            {{ $detail->product->name ?? '-' }}

                                        </td>


                                        <td class="px-5 py-3 text-right text-stone-600">

                                            {{ number_format(
                                                $detail->quantity,
                                                0,
                                                ',',
                                                '.'
                                            ) }}

                                        </td>


                                        <td class="px-5 py-3 text-right text-stone-600">

                                            Rp {{ number_format(
                                                $detail->product->price ?? 0,
                                                0,
                                                ',',
                                                '.'
                                            ) }}

                                        </td>


                                        <td class="px-5 py-3 text-right font-semibold text-stone-800">

                                            Rp {{ number_format(
                                                $detail->subtotal,
                                                0,
                                                ',',
                                                '.'
                                            ) }}

                                        </td>

                                    </tr>

                                @endforeach

                            @empty

                                <tr>

                                    <td
                                        colspan="5"
                                        class="px-5 py-10 text-center text-sm text-stone-500"
                                    >
                                        No sales recorded today.
                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>


            {{-- ========================================================= --}}
            {{-- Recent Distributions --}}
            {{-- ========================================================= --}}

            <div class="mt-6 rounded-xl border border-stone-200 bg-white shadow-sm">


                <div class="border-b border-stone-200 px-5 py-4">

                    <h3 class="text-base font-semibold text-stone-800">
                        Recent Distributions
                    </h3>

                    <p class="mt-1 text-sm text-stone-500">
                        Your latest distribution history
                    </p>

                </div>


                <div class="overflow-x-auto">

                    <table class="w-full min-w-[850px] text-left text-sm">

                        <thead class="border-b border-stone-200 bg-stone-50">

                            <tr>

                                <th class="px-5 py-3 font-semibold text-stone-700">
                                    Date
                                </th>

                                <th class="px-5 py-3 font-semibold text-stone-700">
                                    Cart
                                </th>

                                <th class="px-5 py-3 font-semibold text-stone-700">
                                    Region
                                </th>

                                <th class="px-5 py-3 font-semibold text-stone-700">
                                    Products
                                </th>

                            </tr>

                        </thead>


                        <tbody class="divide-y divide-stone-200">

                            @forelse ($recentDistributions as $distribution)

                                <tr class="hover:bg-stone-50">

                                    <td class="whitespace-nowrap px-5 py-3 text-stone-600">

                                        {{ $distribution->distribution_date->format('d M Y') }}

                                    </td>


                                    <td class="px-5 py-3 text-stone-600">

                                        {{ $distribution->assignment->cart->name ?? '-' }}

                                    </td>


                                    <td class="px-5 py-3 text-stone-600">

                                        {{ $distribution->assignment->region->name ?? '-' }}

                                    </td>


                                    <td class="px-5 py-3 text-stone-600">

                                        @if ($distribution->productDetails->isNotEmpty())

                                            <div class="space-y-1">

                                                @foreach ($distribution->productDetails as $detail)

                                                    <div>

                                                        <span class="font-medium text-stone-800">
                                                            {{ $detail->baseDrink->name ?? '-' }}
                                                        </span>

                                                        <span class="text-stone-500">

                                                            (
                                                            {{ rtrim(
                                                                rtrim(
                                                                    number_format(
                                                                        $detail->quantity_distributed,
                                                                        2,
                                                                        ',',
                                                                        '.'
                                                                    ),
                                                                    '0'
                                                                ),
                                                                ','
                                                            ) }}
                                                            )

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

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="4"
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


            {{-- ========================================================= --}}
            {{-- Recent Sales --}}
            {{-- ========================================================= --}}

            <div class="mt-6 rounded-xl border border-stone-200 bg-white shadow-sm">


                <div class="border-b border-stone-200 px-5 py-4">

                    <h3 class="text-base font-semibold text-stone-800">
                        Recent Sales
                    </h3>

                    <p class="mt-1 text-sm text-stone-500">
                        Your latest sales records
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

                            @forelse ($recentSales as $sale)

                                @foreach ($sale->details as $detail)

                                    <tr class="hover:bg-stone-50">

                                        <td class="whitespace-nowrap px-5 py-3 text-stone-600">

                                            {{ $sale->sale_date->format('d M Y') }}

                                        </td>


                                        <td class="px-5 py-3 font-medium text-stone-800">

                                            {{ $detail->product->name ?? '-' }}

                                        </td>


                                        <td class="px-5 py-3 text-right text-stone-600">

                                            {{ number_format(
                                                $detail->quantity,
                                                0,
                                                ',',
                                                '.'
                                            ) }}

                                        </td>


                                        <td class="whitespace-nowrap px-5 py-3 text-right font-semibold text-stone-800">

                                            Rp {{ number_format(
                                                $detail->subtotal,
                                                0,
                                                ',',
                                                '.'
                                            ) }}

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
