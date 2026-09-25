<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between gap-3">
            <div>
                <h2 class="text-xl font-bold text-stone-900">
                    Raw Materials
                </h2>

                <p class="mt-1 text-sm text-stone-500">
                    Manage raw material information and stock levels.
                </p>
            </div>

            <a href="{{ route('raw-materials.create') }}"
                class="rounded-lg bg-amber-700 px-4 py-2 text-sm font-semibold text-white hover:bg-amber-800">
                Add Raw Material
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- Success Notification --}}
            @if (session('success'))
                <div id="success-notification"
                    class="mb-4 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Raw Material List --}}
            <div class="space-y-4">

                @forelse ($rawMaterials as $rawMaterial)

                    <x-app-card>

                        <div class="flex items-start justify-between gap-4">

                            <div class="min-w-0">

                                {{-- Name --}}
                                <h3 class="truncate text-base font-bold text-stone-900">
                                    {{ $rawMaterial->name }}
                                </h3>

                                {{-- Unit --}}
                                <p class="mt-1 text-sm text-stone-500">
                                    Unit: {{ $rawMaterial->unit }}
                                </p>

                                {{-- Current Stock --}}
                                <p class="mt-2 text-lg font-bold text-amber-900">
                                    {{ number_format($rawMaterial->current_stock, 2, ',', '.') }}
                                    {{ $rawMaterial->unit }}
                                </p>

                                {{-- Minimum Stock --}}
                                <p class="mt-1 text-xs text-stone-500">
                                    Minimum stock:
                                    {{ number_format($rawMaterial->minimum_stock, 2, ',', '.') }}
                                    {{ $rawMaterial->unit }}
                                </p>

                                {{-- Stock Status --}}
                                @if ($rawMaterial->current_stock <= $rawMaterial->minimum_stock)
                                    <span class="mt-2 inline-flex rounded-full bg-red-100 px-2.5 py-1 text-xs font-semibold text-red-700">
                                        Low Stock
                                    </span>
                                @else
                                    <span class="mt-2 inline-flex rounded-full bg-green-100 px-2.5 py-1 text-xs font-semibold text-green-700">
                                        Stock Available
                                    </span>
                                @endif

                                {{-- Active / Inactive --}}
                                <div>
                                    <span class="mt-2 inline-flex rounded-full px-2.5 py-1 text-xs font-semibold
                                        {{ $rawMaterial->status === 'Active'
                                            ? 'bg-green-100 text-green-700'
                                            : 'bg-stone-100 text-stone-600'
                                        }}">
                                        {{ $rawMaterial->status }}
                                    </span>
                                </div>

                            </div>

                            {{-- Actions --}}
                            <div class="flex shrink-0 items-center gap-2">

                                <a href="{{ route('raw-materials.edit', $rawMaterial) }}"
                                    class="rounded-lg bg-stone-100 px-3 py-2 text-xs font-semibold text-stone-700 hover:bg-stone-200">
                                    Edit
                                </a>

                                <form
                                    action="{{ route('raw-materials.destroy', $rawMaterial) }}"
                                    method="POST">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        onclick="return confirm('Are you sure you want to delete this raw material?')"
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
                                No raw materials found.
                            </p>

                            <p class="mt-1 text-sm text-stone-500">
                                Add a raw material to get started.
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
