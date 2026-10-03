<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Distribution;
use App\Models\OperationalItem;
use App\Models\Product;
use App\Models\BaseDrink;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DistributionController extends Controller
{
    public function index(): View
    {
        $distributions = Distribution::with([
            'assignment.employee.user',
            'assignment.cart',
            'assignment.region',
            'productDetails.product',
            'operationalDetails.operationalItem',
        ])
            ->latest('distribution_date')
            ->latest()
            ->get();

        return view(
            'distributions.index',
            compact('distributions')
        );
    }

    public function create(): View
    {
        $assignments = Assignment::with([
            'employee.user',
            'cart',
            'region',
        ])
            ->where('status', 'Active')
            ->get();

        $baseDrinks = BaseDrink::where('status', 'Active')
            ->orderBy('name')
            ->get();

        $operationalItems = OperationalItem::where('status', 'Active')
            ->orderBy('name')
            ->get();

        return view('distributions.create', compact(
            'assignments',
            'baseDrinks',
            'operationalItems'
        ));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'assignment_id' => [
                'required',
                'exists:assignments,id',
            ],

            'distribution_date' => [
                'required',
                'date',
            ],

            'notes' => [
                'nullable',
                'string',
            ],

            'products' => [
                'nullable',
                'array',
            ],

            'products.*.product_id' => [
                'required',
                'exists:products,id',
            ],

            'products.*.quantity_distributed' => [
                'required',
                'numeric',
                'min:0.01',
            ],

            'operational_items' => [
                'nullable',
                'array',
            ],

            'operational_items.*.operational_item_id' => [
                'required',
                'exists:operational_items,id',
            ],

            'operational_items.*.quantity_distributed' => [
                'required',
                'integer',
                'min:1',
            ],
        ]);

        DB::transaction(function () use ($validated) {

            $distribution = Distribution::create([
                'assignment_id' => $validated['assignment_id'],
                'distribution_date' => $validated['distribution_date'],
                'notes' => $validated['notes'] ?? null,
            ]);

            foreach ($validated['products'] ?? [] as $item) {
                $distribution->productDetails()->create([
                    'product_id' => $item['product_id'],
                    'quantity_distributed' =>
                        $item['quantity_distributed'],
                ]);
            }

            foreach ($validated['operational_items'] ?? [] as $item) {

                $operationalItem = OperationalItem::findOrFail(
                    $item['operational_item_id']
                );

                $quantity = $item['quantity_distributed'];

                $distribution->operationalDetails()->create([
                    'operational_item_id' =>
                        $operationalItem->id,

                    'quantity_distributed' =>
                        $quantity,
                ]);

                $operationalItem->decrement(
                    'stock',
                    $quantity
                );
            }
        });

        return redirect()
            ->route('distributions.index')
            ->with(
                'success',
                'Distribution created successfully.'
            );
    }

    public function show(Distribution $distribution): View
    {
        $distribution->load([
            'assignment.employee.user',
            'assignment.cart',
            'assignment.region',
            'productDetails.product',
            'operationalDetails.operationalItem',
        ]);

        return view(
            'distributions.show',
            compact('distribution')
        );
    }

    public function edit(Distribution $distribution): View
    {
        $distribution->load([
            'productDetails',
            'operationalDetails',
        ]);

        $assignments = Assignment::with([
            'employee.user',
            'cart',
            'region',
        ])
            ->where('status', 'active')
            ->orWhere(
                'id',
                $distribution->assignment_id
            )
            ->latest('assignment_date')
            ->get();

        $products = Product::where('status', 'Active')
            ->orderBy('name')
            ->get();

        $operationalItems = OperationalItem::where('status', 'active')
            ->orWhereIn(
                'id',
                $distribution->operationalDetails
                    ->pluck('operational_item_id')
            )
            ->orderBy('name')
            ->get();

        return view(
            'distributions.edit',
            compact(
                'distribution',
                'assignments',
                'products',
                'operationalItems'
            )
        );
    }

    public function update(
        Request $request,
        Distribution $distribution
    ): RedirectResponse {
        $validated = $request->validate([
            'assignment_id' => [
                'required',
                'exists:assignments,id',
            ],

            'distribution_date' => [
                'required',
                'date',
            ],

            'notes' => [
                'nullable',
                'string',
            ],

            'products' => [
                'nullable',
                'array',
            ],

            'products.*.product_id' => [
                'required',
                'exists:products,id',
            ],

            'products.*.quantity_distributed' => [
                'required',
                'numeric',
                'min:0.01',
            ],

            'operational_items' => [
                'nullable',
                'array',
            ],

            'operational_items.*.operational_item_id' => [
                'required',
                'exists:operational_items,id',
            ],

            'operational_items.*.quantity_distributed' => [
                'required',
                'integer',
                'min:1',
            ],
        ]);

        DB::transaction(function () use (
            $validated,
            $distribution
        ) {

            /*
             * Restore previous operational stock
             */
            foreach (
                $distribution->operationalDetails
                as $detail
            ) {
                $detail->operationalItem->increment(
                    'stock',
                    $detail->quantity_distributed
                );
            }

            $distribution->update([
                'assignment_id' =>
                    $validated['assignment_id'],

                'distribution_date' =>
                    $validated['distribution_date'],

                'notes' =>
                    $validated['notes'] ?? null,
            ]);

            $distribution->productDetails()->delete();
            $distribution->operationalDetails()->delete();

            foreach ($validated['products'] ?? [] as $item) {
                $distribution->productDetails()->create([
                    'product_id' =>
                        $item['product_id'],

                    'quantity_distributed' =>
                        $item['quantity_distributed'],
                ]);
            }

            foreach (
                $validated['operational_items'] ?? []
                as $item
            ) {
                $operationalItem = OperationalItem::findOrFail(
                    $item['operational_item_id']
                );

                $quantity =
                    $item['quantity_distributed'];

                $distribution->operationalDetails()->create([
                    'operational_item_id' =>
                        $operationalItem->id,

                    'quantity_distributed' =>
                        $quantity,
                ]);

                $operationalItem->decrement(
                    'stock',
                    $quantity
                );
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
        DB::transaction(function () use ($distribution) {

            foreach (
                $distribution->operationalDetails
                as $detail
            ) {
                $detail->operationalItem->increment(
                    'stock',
                    $detail->quantity_distributed
                );
            }

            $distribution->delete();
        });

        return redirect()
            ->route('distributions.index')
            ->with(
                'success',
                'Distribution deleted successfully.'
            );
    }
}
