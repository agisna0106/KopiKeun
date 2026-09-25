<?php

namespace App\Http\Controllers;

use App\Models\BaseDrink;
use App\Models\Distribution;
use App\Models\Employee;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DistributionController extends Controller
{
    public function index(): View
    {
        $distributions = Distribution::with([
            'employee.user',
            'details.baseDrink',
        ])
            ->latest('distribution_date')
            ->latest()
            ->get();

        return view('distributions.index', compact('distributions'));
    }

    public function create(): View
    {
        $employees = Employee::with('user')
            ->where('status', 'Active')
            ->whereHas('user.role', function ($query) {
                $query->where('nama_role', 'Karyawan');
            })
            ->orderBy('employee_code')
            ->get();

        $baseDrinks = BaseDrink::where('status', 'Active')
            ->orderBy('name')
            ->get();

        return view('distributions.create', compact(
            'employees',
            'baseDrinks'
        ));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'employee_id' => ['required', 'exists:employees,id'],
            'distribution_date' => ['required', 'date'],
            'notes' => ['nullable', 'string'],

            'base_drinks' => ['required', 'array', 'min:1'],

            'base_drinks.*.base_drink_id' => [
                'required',
                'exists:base_drinks,id',
            ],

            'base_drinks.*.quantity' => [
                'required',
                'numeric',
                'min:0.01',
            ],
        ]);

        DB::transaction(function () use ($validated) {
            $distribution = Distribution::create([
                'employee_id' => $validated['employee_id'],
                'distribution_date' => $validated['distribution_date'],
                'notes' => $validated['notes'] ?? null,
            ]);

            foreach ($validated['base_drinks'] as $item) {
                $distribution->details()->create([
                    'base_drink_id' => $item['base_drink_id'],
                    'quantity' => $item['quantity'],
                ]);
            }
        });

        return redirect()
            ->route('distributions.index')
            ->with(
                'success',
                'Distribution recorded successfully.'
            );
    }

    public function show(Distribution $distribution): View
    {
        $distribution->load([
            'employee.user',
            'details.baseDrink',
        ]);

        return view('distributions.show', compact('distribution'));
    }

    public function edit(Distribution $distribution): View
    {
        $distribution->load('details');

        $employees = Employee::with('user')
            ->where('status', 'Active')
            ->whereHas('user.role', function ($query) {
                $query->where('nama_role', 'Karyawan');
            })
            ->orderBy('employee_code')
            ->get();

        $baseDrinks = BaseDrink::where('status', 'Active')
            ->orderBy('name')
            ->get();

        return view('distributions.edit', compact(
            'distribution',
            'employees',
            'baseDrinks'
        ));
    }

    public function update(
        Request $request,
        Distribution $distribution
    ): RedirectResponse {
        $validated = $request->validate([
            'employee_id' => ['required', 'exists:employees,id'],
            'distribution_date' => ['required', 'date'],
            'notes' => ['nullable', 'string'],

            'base_drinks' => ['required', 'array', 'min:1'],

            'base_drinks.*.base_drink_id' => [
                'required',
                'exists:base_drinks,id',
            ],

            'base_drinks.*.quantity' => [
                'required',
                'numeric',
                'min:0.01',
            ],
        ]);

        DB::transaction(function () use ($validated, $distribution) {
            $distribution->update([
                'employee_id' => $validated['employee_id'],
                'distribution_date' => $validated['distribution_date'],
                'notes' => $validated['notes'] ?? null,
            ]);

            $distribution->details()->delete();

            foreach ($validated['base_drinks'] as $item) {
                $distribution->details()->create([
                    'base_drink_id' => $item['base_drink_id'],
                    'quantity' => $item['quantity'],
                ]);
            }
        });

        return redirect()
            ->route('distributions.index')
            ->with(
                'success',
                'Distribution updated successfully.'
            );
    }

    public function destroy(
        Distribution $distribution
    ): RedirectResponse {
        $distribution->delete();

        return redirect()
            ->route('distributions.index')
            ->with(
                'success',
                'Distribution deleted successfully.'
            );
    }
}
