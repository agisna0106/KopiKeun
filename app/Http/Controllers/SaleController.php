<?php

namespace App\Http\Controllers;

use App\Models\Distribution;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SaleController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index(): View
    {
        $sales = Sale::with([
            'distribution.assignment.employee.user',
            'details.product',
        ])
            ->latest('sale_date')
            ->latest()
            ->get();

        return view('sales.index', compact('sales'));
    }


    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

    public function create(): View
    {
        /*
        |--------------------------------------------------------------------------
        | Products
        |--------------------------------------------------------------------------
        */

        $products = Product::where('status', 'Active')
            ->orderBy('name')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Distributions
        |--------------------------------------------------------------------------
        |
        | Hanya distribution yang memiliki assignment aktif.
        |
        */

        $distributions = Distribution::with([
            'assignment.employee.user',
            'assignment.cart',
            'assignment.region',
        ])
            ->whereHas('assignment', function ($query) {
                $query->where('status', 'active');
            })
            ->latest('distribution_date')
            ->get();


        return view(
            'sales.create',
            compact(
                'products',
                'distributions'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'sale_source' => [
                'required',
                'in:Outlet,Employee',
            ],

            'distribution_id' => [
                'nullable',
                'exists:distributions,id',
            ],

            'sale_date' => [
                'nullable',
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


        /*
        |--------------------------------------------------------------------------
        | Employee Sale
        |--------------------------------------------------------------------------
        */

        if ($validated['sale_source'] === 'Employee') {

            if (empty($validated['distribution_id'])) {

                return back()
                    ->withErrors([
                        'distribution_id' =>
                            'Distribution is required for employee sales.',
                    ])
                    ->withInput();
            }


            /*
            |--------------------------------------------------------------------------
            | Ambil Distribution
            |--------------------------------------------------------------------------
            */

            $distribution = Distribution::with([
                'assignment.employee',
            ])->findOrFail(
                $validated['distribution_id']
            );


            /*
            |--------------------------------------------------------------------------
            | Pastikan Distribution memiliki Assignment
            |--------------------------------------------------------------------------
            */

            if (!$distribution->assignment) {

                return back()
                    ->withErrors([
                        'distribution_id' =>
                            'The selected distribution does not have an assignment.',
                    ])
                    ->withInput();
            }


            /*
            |--------------------------------------------------------------------------
            | Pastikan Assignment memiliki Employee
            |--------------------------------------------------------------------------
            */

            if (!$distribution->assignment->employee) {

                return back()
                    ->withErrors([
                        'distribution_id' =>
                            'The selected distribution does not have an employee.',
                    ])
                    ->withInput();
            }


            /*
            |--------------------------------------------------------------------------
            | Sale Date mengikuti Distribution Date
            |--------------------------------------------------------------------------
            */

            $validated['sale_date'] =
                $distribution->distribution_date;
        }


        /*
        |--------------------------------------------------------------------------
        | Outlet Sale
        |--------------------------------------------------------------------------
        |
        | Outlet tidak membutuhkan distribution.
        |
        */

        if ($validated['sale_source'] === 'Outlet') {

            if (!empty($validated['distribution_id'])) {

                return back()
                    ->withErrors([
                        'distribution_id' =>
                            'Distribution must be empty for outlet sales.',
                    ])
                    ->withInput();
            }


            if (empty($validated['sale_date'])) {

                return back()
                    ->withErrors([
                        'sale_date' =>
                            'Sale date is required for outlet sales.',
                    ])
                    ->withInput();
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Simpan Sale
        |--------------------------------------------------------------------------
        */

        DB::transaction(function () use ($validated) {

            $distributionId =
                $validated['sale_source'] === 'Employee'
                    ? $validated['distribution_id']
                    : null;


            /*
            |--------------------------------------------------------------------------
            | Ambil Employee dari Distribution
            |--------------------------------------------------------------------------
            */

            $employeeId = null;

            if ($validated['sale_source'] === 'Employee') {

                $distribution = Distribution::with([
                    'assignment.employee',
                ])->findOrFail(
                    $validated['distribution_id']
                );

                $employeeId =
                    $distribution->assignment->employee->id;
            }


            /*
            |--------------------------------------------------------------------------
            | Create Sale
            |--------------------------------------------------------------------------
            */

            $sale = Sale::create([
                'sale_source' => $validated['sale_source'],

                'distribution_id' =>
                    $distributionId,

                'sale_date' =>
                    $validated['sale_date'],

                'notes' =>
                    $validated['notes'] ?? null,
            ]);


            /*
            |--------------------------------------------------------------------------
            | Sale Details
            |--------------------------------------------------------------------------
            */

            foreach ($validated['products'] as $item) {

                $product = Product::findOrFail(
                    $item['product_id']
                );


                $quantity =
                    $item['quantity'];


                /*
                |--------------------------------------------------------------------------
                | Harga Produk
                |--------------------------------------------------------------------------
                */

                $unitPrice =
                    $product->price;


                /*
                |--------------------------------------------------------------------------
                | Total = Quantity × Product Price
                |--------------------------------------------------------------------------
                */

                $subtotal =
                    $quantity * $unitPrice;


                $sale->details()->create([
                    'product_id' =>
                        $product->id,

                    'quantity' =>
                        $quantity,

                    'unit_price' =>
                        $unitPrice,

                    'subtotal' =>
                        $subtotal,
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


    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */

    public function show(Sale $sale): View
    {
        $sale->load([
            'distribution.assignment.employee.user',
            'details.product',
        ]);

        return view(
            'sales.show',
            compact('sale')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    public function edit(Sale $sale): View
    {
        $sale->load([
            'details.product',
            'distribution.assignment.employee.user',
            'distribution.assignment.cart',
            'distribution.assignment.region',
        ]);

        $products = Product::where('status', 'Active')
            ->orderBy('name')
            ->get();

        $distributions = Distribution::with([
            'assignment.employee.user',
            'assignment.cart',
            'assignment.region',
        ])
            ->where('id', $sale->distribution_id)
            ->orWhereHas('assignment.employee', function ($query) {
                $query->where('status', 'Active');
            })
            ->latest('distribution_date')
            ->get();

        return view(
            'sales.edit',
            compact(
                'sale',
                'products',
                'distributions'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        Sale $sale
    ): RedirectResponse {
        $validated = $request->validate([
            'sale_source' => [
                'required',
                'in:Outlet,Employee',
            ],

            'distribution_id' => [
                'nullable',
                'exists:distributions,id',
            ],

            'sale_date' => [
                'nullable',
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
                'integer',
                'min:1',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Validate Sale Source
        |--------------------------------------------------------------------------
        */

        // Employee sale wajib memiliki distribution
        if (
            $validated['sale_source'] === 'Employee'
            && empty($validated['distribution_id'])
        ) {
            return back()
                ->withErrors([
                    'distribution_id' =>
                        'Distribution is required for employee sales.',
                ])
                ->withInput();
        }


        // Outlet sale tidak boleh memiliki distribution
        if (
            $validated['sale_source'] === 'Outlet'
            && !empty($validated['distribution_id'])
        ) {
            return back()
                ->withErrors([
                    'distribution_id' =>
                        'Distribution must be empty for outlet sales.',
                ])
                ->withInput();
        }


        /*
        |--------------------------------------------------------------------------
        | Get Distribution
        |--------------------------------------------------------------------------
        */

        $distribution = null;

        if (
            $validated['sale_source'] === 'Employee'
            && !empty($validated['distribution_id'])
        ) {

            $distribution = Distribution::with([
                'assignment.employee.user',
            ])->findOrFail(
                $validated['distribution_id']
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Update Sale
        |--------------------------------------------------------------------------
        */

        DB::transaction(function () use (
            $validated,
            $sale,
            $distribution
        ) {

            /*
            |--------------------------------------------------------------------------
            | Sale Date
            |--------------------------------------------------------------------------
            |
            | Employee:
            | date mengikuti distribution_date.
            |
            | Outlet:
            | date diambil dari form.
            |
            */

            $saleDate = $distribution
                ? $distribution->distribution_date
                : $validated['sale_date'];


            /*
            |--------------------------------------------------------------------------
            | Update Sale Header
            |--------------------------------------------------------------------------
            */

            $sale->update([
                'sale_source' => $validated['sale_source'],

                'distribution_id' => $distribution
                    ? $distribution->id
                    : null,

                'sale_date' => $saleDate,

                'notes' => $validated['notes'] ?? null,
            ]);


            /*
            |--------------------------------------------------------------------------
            | Replace Sale Details
            |--------------------------------------------------------------------------
            |
            | Detail lama dihapus terlebih dahulu,
            | kemudian dibuat ulang berdasarkan input terbaru.
            |
            */

            $sale->details()->delete();


            /*
            |--------------------------------------------------------------------------
            | Create New Sale Details
            |--------------------------------------------------------------------------
            */

            foreach ($validated['products'] as $item) {

                $product = Product::findOrFail(
                    $item['product_id']
                );

                $quantity = (int) $item['quantity'];


                /*
                |--------------------------------------------------------------------------
                | Product Price
                |--------------------------------------------------------------------------
                |
                | Harga jual diambil langsung dari harga Product.
                |
                */

                $unitPrice = (float) $product->price;


                /*
                |--------------------------------------------------------------------------
                | Subtotal
                |--------------------------------------------------------------------------
                |
                | Total = quantity × product price
                |
                */

                $subtotal = $quantity * $unitPrice;


                $sale->details()->create([
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'subtotal' => $subtotal,
                ]);
            }
        });


        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('sales.show', $sale)
            ->with(
                'success',
                'Sale updated successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | DESTROY
    |--------------------------------------------------------------------------
    */

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
