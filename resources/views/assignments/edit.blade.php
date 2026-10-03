<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-xl font-bold text-stone-900">
                Edit Assignment
            </h2>

            <p class="mt-1 text-sm text-stone-500">
                Update employee assignment information.
            </p>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">

            <x-app-card>

                <form
                    method="POST"
                    action="{{ route('assignments.update', $assignment) }}"
                    class="space-y-5"
                >
                    @csrf
                    @method('PUT')

                    {{-- Employee --}}
                    <div>
                        <label
                            for="employee_id"
                            class="block text-sm font-medium text-stone-700"
                        >
                            Employee
                        </label>

                        <select
                            name="employee_id"
                            id="employee_id"
                            required
                            class="mt-1 block w-full rounded-lg border-stone-300
                                   shadow-sm focus:border-amber-600
                                   focus:ring-amber-600"
                        >
                            <option value="">
                                Select Employee
                            </option>

                            @foreach ($employees as $employee)
                                <option
                                    value="{{ $employee->id }}"
                                    {{ old('employee_id', $assignment->employee_id) == $employee->id ? 'selected' : '' }}
                                >
                                    {{ $employee->user->name }}
                                    — {{ $employee->employee_code }}
                                </option>
                            @endforeach
                        </select>

                        @error('employee_id')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Cart --}}
                    <div>
                        <label
                            for="cart_id"
                            class="block text-sm font-medium text-stone-700"
                        >
                            Cart
                        </label>

                        <select
                            name="cart_id"
                            id="cart_id"
                            required
                            class="mt-1 block w-full rounded-lg border-stone-300
                                   shadow-sm focus:border-amber-600
                                   focus:ring-amber-600"
                        >
                            <option value="">
                                Select Cart
                            </option>

                            @foreach ($carts as $cart)
                                <option
                                    value="{{ $cart->id }}"
                                    {{ old('cart_id', $assignment->cart_id) == $cart->id ? 'selected' : '' }}
                                >
                                    {{ $cart->name }}
                                    — {{ $cart->code }}
                                </option>
                            @endforeach
                        </select>

                        @error('cart_id')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Region --}}
                    <div>
                        <label
                            for="region_id"
                            class="block text-sm font-medium text-stone-700"
                        >
                            Region
                        </label>

                        <select
                            name="region_id"
                            id="region_id"
                            required
                            class="mt-1 block w-full rounded-lg border-stone-300
                                   shadow-sm focus:border-amber-600
                                   focus:ring-amber-600"
                        >
                            <option value="">
                                Select Region
                            </option>

                            @foreach ($regions as $region)
                                <option
                                    value="{{ $region->id }}"
                                    {{ old('region_id', $assignment->region_id) == $region->id ? 'selected' : '' }}
                                >
                                    {{ $region->name }}
                                </option>
                            @endforeach
                        </select>

                        @error('region_id')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Assignment Date --}}
                    <div>
                        <label
                            for="start_date"
                            class="block text-sm font-medium text-stone-700"
                        >
                            Assignment Date
                        </label>

                        <input
                            type="date"
                            name="start_date"
                            id="start_date"
                            value="{{ old(
                                'start_date',
                                $assignment->start_date?->format('Y-m-d')
                            ) }}"
                            required
                            class="mt-1 block w-full rounded-lg border-stone-300
                                   shadow-sm focus:border-amber-600
                                   focus:ring-amber-600"
                        >

                        <p class="mt-1 text-xs text-stone-500">
                            The date when this assignment starts.
                        </p>

                        @error('start_date')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- End Date --}}
                    <div>
                        <label
                            for="end_date"
                            class="block text-sm font-medium text-stone-700"
                        >
                            End Date
                        </label>

                        <input
                            type="date"
                            name="end_date"
                            id="end_date"
                            value="{{ old(
                                'end_date',
                                $assignment->end_date?->format('Y-m-d')
                            ) }}"
                            class="mt-1 block w-full rounded-lg border-stone-300
                                   shadow-sm focus:border-amber-600
                                   focus:ring-amber-600"
                        >

                        <p class="mt-1 text-xs text-stone-500">
                            Leave empty if the assignment is still ongoing.
                        </p>

                        @error('end_date')
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
                                {{ old('status', $assignment->status) === 'active' ? 'selected' : '' }}
                            >
                                Active
                            </option>

                            <option
                                value="inactive"
                                {{ old('status', $assignment->status) === 'inactive' ? 'selected' : '' }}
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

                    {{-- Notes --}}
                    <div>
                        <label
                            for="notes"
                            class="block text-sm font-medium text-stone-700"
                        >
                            Notes
                        </label>

                        <textarea
                            name="notes"
                            id="notes"
                            rows="3"
                            placeholder="Optional notes about this assignment"
                            class="mt-1 block w-full rounded-lg border-stone-300
                                   shadow-sm focus:border-amber-600
                                   focus:ring-amber-600"
                        >{{ old('notes', $assignment->notes) }}</textarea>

                        @error('notes')
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
                            Update Assignment
                        </button>

                        <a
                            href="{{ route('assignments.index') }}"
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
