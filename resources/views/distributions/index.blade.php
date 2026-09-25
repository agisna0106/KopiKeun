<x-app-layout>
    <x-slot name="header">
        <div class="flex w-full items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Distributions
            </h2>

            <a
                href="{{ route('distributions.create') }}"
                class="inline-flex items-center rounded-md px-4 py-2 text-sm font-semibold text-white shadow-sm hover:opacity-90"
                style="background-color: #ea580c;"
            >
                Add Distribution
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- Success Message --}}
            @if (session('success'))
                <div class="mb-6 rounded-md bg-green-50 p-4">
                    <p class="text-sm font-medium text-green-700">
                        {{ session('success') }}
                    </p>
                </div>
            @endif

            {{-- Distribution Table --}}
            <div class="overflow-hidden rounded-lg bg-white shadow-sm">

                <div class="overflow-x-auto">
                    <table class="w-full divide-y divide-gray-200">

                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    Employee
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    Distribution Date
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    Items
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    Notes
                                </th>

                                <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    Actions
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200 bg-white">

                            @forelse ($distributions as $distribution)

                                <tr>

                                    {{-- Employee --}}
                                    <td colspan="5" class="w-full px-6 py-4 text-sm text-gray-900">
                                        <div class="font-medium">
                                            {{ $distribution->employee->user->name }}
                                        </div>

                                        <div class="text-xs text-gray-500">
                                            {{ $distribution->employee->employee_code }}
                                        </div>
                                    </td>

                                    {{-- Date --}}
                                    <td colspan="5" class="w-full px-6 py-4 text-sm text-gray-700">
                                        {{ $distribution->distribution_date->format('d/m/Y') }}
                                    </td>

                                    {{-- Items --}}
                                    <td colspan="5" class="w-full px-6 py-4 text-sm text-gray-700">
                                        {{ $distribution->details->count() }} item(s)
                                    </td>

                                    {{-- Notes --}}
                                    <td colspan="5" class="w-full px-6 py-4 text-sm text-gray-700">
                                        {{ $distribution->notes ?: '-' }}
                                    </td>

                                    {{-- Actions --}}
                                    <td colspan="5" class="w-full px-6 py-4 text-right text-sm">
                                        <div class="flex justify-end gap-2">

                                            <a
                                                href="{{ route('distributions.show', $distribution) }}"
                                                class="rounded-md bg-gray-100 px-3 py-2 font-medium text-gray-700 hover:bg-gray-200"
                                            >
                                                View
                                            </a>

                                            <a
                                                href="{{ route('distributions.edit', $distribution) }}"
                                                class="rounded-md bg-blue-100 px-3 py-2 font-medium text-blue-700 hover:bg-blue-200"
                                            >
                                                Edit
                                            </a>

                                            <form
                                                method="POST"
                                                action="{{ route('distributions.destroy', $distribution) }}"
                                                onsubmit="return confirm('Are you sure you want to delete this distribution?');"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="rounded-md bg-red-100 px-3 py-2 font-medium text-red-700 hover:bg-red-200"
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
                                        colspan="5"
                                        class="px-6 py-12 text-center"
                                    >
                                        <p class="text-sm text-gray-500">
                                            No distributions found.
                                        </p>

                                        <a
                                            href="{{ route('distributions.create') }}"
                                            class="mt-3 inline-block text-sm font-medium text-orange-600 hover:text-orange-700"
                                        >
                                            Create the first distribution
                                        </a>
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
