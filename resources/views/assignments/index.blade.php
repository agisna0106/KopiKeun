<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-stone-900">
                    Assignments
                </h2>

                <p class="mt-1 text-sm text-stone-500">
                    Manage employee assignments to carts and regions.
                </p>
            </div>

            <a
                href="{{ route('assignments.create') }}"
                class="rounded-lg bg-amber-700 px-4 py-2 text-sm
                       font-semibold text-white hover:bg-amber-800"
            >
                Add Assignment
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

            {{-- Assignment List --}}
            <div class="space-y-4">

                @forelse ($assignments as $assignment)

                    <x-app-card>

                        <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">

                            {{-- Assignment Information --}}
                            <div class="min-w-0">

                                {{-- Employee --}}
                                <h3 class="text-base font-bold text-stone-900">
                                    {{ $assignment->employee->user->name }}
                                </h3>

                                <p class="mt-1 text-sm text-stone-500">
                                    {{ $assignment->employee->employee_code }}
                                </p>

                                {{-- Cart --}}
                                <div class="mt-3">
                                    <p class="text-xs font-medium uppercase tracking-wide text-stone-400">
                                        Cart
                                    </p>

                                    <p class="text-sm font-medium text-stone-700">
                                        {{ $assignment->cart->name }}
                                        <span class="text-stone-400">
                                            ({{ $assignment->cart->code }})
                                        </span>
                                    </p>
                                </div>

                                {{-- Region --}}
                                <div class="mt-2">
                                    <p class="text-xs font-medium uppercase tracking-wide text-stone-400">
                                        Region
                                    </p>

                                    <p class="text-sm font-medium text-stone-700">
                                        {{ $assignment->region->name }}
                                    </p>
                                </div>

                                {{-- Assignment Period --}}
                                <div class="mt-2">
                                    <p class="text-xs font-medium uppercase tracking-wide text-stone-400">
                                        Assignment Period
                                    </p>

                                    <p class="text-sm text-stone-700">
                                        {{ $assignment->start_date->format('d M Y') }}

                                        <span class="text-stone-400">
                                            —
                                        </span>

                                        @if ($assignment->end_date)
                                            {{ $assignment->end_date->format('d M Y') }}
                                        @else
                                            <span class="font-medium text-green-600">
                                                Ongoing
                                            </span>
                                        @endif
                                    </p>
                                </div>

                                {{-- Status --}}
                                <span
                                    class="mt-3 inline-flex rounded-full px-2.5 py-1
                                           text-xs font-semibold
                                           {{ $assignment->status === 'active'
                                                ? 'bg-green-100 text-green-700'
                                                : 'bg-stone-100 text-stone-600'
                                           }}"
                                >
                                    {{ ucfirst($assignment->status) }}
                                </span>

                                {{-- Notes --}}
                                @if ($assignment->notes)
                                    <div class="mt-3">
                                        <p class="text-xs font-medium uppercase tracking-wide text-stone-400">
                                            Notes
                                        </p>

                                        <p class="mt-1 text-sm text-stone-600">
                                            {{ $assignment->notes }}
                                        </p>
                                    </div>
                                @endif

                            </div>

                            {{-- Action --}}
                            <div class="flex shrink-0 items-center">
                                <a
                                    href="{{ route('assignments.edit', $assignment) }}"
                                    class="rounded-lg bg-stone-100 px-3 py-2
                                           text-xs font-semibold text-stone-700
                                           hover:bg-stone-200"
                                >
                                    Edit
                                </a>
                            </div>

                        </div>

                    </x-app-card>

                @empty

                    <x-app-card>

                        <div class="py-8 text-center">

                            <p class="text-sm font-medium text-stone-700">
                                No assignments found.
                            </p>

                            <p class="mt-1 text-sm text-stone-500">
                                Add an assignment to get started.
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
