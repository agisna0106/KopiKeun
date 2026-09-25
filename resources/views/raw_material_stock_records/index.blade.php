<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between gap-3">
            <div>
                <h2 class="text-xl font-bold text-stone-900">
                    Stock Records
                </h2>

                <p class="mt-1 text-sm text-stone-500">
                    View raw material stock recording history.
                </p>
            </div>

            <a
                href="{{ route('raw-material-stock-records.create') }}"
                class="rounded-lg bg-amber-700 px-4 py-2 text-sm font-semibold text-white hover:bg-amber-800">
                Record Stock
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- Success Notification --}}
            @if (session('success'))
                <div
                    id="success-notification"
                    class="mb-4 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Stock Record List --}}
            <div class="space-y-4">

                @forelse ($stockRecords as $stockRecord)

                    <x-app-card>

                        <div class="flex items-start justify-between gap-4">

                            <div class="min-w-0">

                                {{-- Raw Material --}}
                                <h3 class="truncate text-base font-bold text-stone-900">
                                    {{ $stockRecord->rawMaterial->name }}
                                </h3>

                                {{-- Stock --}}
                                <p class="mt-1 text-lg font-bold text-amber-900">
                                    {{ number_format($stockRecord->stock, 2, ',', '.') }}
                                    {{ $stockRecord->rawMaterial->unit }}
                                </p>

                                {{-- Date --}}
                                <p class="mt-1 text-sm text-stone-500">
                                    {{ $stockRecord->recorded_at->format('d F Y') }}
                                </p>

                                {{-- Notes --}}
                                @if ($stockRecord->notes)
                                    <p class="mt-2 text-sm text-stone-600">
                                        {{ $stockRecord->notes }}
                                    </p>
                                @endif

                            </div>

                            {{-- Actions --}}
                            <div class="flex shrink-0 items-center gap-2">

                                <a
                                    href="{{ route('raw-material-stock-records.edit', $stockRecord) }}"
                                    class="rounded-lg bg-stone-100 px-3 py-2 text-xs font-semibold text-stone-700 hover:bg-stone-200">
                                    Edit
                                </a>

                                <form
                                    action="{{ route('raw-material-stock-records.destroy', $stockRecord) }}"
                                    method="POST">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        onclick="return confirm('Are you sure you want to delete this stock record?')"
                                        class="rounded-lg bg-red-50 px-3 py-2 text-xs font-semibold text-red-600 hover:bg-red-100">
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
                                No stock records found.
                            </p>

                            <p class="mt-1 text-sm text-stone-500">
                                Record a stock check to get started.
                            </p>

                        </div>

                    </x-app-card>

                @endforelse

            </div>

        </div>
    </div>

    {{-- Auto-hide success notification --}}
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
