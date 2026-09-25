<?php

namespace App\Http\Controllers;

use App\Models\RawMaterial;
use App\Models\RawMaterialStockRecord;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class RawMaterialStockRecordController extends Controller
{
    public function index(): View
    {
        $stockRecords = RawMaterialStockRecord::with('rawMaterial')
            ->latest('recorded_at')
            ->latest()
            ->get();

        return view(
            'raw_material_stock_records.index',
            compact('stockRecords')
        );
    }

    public function create(): View
    {
        $rawMaterials = RawMaterial::where('status', 'Active')
            ->orderBy('name')
            ->get();

        return view(
            'raw_material_stock_records.create',
            compact('rawMaterials')
        );
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'raw_material_id' => [
                'required',
                'exists:raw_materials,id',
            ],
            'stock' => [
                'required',
                'numeric',
                'min:0',
            ],
            'recorded_at' => [
                'required',
                'date',
            ],
            'notes' => [
                'nullable',
                'string',
            ],
        ]);

        DB::transaction(function () use ($validated) {
            RawMaterialStockRecord::create($validated);

            RawMaterial::where('id', $validated['raw_material_id'])
                ->update([
                    'current_stock' => $validated['stock'],
                ]);
        });

        return redirect()
            ->route('raw-material-stock-records.index')
            ->with(
                'success',
                'Stock record created successfully.'
            );
    }

    public function show(RawMaterialStockRecord $rawMaterialStockRecord)
    {
        //
    }

    public function edit(
        RawMaterialStockRecord $rawMaterialStockRecord
    ): View {
        $rawMaterials = RawMaterial::where('status', 'Active')
            ->orderBy('name')
            ->get();

        return view(
            'raw_material_stock_records.edit',
            compact(
                'rawMaterialStockRecord',
                'rawMaterials'
            )
        );
    }

    public function update(
        Request $request,
        RawMaterialStockRecord $rawMaterialStockRecord
    ): RedirectResponse {
        $validated = $request->validate([
            'raw_material_id' => [
                'required',
                'exists:raw_materials,id',
            ],
            'stock' => [
                'required',
                'numeric',
                'min:0',
            ],
            'recorded_at' => [
                'required',
                'date',
            ],
            'notes' => [
                'nullable',
                'string',
            ],
        ]);

        DB::transaction(function () use (
            $validated,
            $rawMaterialStockRecord
        ) {
            $rawMaterialStockRecord->update($validated);

            RawMaterial::where('id', $validated['raw_material_id'])
                ->update([
                    'current_stock' => $validated['stock'],
                ]);
        });

        return redirect()
            ->route('raw-material-stock-records.index')
            ->with(
                'success',
                'Stock record updated successfully.'
            );
    }

    public function destroy(RawMaterialStockRecord $rawMaterialStockRecord): RedirectResponse {
        DB::transaction(function () use ($rawMaterialStockRecord) {

            $rawMaterialId = $rawMaterialStockRecord->raw_material_id;

            $rawMaterialStockRecord->delete();

            $latestRecord = RawMaterialStockRecord::where(
                'raw_material_id',
                $rawMaterialId
            )
                ->latest('recorded_at')
                ->latest()
                ->first();

            RawMaterial::where('id', $rawMaterialId)
                ->update([
                    'current_stock' => $latestRecord?->stock ?? 0,
                ]);
        });

        return redirect()
            ->route('raw-material-stock-records.index')
            ->with(
                'success',
                'Stock record deleted successfully.'
            );
    }
}
