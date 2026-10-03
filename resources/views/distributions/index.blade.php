<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-stone-900">
                    Distributions
                </h2>

                <p class="mt-1 text-sm text-stone-500">
                    Manage product and operational item distributions.
                </p>
            </div>

            <a
                href="{{ route('distributions.create') }}"
                class="rounded-lg bg-amber-700 px-4 py-2 text-sm
                       font-semibold text-white hover:bg-amber-800"
            >
                Add Distribution
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- Success Notification --}}
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

            {{-- Error Notification --}}
            @if ($errors->has('distribution'))
                <div
                    class="mb-4 rounded-xl border border-red-200
                           bg-red-50 px-4 py-3 text-sm font-medium
                           text-red-700"
                >
                    {{ $errors->first('distribution') }}
                </div>
            @endif

            {{-- Distribution List --}}
            <div class="space-y-4">

                @forelse ($distributions as $distribution)

                    <x-app-card>

                        <div class="flex flex-col gap-4">

                            {{-- Header --}}
                            <div
                                class="flex flex-col gap-3
                                       sm:flex-row sm:items-start
                                       sm:justify-between"
                            >

                                <div class="min-w-0">

                                    <h3 class="text-base font-bold text-stone-900">
                                        {{ $distribution->employee->user->name }}
                                    </h3>

                                    <p class="mt-1 text-sm text-stone-500">
                                        Employee Code:
                                        {{ $distribution->employee->employee_code }}
                                    </p>

                                    <p class="mt-1 text-sm text-stone-500">
                                        Date:
                                        {{ $distribution->distribution_date->format('d M Y') }}
                                    </p>

                                </div>

                                {{-- Actions --}}
                                <div class="flex shrink-0 items-center gap-2">

                                    <a
                                        href="{{ route('distributions.show', $distribution) }}"
                                        class="rounded-lg bg-stone-100 px-3 py-2
                                               text-xs font-semibold text-stone-700
                                               hover:bg-stone-200"
                                    >
                                        View
                                    </a>

                                    <a
                                        href="{{ route('distributions.edit', $distribution) }}"
                                        class="rounded-lg bg-amber-50 px-3 py-2
                                               text-xs font-semibold text-amber-700
                                               hover:bg-amber-100"
                                    >
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('distributions.destroy', $distribution) }}"
                                        method="POST"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            onclick="return confirm('Are you sure you want to delete this distribution?')"
                                            class="rounded-lg bg-red-50 px-3 py-2
                                                   text-xs font-semibold text-red-600
                                                   hover:bg-red-100"
                                        >
                                            Delete
                                        </button>
                                    </form>

                                </div>

                            </div>

                            {{-- Assignment Information --}}
                            @php
                                $assignment = $distribution->employee
                                    ->assignments
                                    ->where('status', 'active')
                                    ->first();
                            @endphp

                            @if ($assignment)
                                <div
                                    class="rounded-lg bg-stone-50 px-4 py-3
                                           text-sm text-stone-600"
                                >
                                    <div class="flex flex-col gap-1 sm:flex-row sm:gap-6">
                                        <span>
                                            <span class="font-semibold text-stone-700">
                                                Cart:
                                            </span>
                                            {{ $assignment->cart->name ?? '-' }}
                                        </span>

                                        <span>
                                            <span class="font-semibold text-stone-700">
                                                Region:
                                            </span>
                                            {{ $assignment->region->name ?? '-' }}
                                        </span>
                                    </div>
                                </div>
                            @endif

                            {{-- Base Drinks --}}
                            <div>

                                <h4 class="text-sm font-semibold text-stone-800">
                                    Base Drinks
                                </h4>

                                @if ($distribution->productDetails->isNotEmpty())

                                    <div class="mt-2 overflow-hidden rounded-lg border border-stone-200">

                                        <div
                                            class="grid grid-cols-3
                                                   bg-stone-50 px-3 py-2
                                                   text-xs font-semibold
                                                   text-stone-600"
                                        >
                                            <span>Item</span>
                                            <span class="text-center">
                                                Distributed
                                            </span>
                                            <span class="text-right">
                                                Returned
                                            </span>
                                        </div>

                                        @foreach ($distribution->productDetails as $detail)

                                            <div
                                                class="grid grid-cols-3
                                                       border-t border-stone-200
                                                       px-3 py-2 text-sm"
                                            >

                                                <span class="text-stone-700">
                                                    {{ $detail->baseDrink->name ?? '-' }}
                                                </span>

                                                <span class="text-center text-stone-600">
                                                    {{ $detail->quantity_distributed }}
                                                </span>

                                                <span class="text-right text-stone-600">
                                                    {{ $detail->quantity_returned }}
                                                </span>

                                            </div>

                                        @endforeach

                                    </div>

                                @else

                                    <p class="mt-2 text-sm text-stone-500">
                                        No base drinks distributed.
                                    </p>

                                @endif

                            </div>

                            {{-- Operational Items --}}
                            <div>

                                <h4 class="text-sm font-semibold text-stone-800">
                                    Operational Items
                                </h4>

                                @if ($distribution->operationalDetails->isNotEmpty())

                                    <div class="mt-2 overflow-hidden rounded-lg border border-stone-200">

                                        <div
                                            class="grid grid-cols-3
                                                   bg-stone-50 px-3 py-2
                                                   text-xs font-semibold
                                                   text-stone-600"
                                        >
                                            <span>Item</span>
                                            <span class="text-center">
                                                Distributed
                                            </span>
                                            <span class="text-right">
                                                Returned
                                            </span>
                                        </div>

                                        @foreach ($distribution->operationalDetails as $detail)

                                            <div
                                                class="grid grid-cols-3
                                                       border-t border-stone-200
                                                       px-3 py-2 text-sm"
                                            >

                                                <span class="text-stone-700">
                                                    {{ $detail->operationalItem->name ?? '-' }}
                                                </span>

                                                <span class="text-center text-stone-600">
                                                    {{ $detail->quantity_distributed }}
                                                </span>

                                                <span class="text-right text-stone-600">
                                                    {{ $detail->quantity_returned }}
                                                </span>

                                            </div>

                                        @endforeach

                                    </div>

                                @else

                                    <p class="mt-2 text-sm text-stone-500">
                                        No operational items distributed.
                                    </p>

                                @endif

                            </div>

                            {{-- Notes --}}
                            @if ($distribution->notes)

                                <div>
                                    <h4 class="text-sm font-semibold text-stone-800">
                                        Notes
                                    </h4>

                                    <p class="mt-1 text-sm text-stone-600">
                                        {{ $distribution->notes }}
                                    </p>
                                </div>

                            @endif

                        </div>

                    </x-app-card>

                @empty

                    <x-app-card>

                        <div class="py-8 text-center">

                            <p class="text-sm font-medium text-stone-700">
                                No distributions found.
                            </p>

                            <p class="mt-1 text-sm text-stone-500">
                                Create a distribution to get started.
                            </p>

                        </div>

                    </x-app-card>

                @endforelse

            </div>

        </div>
    </div>

    <script>
        setTimeout(() => {
            const notification =
                document.getElementById('success-notification');

            if (notification) {
                notification.remove();
            }
        }, 3000);
    </script>
</x-app-layout>
