<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\Employee;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SaleController extends Controller
{
    public function index(): View
    {
        $sales = Sale::with([
            'employee.user',
            'details.product',
        ])
            ->latest('sale_date')
            ->latest()
            ->get();

        return view(
            'sales.index',
            compact('sales')
        );
    }

    public function create(): View
    {
        $products = Product::where('status', 'Active')
            ->orderBy('name')
            ->get();

        $employees = Employee::with('user')
            ->where('status', 'Active')
            ->whereHas('user.role', function ($query) {
                $query->where('nama_role', 'Karyawan');
            })
            ->orderBy('employee_code')
            ->get();

        return view(
            'sales.create',
            compact(
                'products',
                'employees'
            )
        );
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'sale_source' => [
                'required',
                'in:Outlet,Employee',
            ],

            'employee_id' => [
                'nullable',
                'exists:employees,id',
            ],

            'sale_date' => [
                'required',
                'date',
            ],

            'notes' => [
                'nullable',
                'string',
            ],

            'products' => [
                'required',
                'array',
                'min:1',
            ],

            'products.*.product_id' => [
                'required',
                'exists:products,id',
            ],

            'products.*.quantity' => [
                'required',
                'numeric',
                'min:0.01',
            ],
        ]);

        if (
            $validated['sale_source'] === 'Employee'
            && empty($validated['employee_id'])
        ) {
            return back()
                ->withErrors([
                    'employee_id' =>
                        'Employee is required for employee sales.',
                ])
                ->withInput();
        }

        if (
            $validated['sale_source'] === 'Outlet'
            && !empty($validated['employee_id'])
        ) {
            return back()
                ->withErrors([
                    'employee_id' =>
                        'Employee must be empty for outlet sales.',
                ])
                ->withInput();
        }

        DB::transaction(function () use ($validated) {

            $sale = Sale::create([
                'sale_source' => $validated['sale_source'],
                'employee_id' => $validated['employee_id'] ?? null,
                'sale_date' => $validated['sale_date'],
                'notes' => $validated['notes'] ?? null,
            ]);

            foreach ($validated['products'] as $item) {

                $product = Product::findOrFail(
                    $item['product_id']
                );

                $quantity = $item['quantity'];
                $unitPrice = $product->price;

                $subtotal = $quantity * $unitPrice;

                $sale->details()->create([
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'subtotal' => $subtotal,
                ]);
            }
        });

        return redirect()
            ->route('sales.index')
            ->with(
                'success',
                'Sale recorded successfully.'
            );
    }

    public function show(Sale $sale): View
    {
        $sale->load([
            'employee.user',
            'details.product',
        ]);

        return view(
            'sales.show',
            compact('sale')
        );
    }

    public function edit(Sale $sale): View
    {
        $sale->load('details');

        $products = Product::where('status', 'Active')
            ->orderBy('name')
            ->get();

        $employees = Employee::with('user')
            ->where('status', 'Active')
            ->whereHas('user.role', function ($query) {
                $query->where('nama_role', 'Karyawan');
            })
            ->orderBy('employee_code')
            ->get();

        return view(
            'sales.edit',
            compact(
                'sale',
                'products',
                'employees'
            )
        );
    }

    public function update(
        Request $request,
        Sale $sale
    ): RedirectResponse {
        $validated = $request->validate([
            'sale_source' => [
                'required',
                'in:Outlet,Employee',
            ],

            'employee_id' => [
                'nullable',
                'exists:employees,id',
            ],

            'sale_date' => [
                'required',
                'date',
            ],

            'notes' => [
                'nullable',
                'string',
            ],

            'products' => [
                'required',
                'array',
                'min:1',
            ],

            'products.*.product_id' => [
                'required',
                'exists:products,id',
            ],

            'products.*.quantity' => [
                'required',
                'numeric',
                'min:0.01',
            ],
        ]);

        if (
            $validated['sale_source'] === 'Employee'
            && empty($validated['employee_id'])
        ) {
            return back()
                ->withErrors([
                    'employee_id' =>
                        'Employee is required for employee sales.',
                ])
                ->withInput();
        }

        if (
            $validated['sale_source'] === 'Outlet'
            && !empty($validated['employee_id'])
        ) {
            return back()
                ->withErrors([
                    'employee_id' =>
                        'Employee must be empty for outlet sales.',
                ])
                ->withInput();
        }

        DB::transaction(function () use (
            $validated,
            $sale
        ) {
            $sale->update([
                'sale_source' => $validated['sale_source'],
                'employee_id' => $validated['employee_id'] ?? null,
                'sale_date' => $validated['sale_date'],
                'notes' => $validated['notes'] ?? null,
            ]);

            $sale->details()->delete();

            foreach ($validated['products'] as $item) {

                $product = Product::findOrFail(
                    $item['product_id']
                );

                $quantity = $item['quantity'];
                $unitPrice = $product->price;

                $subtotal = $quantity * $unitPrice;

                $sale->details()->create([
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'subtotal' => $subtotal,
                ]);
            }
        });

        return redirect()
            ->route('sales.index')
            ->with(
                'success',
                'Sale updated successfully.'
            );
    }

    public function destroy(
        Sale $sale
    ): RedirectResponse {
        $sale->delete();

        return redirect()
            ->route('sales.index')
            ->with(
                'success',
                'Sale deleted successfully.'
            );
    }
}
