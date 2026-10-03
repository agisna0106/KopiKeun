<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-stone-900">
                    Operational Items
                </h2>

                <p class="mt-1 text-sm text-stone-500">
                    Manage operational items and their stock.
                </p>
            </div>

            <a
                href="{{ route('operational-items.create') }}"
                class="rounded-lg bg-amber-700 px-4 py-2 text-sm
                       font-semibold text-white hover:bg-amber-800"
            >
                Add Operational Item
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

            {{-- Operational Item List --}}
            <div class="space-y-4">

                @forelse ($operationalItems as $item)

                    <x-app-card>

                        <div class="flex items-start justify-between gap-4">

                            <div class="min-w-0">

                                <h3 class="truncate text-base font-bold text-stone-900">
                                    {{ $item->name }}
                                </h3>

                                <p class="mt-1 text-sm text-stone-500">
                                    Unit: {{ $item->unit }}
                                </p>

                                <div class="mt-2 flex flex-wrap gap-2">

                                    <span
                                        class="inline-flex rounded-full px-2.5 py-1
                                               text-xs font-semibold
                                               bg-stone-100 text-stone-700"
                                    >
                                        Stock: {{ $item->stock }}
                                    </span>

                                    <span
                                        class="inline-flex rounded-full px-2.5 py-1
                                               text-xs font-semibold
                                               {{ $item->stock <= $item->minimum_stock
                                                    ? 'bg-red-100 text-red-700'
                                                    : 'bg-green-100 text-green-700'
                                               }}"
                                    >
                                        Minimum: {{ $item->minimum_stock }}
                                    </span>

                                    <span
                                        class="inline-flex rounded-full px-2.5 py-1
                                               text-xs font-semibold
                                               {{ $item->status === 'active'
                                                    ? 'bg-green-100 text-green-700'
                                                    : 'bg-stone-100 text-stone-600'
                                               }}"
                                    >
                                        {{ ucfirst($item->status) }}
                                    </span>

                                </div>

                            </div>

                            <div class="flex shrink-0 items-center gap-2">

                                <a
                                    href="{{ route('operational-items.edit', $item) }}"
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
                                No operational items found.
                            </p>

                            <p class="mt-1 text-sm text-stone-500">
                                Add an operational item to get started.
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
