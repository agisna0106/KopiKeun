<x-app-layout>

    <x-slot name="header">

        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <h2 class="text-xl font-bold text-stone-900">
                    Sales
                </h2>

                <p class="mt-1 text-sm text-stone-500">
                    Manage recorded sales from employees and outlets.
                </p>
            </div>

            <a
                href="{{ route('sales.create') }}"
                class="rounded-lg bg-amber-700 px-4 py-2
                       text-sm font-semibold text-white
                       hover:bg-amber-800"
            >
                Add Sale
            </a>

        </div>

    </x-slot>


    <div class="py-6">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- ========================================================= --}}
            {{-- Success Notification --}}
            {{-- ========================================================= --}}

            @if (session('success'))

                <div
                    id="success-notification"
                    class="mb-4 rounded-xl border border-green-200
                           bg-green-50 px-4 py-3 text-sm font-medium
                           text-green-700"
                >
                    {{ session('success') }}
                </div>

            @endif


            {{-- ========================================================= --}}
            {{-- Error Notification --}}
            {{-- ========================================================= --}}

            @if ($errors->any())

                <div
                    class="mb-4 rounded-xl border border-red-200
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


            {{-- ========================================================= --}}
            {{-- Sales List --}}
            {{-- ========================================================= --}}

            <div class="space-y-4">

                @forelse ($sales as $sale)

                    <x-app-card>

                        <div class="flex flex-col gap-5">


                            {{-- ================================================= --}}
                            {{-- Sale Header --}}
                            {{-- ================================================= --}}

                            <div
                                class="flex flex-col gap-4
                                       sm:flex-row sm:items-start
                                       sm:justify-between"
                            >

                                <div class="min-w-0">

                                    {{-- Sale Source --}}
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


                                    {{-- Employee / Distribution --}}
                                    @if ($sale->sale_source === 'Employee')

                                        <h3
                                            class="mt-2 text-base font-bold
                                                   text-stone-900"
                                        >
                                            {{ $sale->distribution?->assignment?->employee?->user?->name ?? '-' }}
                                        </h3>

                                        <p class="mt-1 text-sm text-stone-500">

                                            Employee Code:

                                            {{ $sale->distribution?->assignment?->employee?->employee_code ?? '-' }}

                                        </p>

                                        <p class="mt-1 text-sm text-stone-500">

                                            Distribution Date:

                                            {{ $sale->distribution?->distribution_date?->format('d M Y') ?? '-' }}

                                        </p>

                                    @else

                                        <h3
                                            class="mt-2 text-base font-bold
                                                   text-stone-900"
                                        >
                                            Outlet Sale
                                        </h3>

                                    @endif


                                    {{-- Sale Date --}}
                                    <p class="mt-1 text-sm text-stone-500">

                                        Sale Date:

                                        {{ $sale->sale_date?->format('d M Y') ?? '-' }}

                                    </p>

                                </div>


                                {{-- ================================================= --}}
                                {{-- Actions --}}
                                {{-- ================================================= --}}

                                <div
                                    class="flex shrink-0 items-center gap-2"
                                >

                                    <a
                                        href="{{ route('sales.show', $sale) }}"
                                        class="rounded-lg bg-stone-100 px-3 py-2
                                               text-xs font-semibold text-stone-700
                                               hover:bg-stone-200"
                                    >
                                        View
                                    </a>

                                    <a
                                        href="{{ route('sales.edit', $sale) }}"
                                        class="rounded-lg bg-amber-50 px-3 py-2
                                               text-xs font-semibold text-amber-700
                                               hover:bg-amber-100"
                                    >
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('sales.destroy', $sale) }}"
                                        method="POST"
                                    >

                                        @csrf

                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            onclick="return confirm('Are you sure you want to delete this sale?')"
                                            class="rounded-lg bg-red-50 px-3 py-2
                                                   text-xs font-semibold text-red-600
                                                   hover:bg-red-100"
                                        >
                                            Delete
                                        </button>

                                    </form>

                                </div>

                            </div>


                            {{-- ================================================= --}}
                            {{-- Products --}}
                            {{-- ================================================= --}}

                            <div>

                                <h4
                                    class="text-sm font-semibold
                                           text-stone-800"
                                >
                                    Products
                                </h4>


                                @if ($sale->details->isNotEmpty())

                                    <div
                                        class="mt-2 overflow-hidden
                                               rounded-lg border border-stone-200"
                                    >

                                        {{-- Table Header --}}
                                        <div
                                            class="grid grid-cols-3
                                                   bg-stone-50 px-3 py-2
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
                                                Subtotal
                                            </span>

                                        </div>


                                        {{-- Product Rows --}}
                                        @foreach ($sale->details as $detail)

                                            <div
                                                class="grid grid-cols-3
                                                       border-t border-stone-200
                                                       px-3 py-2 text-sm"
                                            >

                                                <span class="text-stone-700">

                                                    {{ $detail->product?->name ?? '-' }}

                                                </span>


                                                <span
                                                    class="text-center
                                                           text-stone-600"
                                                >

                                                    {{ $detail->quantity }}

                                                </span>


                                                <span
                                                    class="text-right
                                                           text-stone-600"
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
                                        class="mt-3 flex items-center
                                               justify-between
                                               rounded-lg bg-stone-50
                                               px-4 py-3"
                                    >

                                        <span
                                            class="text-sm font-semibold
                                                   text-stone-700"
                                        >
                                            Total Sales
                                        </span>


                                        <span
                                            class="text-base font-bold
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

                                    <p class="mt-2 text-sm text-stone-500">
                                        No products recorded.
                                    </p>

                                @endif

                            </div>


                            {{-- ================================================= --}}
                            {{-- Notes --}}
                            {{-- ================================================= --}}

                            @if ($sale->notes)

                                <div>

                                    <h4
                                        class="text-sm font-semibold
                                               text-stone-800"
                                    >
                                        Notes
                                    </h4>

                                    <p
                                        class="mt-1 text-sm text-stone-600"
                                    >
                                        {{ $sale->notes }}
                                    </p>

                                </div>

                            @endif


                        </div>

                    </x-app-card>

                @empty

                    {{-- ================================================= --}}
                    {{-- Empty State --}}
                    {{-- ================================================= --}}

                    <x-app-card>

                        <div class="py-8 text-center">

                            <p
                                class="text-sm font-medium
                                       text-stone-700"
                            >
                                No sales found.
                            </p>

                            <p
                                class="mt-1 text-sm text-stone-500"
                            >
                                Record a sale to get started.
                            </p>

                        </div>

                    </x-app-card>

                @endforelse

            </div>

        </div>

    </div>


    {{-- ============================================================= --}}
    {{-- Notification Script --}}
    {{-- ============================================================= --}}

    <script>

        setTimeout(() => {

            const notification =
                document.getElementById(
                    'success-notification'
                );

            if (notification) {
                notification.remove();
            }

        }, 3000);

    </script>

</x-app-layout>
