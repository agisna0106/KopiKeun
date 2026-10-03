<?php

namespace App\Http\Controllers;

use App\Models\Region;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RegionController extends Controller
{
    public function index(): View
    {
        $regions = Region::latest()->get();

        return view('regions.index', compact('regions'));
    }

    public function create(): View
    {
        return view('regions.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'status' => [
                'required',
                'in:active,inactive',
            ],
        ]);

        Region::create($validated);

        return redirect()
            ->route('regions.index')
            ->with('success', 'Region created successfully.');
    }

    public function edit(Region $region): View
    {
        return view('regions.edit', compact('region'));
    }

    public function update(
        Request $request,
        Region $region
    ): RedirectResponse {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'status' => [
                'required',
                'in:active,inactive',
            ],
        ]);

        $region->update($validated);

        return redirect()
            ->route('regions.index')
            ->with('success', 'Region updated successfully.');
    }
}
