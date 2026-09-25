<x-app-layout>
    <x-slot name="header">
        <div class="flex w-full items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Distribution Details
            </h2>

            <div class="flex gap-2">
                <a
                    href="{{ route('distributions.edit', $distribution) }}"
                    class="inline-flex items-center rounded-md px-4 py-2 text-sm font-semibold text-white"
                    style="background-color: #2563eb;"
                >
                    Edit
                </a>

                <a
                    href="{{ route('distributions.index') }}"
                    class="inline-flex items-center rounded-md bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-300"
                >
                    Back
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto w-full max-w-5xl px-4 sm:px-6 lg:px-8">

            {{-- Distribution Information --}}
            <div class="mb-6 rounded-lg bg-white p-6 shadow-sm">

                <h3 class="mb-4 text-lg font-semibold text-gray-800">
                    Distribution Information
                </h3>

                <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

                    <div>
                        <p class="text-sm text-gray-500">
                            Employee
                        </p>

                        <p class="mt-1 font-medium text-gray-900">
                            {{ $distribution->employee->user->name }}
                        </p>

                        <p class="text-sm text-gray-500">
                            {{ $distribution->employee->employee_code }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">
                            Distribution Date
                        </p>

                        <p class="mt-1 font-medium text-gray-900">
                            {{ $distribution->distribution_date->format('d/m/Y') }}
                        </p>
                    </div>

                    <div class="md:col-span-2">
                        <p class="text-sm text-gray-500">
                            Notes
                        </p>

                        <p class="mt-1 font-medium text-gray-900">
                            {{ $distribution->notes ?: '-' }}
                        </p>
                    </div>

                </div>
            </div>

            {{-- Distribution Details --}}
            <div class="overflow-hidden rounded-lg bg-white shadow-sm">

                <div class="border-b border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-800">
                        Distributed Base Drinks
                    </h3>
                </div>

                <div class="overflow-x-auto">

                    <table class="w-full divide-y divide-gray-200">

                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    Base Drink
                                </th>

                                <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    Estimated Servings
                                </th>

                                <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    Standard Serving
                                </th>

                                <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    Estimated Volume
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200 bg-white">

                            @forelse ($distribution->details as $detail)

                                <tr>

                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                        {{ $detail->baseDrink->name }}
                                    </td>

                                    <td class="px-6 py-4 text-right text-sm text-gray-700">
                                        {{ number_format($detail->quantity, 2, ',', '.') }}
                                    </td>

                                    <td class="px-6 py-4 text-right text-sm text-gray-700">
                                        {{ number_format($detail->baseDrink->standard_serving_ml, 0, ',', '.') }}
                                        ml
                                    </td>

                                    <td class="px-6 py-4 text-right text-sm text-gray-700">
                                        {{ number_format(
                                            $detail->quantity * $detail->baseDrink->standard_serving_ml,
                                            0,
                                            ',',
                                            '.'
                                        ) }}
                                        ml
                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td
                                        colspan="4"
                                        class="px-6 py-12 text-center text-sm text-gray-500"
                                    >
                                        No distribution details found.
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                        <tfoot class="bg-gray-50">
                            <tr>
                                <td
                                    class="px-6 py-4 text-right text-sm font-semibold text-gray-800"
                                >
                                    Total
                                </td>

                                <td
                                    class="px-6 py-4 text-right text-sm font-bold text-gray-900"
                                >
                                    {{ number_format($distribution->details->sum('quantity'), 2, ',', '.') }}
                                    servings
                                </td>

                                <td colspan="2"></td>
                            </tr>
                        </tfoot>

                    </table>

                </div>

            </div>

        </div>
    </div>
</x-app-layout>
