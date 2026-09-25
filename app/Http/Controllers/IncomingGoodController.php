<?php

namespace App\Http\Controllers;

use App\Models\IncomingGood;
use App\Models\RawMaterial;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class IncomingGoodController extends Controller
{
    public function index(): View
    {
        $incomingGoods = IncomingGood::with('rawMaterial')
            ->latest('received_at')
            ->latest()
            ->get();

        return view(
            'incoming_goods.index',
            compact('incomingGoods')
        );
    }

    public function create(): View
    {
        $rawMaterials = RawMaterial::where('status', 'Active')
            ->orderBy('name')
            ->get();

        return view(
            'incoming_goods.create',
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
            'quantity' => [
                'required',
                'numeric',
                'min:0.01',
            ],
            'unit_cost' => [
                'required',
                'numeric',
                'min:0',
            ],
            'received_at' => [
                'required',
                'date',
            ],
            'supplier' => [
                'nullable',
                'string',
                'max:100',
            ],
            'notes' => [
                'nullable',
                'string',
            ],
        ]);

        DB::transaction(function () use ($validated) {
            IncomingGood::create($validated);

            RawMaterial::where(
                'id',
                $validated['raw_material_id']
            )->increment(
                'current_stock',
                $validated['quantity']
            );
        });

        return redirect()
            ->route('incoming-goods.index')
            ->with(
                'success',
                'Incoming goods recorded successfully.'
            );
    }

    public function edit(IncomingGood $incomingGood): View
    {
        $rawMaterials = RawMaterial::where('status', 'Active')
            ->orderBy('name')
            ->get();

        return view(
            'incoming_goods.edit',
            compact(
                'incomingGood',
                'rawMaterials'
            )
        );
    }

    public function update(
        Request $request,
        IncomingGood $incomingGood
    ): RedirectResponse {
        $validated = $request->validate([
            'raw_material_id' => [
                'required',
                'exists:raw_materials,id',
            ],
            'quantity' => [
                'required',
                'numeric',
                'min:0.01',
            ],
            'unit_cost' => [
                'required',
                'numeric',
                'min:0',
            ],
            'received_at' => [
                'required',
                'date',
            ],
            'supplier' => [
                'nullable',
                'string',
                'max:100',
            ],
            'notes' => [
                'nullable',
                'string',
            ],
        ]);

        DB::transaction(function () use (
            $validated,
            $incomingGood
        ) {
            $oldRawMaterialId = $incomingGood->raw_material_id;
            $oldQuantity = $incomingGood->quantity;

            RawMaterial::where(
                'id',
                $oldRawMaterialId
            )->decrement(
                'current_stock',
                $oldQuantity
            );

            $incomingGood->update($validated);

            RawMaterial::where(
                'id',
                $validated['raw_material_id']
            )->increment(
                'current_stock',
                $validated['quantity']
            );
        });

        return redirect()
            ->route('incoming-goods.index')
            ->with(
                'success',
                'Incoming goods updated successfully.'
            );
    }

    public function destroy(
        IncomingGood $incomingGood
    ): RedirectResponse {
        DB::transaction(function () use ($incomingGood) {
            RawMaterial::where(
                'id',
                $incomingGood->raw_material_id
            )->decrement(
                'current_stock',
                $incomingGood->quantity
            );

            $incomingGood->delete();
        });

        return redirect()
            ->route('incoming-goods.index')
            ->with(
                'success',
                'Incoming goods deleted successfully.'
            );
    }
}
