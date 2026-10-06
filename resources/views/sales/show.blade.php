<x-app-layout>

    <x-slot name="header">

        <div>
            <h2 class="text-xl font-bold text-stone-900">
                Sale Details
            </h2>

            <p class="mt-1 text-sm text-stone-500">
                View recorded sale information and products.
            </p>
        </div>

    </x-slot>


    <div class="py-6">

        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">

            <div class="space-y-6">


                {{-- ========================================================= --}}
                {{-- Sale Information --}}
                {{-- ========================================================= --}}

                <x-app-card>

                    <div
                        class="flex flex-col gap-4
                               sm:flex-row sm:items-start
                               sm:justify-between"
                    >

                        <div>

                            <div class="flex items-center gap-2">

                                <span
                                    class="rounded-full px-2.5 py-1
                                           text-xs font-semibold
                                           {{ $sale->sale_source === 'Employee'
                                                ? 'bg-blue-50 text-blue-700'
                                                : 'bg-green-50 text-green-700' }}"
                                >
                                    {{ $sale->sale_source }}
                                </span>

                            </div>


                            @if ($sale->sale_source === 'Employee')

                                <h3
                                    class="mt-3 text-lg font-bold
                                           text-stone-900"
                                >
                                    {{ $sale->distribution?->assignment?->employee?->user?->name ?? '-' }}
                                </h3>

                                <p class="mt-1 text-sm text-stone-500">

                                    Employee Code:

                                    {{ $sale->distribution?->assignment?->employee?->employee_code ?? '-' }}

                                </p>

                            @else

                                <h3
                                    class="mt-3 text-lg font-bold
                                           text-stone-900"
                                >
                                    Outlet Sale
                                </h3>

                            @endif

                        </div>


                        {{-- Actions --}}

                        <div class="flex items-center gap-2">

                            <a
                                href="{{ route('sales.edit', $sale) }}"
                                class="rounded-lg bg-amber-50 px-3 py-2
                                       text-xs font-semibold text-amber-700
                                       hover:bg-amber-100"
                            >
                                Edit
                            </a>

                            <a
                                href="{{ route('sales.index') }}"
                                class="rounded-lg bg-stone-100 px-3 py-2
                                       text-xs font-semibold text-stone-700
                                       hover:bg-stone-200"
                            >
                                Back
                            </a>

                        </div>

                    </div>


                    {{-- ===================================================== --}}
                    {{-- Information --}}
                    {{-- ===================================================== --}}

                    <div
                        class="mt-6 grid gap-4
                               sm:grid-cols-2"
                    >

                        {{-- Sale Date --}}

                        <div
                            class="rounded-lg bg-stone-50
                                   px-4 py-3"
                        >

                            <p
                                class="text-xs font-semibold
                                       text-stone-500"
                            >
                                Sale Date
                            </p>

                            <p
                                class="mt-1 text-sm font-semibold
                                       text-stone-800"
                            >
                                {{ $sale->sale_date?->format('d M Y') ?? '-' }}
                            </p>

                        </div>


                        {{-- Distribution Date --}}

                        @if ($sale->sale_source === 'Employee')

                            <div
                                class="rounded-lg bg-stone-50
                                       px-4 py-3"
                            >

                                <p
                                    class="text-xs font-semibold
                                           text-stone-500"
                                >
                                    Distribution Date
                                </p>

                                <p
                                    class="mt-1 text-sm font-semibold
                                           text-stone-800"
                                >
                                    {{ $sale->distribution?->distribution_date?->format('d M Y') ?? '-' }}
                                </p>

                            </div>

                        @endif


                        {{-- Distribution ID --}}

                        @if ($sale->sale_source === 'Employee')

                            <div
                                class="rounded-lg bg-stone-50
                                       px-4 py-3"
                            >

                                <p
                                    class="text-xs font-semibold
                                           text-stone-500"
                                >
                                    Distribution
                                </p>

                                <p
                                    class="mt-1 text-sm font-semibold
                                           text-stone-800"
                                >
                                    #{{ $sale->distribution_id }}
                                </p>

                            </div>

                        @endif

                    </div>

                </x-app-card>


                {{-- ========================================================= --}}
                {{-- Products --}}
                {{-- ========================================================= --}}

                <x-app-card>

                    <div>

                        <h3
                            class="text-base font-bold
                                   text-stone-900"
                        >
                            Products
                        </h3>

                        <p
                            class="mt-1 text-sm text-stone-500"
                        >
                            Products recorded in this sale.
                        </p>

                    </div>


                    @if ($sale->details->isNotEmpty())

                        <div
                            class="mt-5 overflow-hidden
                                   rounded-lg border border-stone-200"
                        >

                            {{-- Header --}}

                            <div
                                class="grid grid-cols-4
                                       bg-stone-50 px-4 py-3
                                       text-xs font-semibold
                                       text-stone-600"
                            >

                                <span>
                                    Product
                                </span>

                                <span class="text-center">
                                    Quantity
                                </span>

                                <span class="text-right">
                                    Unit Price
                                </span>

                                <span class="text-right">
                                    Subtotal
                                </span>

                            </div>


                            {{-- Details --}}

                            @foreach ($sale->details as $detail)

                                <div
                                    class="grid grid-cols-4
                                           border-t border-stone-200
                                           px-4 py-3 text-sm"
                                >

                                    {{-- Product --}}

                                    <span
                                        class="font-medium
                                               text-stone-700"
                                    >
                                        {{ $detail->product?->name ?? '-' }}
                                    </span>


                                    {{-- Quantity --}}

                                    <span
                                        class="text-center
                                               text-stone-600"
                                    >
                                        {{ $detail->quantity }}
                                    </span>


                                    {{-- Unit Price --}}

                                    <span
                                        class="text-right
                                               text-stone-600"
                                    >
                                        Rp
                                        {{ number_format(
                                            $detail->product->price,
                                            0,
                                            ',',
                                            '.'
                                        ) }}
                                    </span>


                                    {{-- Subtotal --}}

                                    <span
                                        class="text-right
                                               font-medium
                                               text-stone-700"
                                    >
                                        Rp
                                        {{ number_format(
                                            $detail->subtotal,
                                            0,
                                            ',',
                                            '.'
                                        ) }}
                                    </span>

                                </div>

                            @endforeach

                        </div>


                        {{-- ================================================= --}}
                        {{-- Total --}}
                        {{-- ================================================= --}}

                        <div
                            class="mt-4 flex items-center
                                   justify-between rounded-lg
                                   bg-stone-50 px-4 py-4"
                        >

                            <span
                                class="text-sm font-semibold
                                       text-stone-700"
                            >
                                Total Sales
                            </span>


                            <span
                                class="text-lg font-bold
                                       text-stone-900"
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

                    @else

                        <div
                            class="mt-5 rounded-lg border
                                   border-dashed border-stone-300
                                   px-4 py-8 text-center"
                        >

                            <p
                                class="text-sm font-medium
                                       text-stone-600"
                            >
                                No products recorded.
                            </p>

                        </div>

                    @endif

                </x-app-card>


                {{-- ========================================================= --}}
                {{-- Notes --}}
                {{-- ========================================================= --}}

                @if ($sale->notes)

                    <x-app-card>

                        <div>

                            <h3
                                class="text-base font-bold
                                       text-stone-900"
                            >
                                Notes
                            </h3>

                            <p
                                class="mt-2 text-sm leading-6
                                       text-stone-600"
                            >
                                {{ $sale->notes }}
                            </p>

                        </div>

                    </x-app-card>

                @endif


                {{-- ========================================================= --}}
                {{-- Bottom Actions --}}
                {{-- ========================================================= --}}

                <div
                    class="flex items-center
                           justify-end gap-3"
                >

                    <a
                        href="{{ route('sales.index') }}"
                        class="rounded-lg bg-stone-100 px-4 py-2
                               text-sm font-semibold text-stone-700
                               hover:bg-stone-200"
                    >
                        Back to Sales
                    </a>

                    <a
                        href="{{ route('sales.edit', $sale) }}"
                        class="rounded-lg bg-amber-700 px-4 py-2
                               text-sm font-semibold text-white
                               hover:bg-amber-800"
                    >
                        Edit Sale
                    </a>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>
