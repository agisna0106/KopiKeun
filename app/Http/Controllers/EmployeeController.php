<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmployeeController extends Controller
{
    public function index(): View
    {
        $employees = Employee::with('user')
            ->latest()
            ->get();

        return view('employees.index', compact('employees'));
    }

    public function create(): View
    {
        $users = User::whereHas('role', function ($query) {
            $query->whereIn('nama_role', ['Admin', 'Karyawan']);
        })
        ->whereDoesntHave('employee')
        ->orderBy('name')
        ->get();

        return view('employees.create', compact('users'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'user_id' => [
                'required',
                'exists:users,id',
                'unique:employees,user_id',
            ],

            'employee_code' => [
                'required',
                'string',
                'max:50',
                'unique:employees,employee_code',
            ],

            'phone' => [
                'nullable',
                'string',
                'max:20',
            ],

            'address' => [
                'nullable',
                'string',
            ],

            'status' => [
                'required',
                'in:Active,Inactive',
            ],
        ]);

        Employee::create($validated);

        return redirect()
            ->route('employees.index')
            ->with('success', 'Employee created successfully.');
    }

    public function show(Employee $employee)
    {
        //
    }

    public function edit(Employee $employee): View
    {
        $users = User::whereHas('role', function ($query) {
            $query->where('nama_role', ['Admin', 'Karyawan']);
        })
        ->where(function ($query) use ($employee) {
            $query->whereDoesntHave('employee')
                ->orWhere('id', $employee->user_id);
        })
        ->orderBy('name')
        ->get();

        return view('employees.edit', compact(
            'employee',
            'users'
        ));
    }

    public function update(
        Request $request,
        Employee $employee
    ): RedirectResponse {
        $validated = $request->validate([
            'user_id' => [
                'required',
                'exists:users,id',
                'unique:employees,user_id,' . $employee->id,
            ],

            'employee_code' => [
                'required',
                'string',
                'max:50',
                'unique:employees,employee_code,' . $employee->id,
            ],

            'phone' => [
                'nullable',
                'string',
                'max:20',
            ],

            'address' => [
                'nullable',
                'string',
            ],

            'status' => [
                'required',
                'in:Active,Inactive',
            ],
        ]);

        $employee->update($validated);

        return redirect()
            ->route('employees.index')
            ->with('success', 'Employee updated successfully.');
    }

    public function destroy(Employee $employee): RedirectResponse
    {
        $employee->delete();

        return redirect()
            ->route('employees.index')
            ->with('success', 'Employee deleted successfully.');
    }
}
