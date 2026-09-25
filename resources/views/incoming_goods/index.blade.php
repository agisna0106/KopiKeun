<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Incoming Goods
            </h2>

            <a
                href="{{ route('incoming-goods.create') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
            >
                Add Incoming Goods
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
                                        Raw Material
                                    </th>

                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Quantity
                                    </th>

                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Unit Cost
                                    </th>

                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Total Cost
                                    </th>

                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Received At
                                    </th>

                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Supplier
                                    </th>

                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200">
                                @forelse ($incomingGoods as $incomingGood)
                                    <tr>
                                        <td class="px-4 py-3 text-sm text-gray-700">
                                            {{ $loop->iteration }}
                                        </td>

                                        <td class="px-4 py-3 text-sm text-gray-700">
                                            {{ $incomingGood->rawMaterial->name }}
                                        </td>

                                        <td class="px-4 py-3 text-sm text-gray-700">
                                            {{ $incomingGood->quantity }}
                                            {{ $incomingGood->rawMaterial->unit }}
                                        </td>

                                        <td class="px-4 py-3 text-sm text-gray-700">
                                            Rp {{ number_format($incomingGood->unit_cost, 0, ',', '.') }}
                                        </td>

                                        <td class="px-4 py-3 text-sm font-medium text-gray-900">
                                            Rp {{ number_format($incomingGood->quantity * $incomingGood->unit_cost, 0, ',', '.') }}
                                        </td>

                                        <td class="px-4 py-3 text-sm text-gray-700">
                                            {{ $incomingGood->received_at->format('d/m/Y') }}
                                        </td>

                                        <td class="px-4 py-3 text-sm text-gray-700">
                                            {{ $incomingGood->supplier ?? '-' }}
                                        </td>

                                        <td class="px-4 py-3 text-sm">
                                            <div class="flex items-center gap-2">
                                                <a
                                                    href="{{ route('incoming-goods.edit', $incomingGood) }}"
                                                    class="text-indigo-600 hover:text-indigo-900 font-medium"
                                                >
                                                    Edit
                                                </a>

                                                <form
                                                    action="{{ route('incoming-goods.destroy', $incomingGood) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Are you sure you want to delete this incoming goods record?');"
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
                                            colspan="8"
                                            class="px-4 py-8 text-center text-sm text-gray-500"
                                        >
                                            No incoming goods records found.
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
