<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-stone-900">
                    Carts
                </h2>

                <p class="mt-1 text-sm text-stone-500">
                    Manage cart information and availability.
                </p>
            </div>

            <a
                href="{{ route('carts.create') }}"
                class="rounded-lg bg-amber-700 px-4 py-2 text-sm
                       font-semibold text-white hover:bg-amber-800"
            >
                Add Cart
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

            {{-- Cart List --}}
            <div class="space-y-4">

                @forelse ($carts as $cart)

                    <x-app-card>

                        <div class="flex items-start justify-between gap-4">

                            <div class="min-w-0">

                                {{-- Cart Name --}}
                                <h3 class="truncate text-base font-bold text-stone-900">
                                    {{ $cart->name }}
                                </h3>

                                {{-- Cart Code --}}
                                <p class="mt-1 text-sm font-medium text-stone-500">
                                    {{ $cart->code }}
                                </p>

                                {{-- Description --}}
                                @if ($cart->description)
                                    <p class="mt-2 text-sm text-stone-600">
                                        {{ $cart->description }}
                                    </p>
                                @endif

                                {{-- Status --}}
                                <span
                                    class="mt-3 inline-flex rounded-full px-2.5 py-1
                                           text-xs font-semibold
                                           {{ $cart->status === 'active'
                                                ? 'bg-green-100 text-green-700'
                                                : 'bg-stone-100 text-stone-600'
                                           }}"
                                >
                                    {{ ucfirst($cart->status) }}
                                </span>

                            </div>

                            {{-- Actions --}}
                            <div class="flex shrink-0 items-center gap-2">

                                <a
                                    href="{{ route('carts.edit', $cart) }}"
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
                                No carts found.
                            </p>

                            <p class="mt-1 text-sm text-stone-500">
                                Add a cart to get started.
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
