<?php

namespace App\Http\Controllers;

use App\Models\OperationalItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OperationalItemController extends Controller
{
    public function index(): View
    {
        $operationalItems = OperationalItem::latest()->get();

        return view(
            'operational-items.index',
            compact('operationalItems')
        );
    }

    public function create(): View
    {
        return view('operational-items.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
            ],

            'unit' => [
                'required',
                'string',
                'max:50',
            ],

            'stock' => [
                'required',
                'integer',
                'min:0',
            ],

            'minimum_stock' => [
                'required',
                'integer',
                'min:0',
            ],

            'status' => [
                'required',
                'in:active,inactive',
            ],
        ]);

        OperationalItem::create($validated);

        return redirect()
            ->route('operational-items.index')
            ->with(
                'success',
                'Operational item created successfully.'
            );
    }

    public function edit(OperationalItem $operationalItem): View
    {
        return view(
            'operational-items.edit',
            compact('operationalItem')
        );
    }

    public function update(
        Request $request,
        OperationalItem $operationalItem
    ): RedirectResponse {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
            ],

            'unit' => [
                'required',
                'string',
                'max:50',
            ],

            'stock' => [
                'required',
                'integer',
                'min:0',
            ],

            'minimum_stock' => [
                'required',
                'integer',
                'min:0',
            ],

            'status' => [
                'required',
                'in:active,inactive',
            ],
        ]);

        $operationalItem->update($validated);

        return redirect()
            ->route('operational-items.index')
            ->with(
                'success',
                'Operational item updated successfully.'
            );
    }
}
