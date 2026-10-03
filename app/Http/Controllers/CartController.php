<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(): View
    {
        $carts = Cart::latest()->get();

        return view('carts.index', compact('carts'));
    }

    public function create(): View
    {
        return view('carts.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'code' => [
                'required',
                'string',
                'max:50',
                'unique:carts,code',
            ],

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

        Cart::create($validated);

        return redirect()
            ->route('carts.index')
            ->with('success', 'Cart created successfully.');
    }

    public function edit(Cart $cart): View
    {
        return view('carts.edit', compact('cart'));
    }

    public function update(
        Request $request,
        Cart $cart
    ): RedirectResponse {
        $validated = $request->validate([
            'code' => [
                'required',
                'string',
                'max:50',
                'unique:carts,code,' . $cart->id,
            ],

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

        $cart->update($validated);

        return redirect()
            ->route('carts.index')
            ->with('success', 'Cart updated successfully.');
    }
}
