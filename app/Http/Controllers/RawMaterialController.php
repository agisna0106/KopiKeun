<?php

namespace App\Http\Controllers;

use App\Models\RawMaterial;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RawMaterialController extends Controller
{
    public function index(): View
    {
        $rawMaterials = RawMaterial::latest()->get();

        return view('raw_materials.index', compact('rawMaterials'));
    }

    public function create(): View
    {
        return view('raw_materials.create');
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
                'max:20',
            ],
            'current_stock' => [
                'required',
                'numeric',
                'min:0',
            ],
            'minimum_stock' => [
                'required',
                'numeric',
                'min:0',
            ],
            'status' => [
                'required',
                'in:Active,Inactive',
            ],
        ]);

        RawMaterial::create($validated);

        return redirect()
            ->route('raw-materials.index')
            ->with('success', 'Raw material created successfully.');
    }

    public function show(RawMaterial $rawMaterial)
    {
        //
    }

    public function edit(RawMaterial $rawMaterial): View
    {
        return view(
            'raw_materials.edit',
            compact('rawMaterial')
        );
    }

    public function update(
        Request $request,
        RawMaterial $rawMaterial
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
                'max:20',
            ],
            'current_stock' => [
                'required',
                'numeric',
                'min:0',
            ],
            'minimum_stock' => [
                'required',
                'numeric',
                'min:0',
            ],
            'status' => [
                'required',
                'in:Active,Inactive',
            ],
        ]);

        $rawMaterial->update($validated);

        return redirect()
            ->route('raw-materials.index')
            ->with('success', 'Raw material updated successfully.');
    }

    public function destroy(
        RawMaterial $rawMaterial
    ): RedirectResponse {
        $rawMaterial->delete();

        return redirect()
            ->route('raw-materials.index')
            ->with('success', 'Raw material deleted successfully.');
    }
}
