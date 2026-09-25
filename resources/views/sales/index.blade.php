<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Sales Transactions
            </h2>

            <a
                href="{{ route('sales.create') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700"
            >
                Add Sale
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 rounded-lg bg-green-100 border border-green-200 px-4 py-3 text-sm text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">

                            <thead>
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        No.
                                    </th>

                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Source
                                    </th>

                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Employee
                                    </th>

                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Sale Date
                                    </th>

                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Items
                                    </th>

                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Total
                                    </th>

                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200">

                                @forelse ($sales as $sale)
                                    @php
                                        $total = $sale->details->sum('subtotal');
                                    @endphp

                                    <tr>

                                        <td class="px-4 py-3 text-sm text-gray-700">
                                            {{ $loop->iteration }}
                                        </td>

                                        <td class="px-4 py-3 text-sm">
                                            @if ($sale->sale_source === 'Outlet')
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                                    Outlet
                                                </span>
                                            @else
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">
                                                    Employee
                                                </span>
                                            @endif
                                        </td>

                                        <td class="px-4 py-3 text-sm text-gray-700">
                                            @if ($sale->employee && $sale->employee->user)
                                                {{ $sale->employee->user->name }}
                                            @else
                                                -
                                            @endif
                                        </td>

                                        <td class="px-4 py-3 text-sm text-gray-700">
                                            {{ $sale->sale_date->format('d/m/Y') }}
                                        </td>

                                        <td class="px-4 py-3 text-sm text-gray-700">
                                            {{ $sale->details->count() }}
                                            {{ $sale->details->count() === 1 ? 'item' : 'items' }}
                                        </td>

                                        <td class="px-4 py-3 text-sm font-semibold text-gray-900">
                                            Rp {{ number_format($total, 0, ',', '.') }}
                                        </td>

                                        <td class="px-4 py-3 text-sm">
                                            <div class="flex items-center gap-2">

                                                <a
                                                    href="{{ route('sales.show', $sale) }}"
                                                    class="text-blue-600 hover:text-blue-900 font-medium"
                                                >
                                                    View
                                                </a>

                                                <a
                                                    href="{{ route('sales.edit', $sale) }}"
                                                    class="text-indigo-600 hover:text-indigo-900 font-medium"
                                                >
                                                    Edit
                                                </a>

                                                <form
                                                    action="{{ route('sales.destroy', $sale) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Are you sure you want to delete this sale?');"
                                                >
                                                    @csrf
                                                    @method('DELETE')

                                                    <button
                                                        type="submit"
                                                        class="text-red-600 hover:text-red-900 font-medium"
                                                    >
                                                        Delete
                                                    </button>
                                                </form>

                                            </div>
                                        </td>

                                    </tr>

                                @empty
                                    <tr>
                                        <td
                                            colspan="7"
                                            class="px-4 py-8 text-center text-sm text-gray-500"
                                        >
                                            No sales transactions found.
                                        </td>
                                    </tr>
                                @endforelse

                            </tbody>

                        </table>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
