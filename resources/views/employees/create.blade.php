<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-xl font-bold text-stone-900">
                Add Employee
            </h2>

            <p class="mt-1 text-sm text-stone-500">
                Add an employee from an existing Karyawan account.
            </p>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">

            <x-app-card>

                <form
                    method="POST"
                    action="{{ route('employees.store') }}"
                    class="space-y-5"
                >
                    @csrf

                    {{-- User --}}
                    <div>
                        <label
                            for="user_id"
                            class="block text-sm font-medium text-stone-700"
                        >
                            Employee User
                        </label>

                        <select
                            name="user_id"
                            id="user_id"
                            required
                            class="mt-1 block w-full rounded-lg border-stone-300
                                   shadow-sm focus:border-amber-600
                                   focus:ring-amber-600"
                        >
                            <option value="">
                                Select Employee User
                            </option>

                            @foreach ($users as $user)
                                <option
                                    value="{{ $user->id }}"
                                    {{ old('user_id') == $user->id ? 'selected' : '' }}
                                >
                                    {{ $user->name }} — {{ $user->email }}
                                </option>
                            @endforeach
                        </select>

                        @error('user_id')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Employee Code --}}
                    <div>
                        <label
                            for="employee_code"
                            class="block text-sm font-medium text-stone-700"
                        >
                            Employee Code
                        </label>

                        <input
                            type="text"
                            name="employee_code"
                            id="employee_code"
                            value="{{ old('employee_code') }}"
                            placeholder="e.g. EMP001"
                            required
                            class="mt-1 block w-full rounded-lg border-stone-300
                                   shadow-sm focus:border-amber-600
                                   focus:ring-amber-600"
                        >

                        @error('employee_code')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Phone --}}
                    <div>
                        <label
                            for="phone"
                            class="block text-sm font-medium text-stone-700"
                        >
                            Phone
                        </label>

                        <input
                            type="text"
                            name="phone"
                            id="phone"
                            value="{{ old('phone') }}"
                            placeholder="e.g. 081234567890"
                            class="mt-1 block w-full rounded-lg border-stone-300
                                   shadow-sm focus:border-amber-600
                                   focus:ring-amber-600"
                        >

                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Address --}}
                    <div>
                        <label
                            for="address"
                            class="block text-sm font-medium text-stone-700"
                        >
                            Address
                        </label>

                        <textarea
                            name="address"
                            id="address"
                            rows="3"
                            class="mt-1 block w-full rounded-lg border-stone-300
                                   shadow-sm focus:border-amber-600
                                   focus:ring-amber-600"
                        >{{ old('address') }}</textarea>

                        @error('address')
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
                                value="Active"
                                {{ old('status', 'Active') === 'Active' ? 'selected' : '' }}
                            >
                                Active
                            </option>

                            <option
                                value="Inactive"
                                {{ old('status') === 'Inactive' ? 'selected' : '' }}
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
                            Save Employee
                        </button>

                        <a
                            href="{{ route('employees.index') }}"
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
