<x-app-layout>
    <x-slot name="header">
        <div class="flex w-full items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Remaining Products
            </h2>

            <a
                href="{{ route('remaining-products.create') }}"
                class="inline-flex items-center rounded-md px-4 py-2 text-sm font-semibold text-white shadow-sm hover:opacity-90"
                style="background-color: #ea580c;"
            >
                Add Remaining Product
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto w-full max-w-6xl px-4 sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-hidden rounded-xl bg-white shadow-sm">
                <div class="border-b border-gray-200 px-6 py-4">
                    <h3 class="text-lg font-semibold text-gray-800">
                        Remaining Product Records
                    </h3>

                    <p class="mt-1 text-sm text-gray-500">
                        Operational records of estimated remaining drink servings.
                    </p>
                </div>

                @if ($remainingProducts->isEmpty())
                    <div class="px-6 py-12 text-center">
                        <p class="text-sm text-gray-500">
                            No remaining product records found.
                        </p>

                        <a
                            href="{{ route('remaining-products.create') }}"
                            class="mt-4 inline-flex items-center rounded-md px-4 py-2 text-sm font-semibold text-white shadow-sm hover:opacity-90"
                            style="background-color: #ea580c;"
                        >
                            Add Remaining Product
                        </a>
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
                                        Base Drinks
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                        Total Servings
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                        Notes
                                    </th>

                                    <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-600">
                                        Actions
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200 bg-white">
                                @foreach ($remainingProducts as $remainingProduct)
                                    @php
                                        $totalQuantity = $remainingProduct->details->sum('quantity');
                                    @endphp

                                    <tr class="hover:bg-gray-50">
                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-800">
                                            {{ $remainingProduct->recorded_at->format('d M Y') }}
                                        </td>

                                        <td class="px-6 py-4">
                                            <div class="space-y-1">
                                                @foreach ($remainingProduct->details as $detail)
                                                    <div class="text-sm text-gray-800">
                                                        {{ $detail->baseDrink->name }}
                                                        <span class="text-gray-500">
                                                            ({{ number_format($detail->quantity, 0, ',', '.') }} servings)
                                                        </span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </td>

                                        <td class="whitespace-nowrap px-6 py-4 text-sm font-semibold text-gray-800">
                                            {{ number_format($totalQuantity, 0, ',', '.') }}
                                            servings
                                        </td>

                                        <td class="px-6 py-4 text-sm text-gray-600">
                                            {{ $remainingProduct->notes ?: '-' }}
                                        </td>

                                        <td class="whitespace-nowrap px-6 py-4 text-right text-sm">
                                            <div class="flex justify-end gap-2">
                                                <a
                                                    href="{{ route('remaining-products.show', $remainingProduct) }}"
                                                    class="rounded-md border border-gray-300 px-3 py-2 font-medium text-gray-700 hover:bg-gray-50"
                                                >
                                                    View
                                                </a>

                                                <a
                                                    href="{{ route('remaining-products.edit', $remainingProduct) }}"
                                                    class="rounded-md border border-gray-300 px-3 py-2 font-medium text-gray-700 hover:bg-gray-50"
                                                >
                                                    Edit
                                                </a>

                                                <form
                                                    action="{{ route('remaining-products.destroy', $remainingProduct) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Are you sure you want to delete this record?');"
                                                >
                                                    @csrf
                                                    @method('DELETE')

                                                    <button
                                                        type="submit"
                                                        class="rounded-md border border-red-300 px-3 py-2 font-medium text-red-600 hover:bg-red-50"
                                                    >
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
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
