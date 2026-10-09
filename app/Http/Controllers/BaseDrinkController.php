<?php

namespace App\Http\Controllers;

use App\Models\BaseDrink;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Database\QueryException;

class BaseDrinkController extends Controller
{
    /**
     * Display a listing of base drinks.
     */
    public function index(): View
    {
        $baseDrinks = BaseDrink::latest()->get();

        return view('base-drinks.index', compact('baseDrinks'));
    }

    /**
     * Show the form for creating a new base drink.
     */
    public function create(): View
    {
        return view('base-drinks.create');
    }

    /**
     * Store a newly created base drink.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
            ],

            'bottle_capacity_ml' => [
                'required',
                'numeric',
                'gt:0',
                'decimal:0,2',
            ],

            'standard_serving_ml' => [
                'required',
                'numeric',
                'gt:0',
                'decimal:0,2',
                'lte:bottle_capacity_ml',
            ],

            'status' => [
                'required',
                'in:Active,Inactive',
            ],
        ]);

        BaseDrink::create($validated);

        return redirect()
            ->route('base-drinks.index')
            ->with('success', 'Base drink created successfully.');
    }

    /**
     * Show the form for editing the specified base drink.
     */
    public function edit(BaseDrink $baseDrink): View
    {
        return view('base-drinks.edit', compact('baseDrink'));
    }

    /**
     * Update the specified base drink.
     */
    public function update(
        Request $request,
        BaseDrink $baseDrink
    ): RedirectResponse {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
            ],

            'bottle_capacity_ml' => [
                'required',
                'numeric',
                'gt:0',
                'decimal:0,2',
            ],

            'standard_serving_ml' => [
                'required',
                'numeric',
                'gt:0',
                'decimal:0,2',
                'lte:bottle_capacity_ml',
            ],

            'status' => [
                'required',
                'in:Active,Inactive',
            ],
        ]);

        $baseDrink->update($validated);

        return redirect()
            ->route('base-drinks.index')
            ->with('success', 'Base drink updated successfully.');
    }

    /**
     * Delete the specified base drink.
     */
    public function destroy(BaseDrink $baseDrink): RedirectResponse
    {
        try {
            $baseDrink->delete();
        } catch (QueryException $exception) {
            return redirect()
                ->route('base-drinks.index')
                ->with(
                    'error',
                    'This base drink cannot be deleted because it is still used by existing products or distribution details.'
                );
        }

        return redirect()
            ->route('base-drinks.index')
            ->with('success', 'Base drink deleted successfully.');
    }
}
