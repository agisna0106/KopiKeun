<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Remaining Product Details
            </h2>

            <div class="flex items-center gap-2">
                <a
                    href="{{ route('remaining-products.edit', $remainingProduct) }}"
                    class="rounded-md px-4 py-2 text-sm font-semibold text-white shadow-sm hover:opacity-90"
                    style="background-color: #ea580c;"
                >
                    Edit
                </a>

                <a
                    href="{{ route('remaining-products.index') }}"
                    class="rounded-md border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
                >
                    Back
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto w-full max-w-5xl px-4 sm:px-6 lg:px-8">

            {{-- General Information --}}
            <div class="mb-6 rounded-xl bg-white p-6 shadow-sm">
                <h3 class="mb-5 text-lg font-semibold text-gray-800">
                    Remaining Product Information
                </h3>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                    <div>
                        <p class="text-sm font-medium text-gray-500">
                            Recorded Date
                        </p>

                        <p class="mt-1 text-base font-semibold text-gray-800">
                            {{ $remainingProduct->recorded_at->format('d M Y') }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-gray-500">
                            Total Estimated Servings
                        </p>

                        <p class="mt-1 text-base font-semibold text-gray-800">
                            {{ number_format($remainingProduct->details->sum('quantity'), 0, ',', '.') }}
                            servings
                        </p>
                    </div>

                    <div class="md:col-span-2">
                        <p class="text-sm font-medium text-gray-500">
                            Notes
                        </p>

                        <p class="mt-1 text-base text-gray-800">
                            {{ $remainingProduct->notes ?: '-' }}
                        </p>
                    </div>

                </div>
            </div>

            {{-- Base Drinks --}}
            <div class="overflow-hidden rounded-xl bg-white shadow-sm">

                <div class="border-b border-gray-200 px-6 py-4">
                    <h3 class="text-lg font-semibold text-gray-800">
                        Remaining Base Drinks
                    </h3>

                    <p class="mt-1 text-sm text-gray-500">
                        Estimated remaining servings and informational volume.
                    </p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">

                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                    Base Drink
                                </th>

                                <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-600">
                                    Remaining Servings
                                </th>

                                <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-600">
                                    Standard Serving
                                </th>

                                <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-600">
                                    Estimated Volume
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200 bg-white">

                            @foreach ($remainingProduct->details as $detail)

                                @php
                                    $estimatedVolume =
                                        $detail->quantity *
                                        $detail->baseDrink->standard_serving_ml;
                                @endphp

                                <tr class="hover:bg-gray-50">

                                    <td class="px-6 py-4 text-sm font-medium text-gray-800">
                                        {{ $detail->baseDrink->name }}
                                    </td>

                                    <td class="whitespace-nowrap px-6 py-4 text-right text-sm text-gray-800">
                                        {{ number_format($detail->quantity, 0, ',', '.') }}
                                        servings
                                    </td>

                                    <td class="whitespace-nowrap px-6 py-4 text-right text-sm text-gray-600">
                                        {{ number_format($detail->baseDrink->standard_serving_ml, 0, ',', '.') }}
                                        ml
                                    </td>

                                    <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium text-gray-800">
                                        {{ number_format($estimatedVolume, 0, ',', '.') }}
                                        ml
                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                        <tfoot class="border-t border-gray-200 bg-gray-50">

                            @php
                                $totalQuantity = $remainingProduct->details->sum('quantity');

                                $totalEstimatedVolume = $remainingProduct->details->sum(
                                    function ($detail) {
                                        return $detail->quantity *
                                            $detail->baseDrink->standard_serving_ml;
                                    }
                                );
                            @endphp

                            <tr>
                                <td class="px-6 py-4 text-sm font-semibold text-gray-800">
                                    Total
                                </td>

                                <td class="px-6 py-4 text-right text-sm font-bold text-gray-800">
                                    {{ number_format($totalQuantity, 0, ',', '.') }}
                                    servings
                                </td>

                                <td class="px-6 py-4 text-right text-sm text-gray-500">
                                    -
                                </td>

                                <td class="px-6 py-4 text-right text-sm font-bold text-gray-800">
                                    {{ number_format($totalEstimatedVolume, 0, ',', '.') }}
                                    ml
                                </td>
                            </tr>

                        </tfoot>

                    </table>
                </div>
            </div>

            {{-- Information Note --}}
            <div class="mt-6 rounded-lg border border-orange-200 bg-orange-50 p-4">
                <p class="text-sm leading-6 text-gray-700">
                    Estimated volume is calculated from the remaining servings
                    multiplied by the standard serving size. This value is
                    informational and does not represent official inventory.
                </p>
            </div>

        </div>
    </div>
</x-app-layout>
