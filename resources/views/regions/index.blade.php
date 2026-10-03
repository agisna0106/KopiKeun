<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-stone-900">
                    Regions
                </h2>

                <p class="mt-1 text-sm text-stone-500">
                    Manage operational regions.
                </p>
            </div>

            <a
                href="{{ route('regions.create') }}"
                class="rounded-lg bg-amber-700 px-4 py-2 text-sm
                       font-semibold text-white hover:bg-amber-800"
            >
                Add Region
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

            {{-- Region List --}}
            <div class="space-y-4">

                @forelse ($regions as $region)

                    <x-app-card>

                        <div class="flex items-start justify-between gap-4">

                            <div class="min-w-0">

                                <h3 class="truncate text-base font-bold text-stone-900">
                                    {{ $region->name }}
                                </h3>

                                @if ($region->description)
                                    <p class="mt-1 text-sm text-stone-500">
                                        {{ $region->description }}
                                    </p>
                                @endif

                                <span
                                    class="mt-2 inline-flex rounded-full px-2.5 py-1
                                           text-xs font-semibold
                                           {{ $region->status === 'active'
                                                ? 'bg-green-100 text-green-700'
                                                : 'bg-stone-100 text-stone-600'
                                           }}"
                                >
                                    {{ ucfirst($region->status) }}
                                </span>

                            </div>

                            <div class="flex shrink-0 items-center gap-2">

                                <a
                                    href="{{ route('regions.edit', $region) }}"
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
                                No regions found.
                            </p>

                            <p class="mt-1 text-sm text-stone-500">
                                Add a region to get started.
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
