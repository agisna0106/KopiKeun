<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Operational Expenses
            </h2>

            <a
                href="{{ route('operational-expenses.create') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700"
            >
                Add Expense
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
                                        Expense
                                    </th>

                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Amount
                                    </th>

                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Expense Date
                                    </th>

                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Notes
                                    </th>

                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200">

                                @forelse ($operationalExpenses as $operationalExpense)
                                    <tr>

                                        <td class="px-4 py-3 text-sm text-gray-700">
                                            {{ $loop->iteration }}
                                        </td>

                                        <td class="px-4 py-3 text-sm font-medium text-gray-900">
                                            {{ $operationalExpense->name }}
                                        </td>

                                        <td class="px-4 py-3 text-sm text-gray-700">
                                            Rp {{ number_format($operationalExpense->amount, 0, ',', '.') }}
                                        </td>

                                        <td class="px-4 py-3 text-sm text-gray-700">
                                            {{ $operationalExpense->expense_date->format('d/m/Y') }}
                                        </td>

                                        <td class="px-4 py-3 text-sm text-gray-700">
                                            {{ $operationalExpense->notes ?? '-' }}
                                        </td>

                                        <td class="px-4 py-3 text-sm">
                                            <div class="flex items-center gap-2">

                                                <a
                                                    href="{{ route('operational-expenses.edit', $operationalExpense) }}"
                                                    class="text-indigo-600 hover:text-indigo-900 font-medium"
                                                >
                                                    Edit
                                                </a>

                                                <form
                                                    action="{{ route('operational-expenses.destroy', $operationalExpense) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Are you sure you want to delete this expense?');"
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
                                            colspan="6"
                                            class="px-4 py-8 text-center text-sm text-gray-500"
                                        >
                                            No operational expenses found.
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
