<?php

namespace App\Http\Controllers;

use App\Models\BaseDrink;
use App\Models\RemainingProduct;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class RemainingProductController extends Controller
{
    public function index(): View
    {
        $remainingProducts = RemainingProduct::with([
            'details.baseDrink',
        ])
            ->latest('recorded_at')
            ->latest()
            ->get();

        return view(
            'remaining-products.index',
            compact('remainingProducts')
        );
    }

    public function create(): View
    {
        $baseDrinks = BaseDrink::where('status', 'Active')
            ->orderBy('name')
            ->get();

        return view(
            'remaining-products.create',
            compact('baseDrinks')
        );
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'recorded_at' => ['required', 'date'],
            'notes' => ['nullable', 'string'],

            'base_drinks' => [
                'required',
                'array',
                'min:1',
            ],

            'base_drinks.*.base_drink_id' => [
                'required',
                'exists:base_drinks,id',
            ],

            'base_drinks.*.quantity' => [
                'required',
                'numeric',
                'min:0',
            ],
        ]);

        DB::transaction(function () use ($validated) {
            $remainingProduct = RemainingProduct::create([
                'recorded_at' => $validated['recorded_at'],
                'notes' => $validated['notes'] ?? null,
            ]);

            foreach ($validated['base_drinks'] as $item) {
                $remainingProduct->details()->create([
                    'base_drink_id' => $item['base_drink_id'],
                    'quantity' => $item['quantity'],
                ]);
            }
        });

        return redirect()
            ->route('remaining-products.index')
            ->with(
                'success',
                'Remaining product recorded successfully.'
            );
    }

    public function show(
        RemainingProduct $remainingProduct
    ): View {
        $remainingProduct->load([
            'details.baseDrink',
        ]);

        return view(
            'remaining-products.show',
            compact('remainingProduct')
        );
    }

    public function edit(
        RemainingProduct $remainingProduct
    ): View {
        $remainingProduct->load('details');

        $baseDrinks = BaseDrink::where('status', 'Active')
            ->orderBy('name')
            ->get();

        return view(
            'remaining-products.edit',
            compact(
                'remainingProduct',
                'baseDrinks'
            )
        );
    }

    public function update(
        Request $request,
        RemainingProduct $remainingProduct
    ): RedirectResponse {
        $validated = $request->validate([
            'recorded_at' => ['required', 'date'],
            'notes' => ['nullable', 'string'],

            'base_drinks' => [
                'required',
                'array',
                'min:1',
            ],

            'base_drinks.*.base_drink_id' => [
                'required',
                'exists:base_drinks,id',
            ],

            'base_drinks.*.quantity' => [
                'required',
                'numeric',
                'min:0',
            ],
        ]);

        DB::transaction(function () use (
            $validated,
            $remainingProduct
        ) {
            $remainingProduct->update([
                'recorded_at' => $validated['recorded_at'],
                'notes' => $validated['notes'] ?? null,
            ]);

            $remainingProduct->details()->delete();

            foreach ($validated['base_drinks'] as $item) {
                $remainingProduct->details()->create([
                    'base_drink_id' => $item['base_drink_id'],
                    'quantity' => $item['quantity'],
                ]);
            }
        });

        return redirect()
            ->route('remaining-products.index')
            ->with(
                'success',
                'Remaining product updated successfully.'
            );
    }

    public function destroy(
        RemainingProduct $remainingProduct
    ): RedirectResponse {
        $remainingProduct->delete();

        return redirect()
            ->route('remaining-products.index')
            ->with(
                'success',
                'Remaining product deleted successfully.'
            );
    }
}
