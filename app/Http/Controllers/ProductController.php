<?php

namespace App\Http\Controllers;

use App\Models\BaseDrink;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        $products = Product::with('baseDrink')
            ->latest()
            ->get();

        return view('products.index', compact('products'));
    }

    public function create(): View
    {
        $baseDrinks = BaseDrink::where('status', 'Active')
            ->orderBy('name')
            ->get();

        return view('products.create', compact('baseDrinks'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],

            'base_drink_id' => [
                'required',
                'exists:base_drinks,id',
            ],

            'price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'status' => [
                'required',
                'in:Active,Inactive',
            ],
        ]);

        Product::create($validated);

        return redirect()
            ->route('products.index')
            ->with('success', 'Product created successfully.');
    }

    public function show(Product $product)
    {
        //
    }

    public function edit(Product $product): View
    {
        $baseDrinks = BaseDrink::where('status', 'Active')
            ->orderBy('name')
            ->get();

        return view('products.edit', compact(
            'product',
            'baseDrinks'
        ));
    }

    public function update(
        Request $request,
        Product $product
    ): RedirectResponse {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],

            'base_drink_id' => [
                'required',
                'exists:base_drinks,id',
            ],

            'price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'status' => [
                'required',
                'in:Active,Inactive',
            ],
        ]);

        $product->update($validated);

        return redirect()
            ->route('products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', 'Product deleted successfully.');
    }
}
