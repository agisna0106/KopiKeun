<?php

namespace App\Http\Controllers;

use App\Models\OperationalExpense;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OperationalExpenseController extends Controller
{
    public function index(): View
    {
        $operationalExpenses = OperationalExpense::latest(
            'expense_date'
        )->latest()->get();

        return view(
            'operational_expenses.index',
            compact('operationalExpenses')
        );
    }

    public function create(): View
    {
        return view('operational_expenses.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
            ],
            'amount' => [
                'required',
                'numeric',
                'min:0',
            ],
            'expense_date' => [
                'required',
                'date',
            ],
            'notes' => [
                'nullable',
                'string',
            ],
        ]);

        OperationalExpense::create($validated);

        return redirect()
            ->route('operational-expenses.index')
            ->with(
                'success',
                'Operational expense created successfully.'
            );
    }

    public function edit(
        OperationalExpense $operationalExpense
    ): View {
        return view(
            'operational_expenses.edit',
            compact('operationalExpense')
        );
    }

    public function update(
        Request $request,
        OperationalExpense $operationalExpense
    ): RedirectResponse {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
            ],
            'amount' => [
                'required',
                'numeric',
                'min:0',
            ],
            'expense_date' => [
                'required',
                'date',
            ],
            'notes' => [
                'nullable',
                'string',
            ],
        ]);

        $operationalExpense->update($validated);

        return redirect()
            ->route('operational-expenses.index')
            ->with(
                'success',
                'Operational expense updated successfully.'
            );
    }

    public function destroy(
        OperationalExpense $operationalExpense
    ): RedirectResponse {
        $operationalExpense->delete();

        return redirect()
            ->route('operational-expenses.index')
            ->with(
                'success',
                'Operational expense deleted successfully.'
            );
    }
}
