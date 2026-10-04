<?php

namespace App\Http\Controllers;

use App\Models\Distribution;
use App\Models\Employee;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SaleController extends Controller
{
    /**
     * Display a listing of sales.
     */
    public function index(): View
    {
        $sales = Sale::with([
            'distribution.assignment.employee.user',
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


    /**
     * Show the form for creating a new sale.
     */
    public function create(): View
    {
        /*
        |--------------------------------------------------------------------------
        | Active Products
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
        | Employee sales are recorded based on distributions.
        | Therefore, we only load distributions that already have
        | an assignment and employee.
        |
        */

        $distributions = Distribution::with([
            'assignment.employee.user',
            'assignment.cart',
            'assignment.region',
        ])
            ->whereHas('assignment.employee')
            ->latest('distribution_date')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Employees
        |--------------------------------------------------------------------------
        |
        | This is still loaded in case the view needs employee information,
        | but employee sales should NOT select employee directly.
        |
        */

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
                'distributions',
                'employees'
            )
        );
    }


    /**
     * Store a newly created sale.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            /*
            |--------------------------------------------------------------------------
            | Sale Source
            |--------------------------------------------------------------------------
            */

            'sale_source' => [
                'required',
                'in:Outlet,Employee',
            ],


            /*
            |--------------------------------------------------------------------------
            | Distribution
            |--------------------------------------------------------------------------
            |
            | Required only for Employee sales.
            |
            */

            'distribution_id' => [
                'nullable',
                'exists:distributions,id',
            ],


            /*
            |--------------------------------------------------------------------------
            | Sale Date
            |--------------------------------------------------------------------------
            |
            | Only used for Outlet sales.
            | Employee sales will use distribution_date.
            |
            */

            'sale_date' => [
                'nullable',
                'date',
            ],


            /*
            |--------------------------------------------------------------------------
            | Notes
            |--------------------------------------------------------------------------
            */

            'notes' => [
                'nullable',
                'string',
            ],


            /*
            |--------------------------------------------------------------------------
            | Sale Details
            |--------------------------------------------------------------------------
            */

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
        | Employee Sale Validation
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
            | Load Distribution
            |--------------------------------------------------------------------------
            */

            $distribution = Distribution::with([
                'assignment.employee',
            ])->findOrFail(
                $validated['distribution_id']
            );


            /*
            |--------------------------------------------------------------------------
            | Make Sure Distribution Has Employee
            |--------------------------------------------------------------------------
            */

            if (
                !$distribution->assignment ||
                !$distribution->assignment->employee
            ) {

                return back()
                    ->withErrors([
                        'distribution_id' =>
                            'The selected distribution is not associated with an employee.',
                    ])
                    ->withInput();
            }


            /*
            |--------------------------------------------------------------------------
            | Sale Date Comes From Distribution
            |--------------------------------------------------------------------------
            */

            $saleDate = $distribution->distribution_date;

        } else {

            /*
            |--------------------------------------------------------------------------
            | Outlet Sale
            |--------------------------------------------------------------------------
            |
            | Outlet sales do not use distribution or employee.
            |
            */

            if (!empty($validated['distribution_id'])) {

                return back()
                    ->withErrors([
                        'distribution_id' =>
                            'Distribution must be empty for outlet sales.',
                    ])
                    ->withInput();
            }


            /*
            |--------------------------------------------------------------------------
            | Outlet Sale Requires Manual Date
            |--------------------------------------------------------------------------
            */

            if (empty($validated['sale_date'])) {

                return back()
                    ->withErrors([
                        'sale_date' =>
                            'Sale date is required for outlet sales.',
                    ])
                    ->withInput();
            }


            $saleDate = $validated['sale_date'];
        }


        /*
        |--------------------------------------------------------------------------
        | Save Sale
        |--------------------------------------------------------------------------
        */

        DB::transaction(function () use (
            $validated,
            $saleDate
        ) {

            /*
            |--------------------------------------------------------------------------
            | Determine Employee
            |--------------------------------------------------------------------------
            */

            $employeeId = null;
            $distributionId = null;

            if (
                $validated['sale_source'] === 'Employee'
            ) {

                $distribution = Distribution::with([
                    'assignment.employee',
                ])->findOrFail(
                    $validated['distribution_id']
                );

                $distributionId =
                    $distribution->id;

                $employeeId =
                    $distribution
                        ->assignment
                        ->employee
                        ->id;
            }


            /*
            |--------------------------------------------------------------------------
            | Create Sale
            |--------------------------------------------------------------------------
            */

            $sale = Sale::create([
                'sale_source' =>
                    $validated['sale_source'],

                'distribution_id' =>
                    $distributionId,

                'employee_id' =>
                    $employeeId,

                'sale_date' =>
                    $saleDate,

                'notes' =>
                    $validated['notes'] ?? null,
            ]);


            /*
            |--------------------------------------------------------------------------
            | Create Sale Details
            |--------------------------------------------------------------------------
            */

            foreach (
                $validated['products']
                as $item
            ) {

                $product = Product::findOrFail(
                    $item['product_id']
                );


                /*
                |--------------------------------------------------------------------------
                | Quantity
                |--------------------------------------------------------------------------
                */

                $quantity =
                    $item['quantity'];


                /*
                |--------------------------------------------------------------------------
                | Selling Price
                |--------------------------------------------------------------------------
                |
                | Selling price = quantity × product price.
                |
                */

                $unitPrice =
                    $product->price;


                $subtotal =
                    $quantity * $unitPrice;


                /*
                |--------------------------------------------------------------------------
                | Create Detail
                |--------------------------------------------------------------------------
                */

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


    /**
     * Display the specified sale.
     */
    public function show(
        Sale $sale
    ): View {

        $sale->load([
            'distribution.assignment.employee.user',
            'distribution.assignment.cart',
            'distribution.assignment.region',
            'employee.user',
            'details.product',
        ]);

        return view(
            'sales.show',
            compact('sale')
        );
    }


    /**
     * Show the form for editing the specified sale.
     */
    public function edit(
        Sale $sale
    ): View {

        $sale->load([
            'distribution.assignment.employee.user',
            'distribution.assignment.cart',
            'distribution.assignment.region',
            'details.product',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Active Products
        |--------------------------------------------------------------------------
        */

        $products = Product::where('status', 'Active')
            ->orderBy('name')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Distributions
        |--------------------------------------------------------------------------
        */

        $distributions = Distribution::with([
            'assignment.employee.user',
            'assignment.cart',
            'assignment.region',
        ])
            ->whereHas('assignment.employee')
            ->latest('distribution_date')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Employees
        |--------------------------------------------------------------------------
        |
        | Kept available for compatibility with the view,
        | but employee should not be selected directly.
        |
        */

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
                'distributions',
                'employees'
            )
        );
    }


    /**
     * Update the specified sale.
     */
    public function update(
        Request $request,
        Sale $sale
    ): RedirectResponse {

        $validated = $request->validate([
            /*
            |--------------------------------------------------------------------------
            | Sale Source
            |--------------------------------------------------------------------------
            */

            'sale_source' => [
                'required',
                'in:Outlet,Employee',
            ],


            /*
            |--------------------------------------------------------------------------
            | Distribution
            |--------------------------------------------------------------------------
            */

            'distribution_id' => [
                'nullable',
                'exists:distributions,id',
            ],


            /*
            |--------------------------------------------------------------------------
            | Sale Date
            |--------------------------------------------------------------------------
            |
            | Used only for Outlet sales.
            |
            */

            'sale_date' => [
                'nullable',
                'date',
            ],


            /*
            |--------------------------------------------------------------------------
            | Notes
            |--------------------------------------------------------------------------
            */

            'notes' => [
                'nullable',
                'string',
            ],


            /*
            |--------------------------------------------------------------------------
            | Sale Details
            |--------------------------------------------------------------------------
            */

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


            $distribution = Distribution::with([
                'assignment.employee',
            ])->findOrFail(
                $validated['distribution_id']
            );


            if (
                !$distribution->assignment ||
                !$distribution->assignment->employee
            ) {

                return back()
                    ->withErrors([
                        'distribution_id' =>
                            'The selected distribution is not associated with an employee.',
                    ])
                    ->withInput();
            }


            /*
            |--------------------------------------------------------------------------
            | Date Comes From Distribution
            |--------------------------------------------------------------------------
            */

            $saleDate =
                $distribution->distribution_date;

        } else {

            /*
            |--------------------------------------------------------------------------
            | Outlet Sale
            |--------------------------------------------------------------------------
            */

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


            $saleDate =
                $validated['sale_date'];
        }


        /*
        |--------------------------------------------------------------------------
        | Update Sale
        |--------------------------------------------------------------------------
        */

        DB::transaction(function () use (
            $validated,
            $sale,
            $saleDate
        ) {

            $employeeId = null;
            $distributionId = null;


            /*
            |--------------------------------------------------------------------------
            | Employee Sale
            |--------------------------------------------------------------------------
            */

            if (
                $validated['sale_source'] === 'Employee'
            ) {

                $distribution =
                    Distribution::with([
                        'assignment.employee',
                    ])->findOrFail(
                        $validated['distribution_id']
                    );


                $distributionId =
                    $distribution->id;


                $employeeId =
                    $distribution
                        ->assignment
                        ->employee
                        ->id;
            }


            /*
            |--------------------------------------------------------------------------
            | Update Main Sale
            |--------------------------------------------------------------------------
            */

            $sale->update([
                'sale_source' =>
                    $validated['sale_source'],

                'distribution_id' =>
                    $distributionId,

                'employee_id' =>
                    $employeeId,

                'sale_date' =>
                    $saleDate,

                'notes' =>
                    $validated['notes'] ?? null,
            ]);


            /*
            |--------------------------------------------------------------------------
            | Replace Details
            |--------------------------------------------------------------------------
            */

            $sale->details()->delete();


            foreach (
                $validated['products']
                as $item
            ) {

                $product = Product::findOrFail(
                    $item['product_id']
                );


                $quantity =
                    $item['quantity'];


                $unitPrice =
                    $product->price;


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
                'Sale updated successfully.'
            );
    }


    /**
     * Remove the specified sale.
     */
    public function destroy(
        Sale $sale
    ): RedirectResponse {

        DB::transaction(function () use ($sale) {

            /*
            |--------------------------------------------------------------------------
            | Sale Details
            |--------------------------------------------------------------------------
            |
            | The sale_details records are automatically deleted
            | because sale_details.sale_id uses cascadeOnDelete().
            |
            */

            $sale->delete();
        });


        return redirect()
            ->route('sales.index')
            ->with(
                'success',
                'Sale deleted successfully.'
            );
    }
}
