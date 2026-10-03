<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-xl font-bold text-stone-900">
                Edit Cart
            </h2>

            <p class="mt-1 text-sm text-stone-500">
                Update cart information and status.
            </p>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">

            <x-app-card>

                <form
                    method="POST"
                    action="{{ route('carts.update', $cart) }}"
                    class="space-y-5"
                >
                    @csrf
                    @method('PUT')

                    {{-- Cart Code --}}
                    <div>
                        <label
                            for="code"
                            class="block text-sm font-medium text-stone-700"
                        >
                            Cart Code
                        </label>

                        <input
                            type="text"
                            name="code"
                            id="code"
                            value="{{ old('code', $cart->code) }}"
                            required
                            class="mt-1 block w-full rounded-lg border-stone-300
                                   shadow-sm focus:border-amber-600
                                   focus:ring-amber-600"
                        >

                        @error('code')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Cart Name --}}
                    <div>
                        <label
                            for="name"
                            class="block text-sm font-medium text-stone-700"
                        >
                            Cart Name
                        </label>

                        <input
                            type="text"
                            name="name"
                            id="name"
                            value="{{ old('name', $cart->name) }}"
                            required
                            class="mt-1 block w-full rounded-lg border-stone-300
                                   shadow-sm focus:border-amber-600
                                   focus:ring-amber-600"
                        >

                        @error('name')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div>
                        <label
                            for="description"
                            class="block text-sm font-medium text-stone-700"
                        >
                            Description
                        </label>

                        <textarea
                            name="description"
                            id="description"
                            rows="3"
                            class="mt-1 block w-full rounded-lg border-stone-300
                                   shadow-sm focus:border-amber-600
                                   focus:ring-amber-600"
                        >{{ old('description', $cart->description) }}</textarea>

                        @error('description')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Status --}}
                    <div>
                        <label
                            for="status"
                            class="block text-sm font-medium text-stone-700"
                        >
                            Status
                        </label>

                        <select
                            name="status"
                            id="status"
                            required
                            class="mt-1 block w-full rounded-lg border-stone-300
                                   shadow-sm focus:border-amber-600
                                   focus:ring-amber-600"
                        >
                            <option
                                value="active"
                                {{ old('status', $cart->status) === 'active' ? 'selected' : '' }}
                            >
                                Active
                            </option>

                            <option
                                value="inactive"
                                {{ old('status', $cart->status) === 'inactive' ? 'selected' : '' }}
                            >
                                Inactive
                            </option>
                        </select>

                        @error('status')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Buttons --}}
                    <div class="flex flex-col gap-2 sm:flex-row">

                        <button
                            type="submit"
                            class="inline-flex justify-center rounded-lg
                                   bg-amber-700 px-4 py-2 text-sm
                                   font-semibold text-white
                                   hover:bg-amber-800"
                        >
                            Update Cart
                        </button>

                        <a
                            href="{{ route('carts.index') }}"
                            class="inline-flex justify-center rounded-lg
                                   bg-stone-200 px-4 py-2 text-sm
                                   font-semibold text-stone-700
                                   hover:bg-stone-300"
                        >
                            Cancel
                        </a>

                    </div>

                </form>

            </x-app-card>

        </div>
    </div>
</x-app-layout>
