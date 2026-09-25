<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-stone-900">
                    Employees
                </h2>

                <p class="mt-1 text-sm text-stone-500">
                    Manage employee information.
                </p>
            </div>

            <a
                href="{{ route('employees.create') }}"
                class="rounded-lg bg-amber-700 px-4 py-2 text-sm
                       font-semibold text-white hover:bg-amber-800"
            >
                Add Employee
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

            {{-- Employee List --}}
            <div class="space-y-4">

                @forelse ($employees as $employee)

                    <x-app-card>

                        <div class="flex items-start justify-between gap-4">

                            <div class="min-w-0">

                                <h3 class="truncate text-base font-bold text-stone-900">
                                    {{ $employee->user->name }}
                                </h3>

                                <p class="mt-1 text-sm text-stone-500">
                                    {{ $employee->employee_code }}
                                </p>

                                @if ($employee->phone)
                                    <p class="mt-1 text-sm text-stone-500">
                                        {{ $employee->phone }}
                                    </p>
                                @endif

                                <span
                                    class="mt-2 inline-flex rounded-full px-2.5 py-1
                                           text-xs font-semibold
                                           {{ $employee->status === 'Active'
                                                ? 'bg-green-100 text-green-700'
                                                : 'bg-stone-100 text-stone-600'
                                           }}"
                                >
                                    {{ $employee->status }}
                                </span>

                            </div>

                            <div class="flex shrink-0 items-center gap-2">

                                <a
                                    href="{{ route('employees.edit', $employee) }}"
                                    class="rounded-lg bg-stone-100 px-3 py-2
                                           text-xs font-semibold text-stone-700
                                           hover:bg-stone-200"
                                >
                                    Edit
                                </a>

                                <form
                                    action="{{ route('employees.destroy', $employee) }}"
                                    method="POST"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        onclick="return confirm('Are you sure you want to delete this employee?')"
                                        class="rounded-lg bg-red-50 px-3 py-2
                                               text-xs font-semibold text-red-600
                                               hover:bg-red-100"
                                    >
                                        Delete
                                    </button>
                                </form>

                            </div>

                        </div>

                    </x-app-card>

                @empty

                    <x-app-card>

                        <div class="py-8 text-center">

                            <p class="text-sm font-medium text-stone-700">
                                No employees found.
                            </p>

                            <p class="mt-1 text-sm text-stone-500">
                                Add an employee to get started.
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
