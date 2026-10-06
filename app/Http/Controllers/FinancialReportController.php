<?php

namespace App\Http\Controllers;

use App\Models\IncomingGood;
use App\Models\OperationalExpense;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FinancialReportController extends Controller
{
    public function index(Request $request): View
    {
        /*
        |--------------------------------------------------------------------------
        | Report Period
        |--------------------------------------------------------------------------
        */

        $startDate = $request->input(
            'start_date',
            now('Asia/Jakarta')
                ->startOfMonth()
                ->format('Y-m-d')
        );

        $endDate = $request->input(
            'end_date',
            now('Asia/Jakarta')
                ->format('Y-m-d')
        );


        /*
        |--------------------------------------------------------------------------
        | SALES / INCOME
        |--------------------------------------------------------------------------
        */

        $salesForSummary = Sale::with('details')
            ->whereDate('sale_date', '>=', $startDate)
            ->whereDate('sale_date', '<=', $endDate)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Outlet Income
        |--------------------------------------------------------------------------
        */

        $outletIncome = $salesForSummary
            ->where('sale_source', 'Outlet')
            ->sum(function ($sale) {

                return $sale->details->sum('subtotal');

            });


        /*
        |--------------------------------------------------------------------------
        | Employee Income
        |--------------------------------------------------------------------------
        */

        $employeeIncome = $salesForSummary
            ->where('sale_source', 'Employee')
            ->sum(function ($sale) {

                return $sale->details->sum('subtotal');

            });


        /*
        |--------------------------------------------------------------------------
        | Total Income
        |--------------------------------------------------------------------------
        */

        $totalIncome =
            $outletIncome +
            $employeeIncome;


        /*
        |--------------------------------------------------------------------------
        | INCOMING GOODS EXPENSE
        |--------------------------------------------------------------------------
        */

        $incomingGoodsForSummary = IncomingGood::query()
            ->whereDate('received_at', '>=', $startDate)
            ->whereDate('received_at', '<=', $endDate)
            ->get();


        $incomingGoodsExpense = $incomingGoodsForSummary
            ->sum(function ($item) {

                return $item->quantity *
                    $item->unit_cost;

            });


        /*
        |--------------------------------------------------------------------------
        | OPERATIONAL EXPENSE
        |--------------------------------------------------------------------------
        */

        $operationalExpense = OperationalExpense::query()
            ->whereDate('expense_date', '>=', $startDate)
            ->whereDate('expense_date', '<=', $endDate)
            ->sum('amount');


        /*
        |--------------------------------------------------------------------------
        | TOTAL EXPENSE
        |--------------------------------------------------------------------------
        */

        $totalExpense =
            $incomingGoodsExpense +
            $operationalExpense;


        /*
        |--------------------------------------------------------------------------
        | PROFIT
        |--------------------------------------------------------------------------
        */

        $profit =
            $totalIncome -
            $totalExpense;


        /*
        |--------------------------------------------------------------------------
        | PAGINATED SALES
        |--------------------------------------------------------------------------
        |
        | Sale employee information is obtained through:
        |
        | Sale
        |   ↓
        | Distribution
        |   ↓
        | Assignment
        |   ↓
        | Employee
        |   ↓
        | User
        |
        */

        $sales = Sale::with([
            'details.product',
            'distribution.assignment.employee.user',
        ])
            ->whereDate('sale_date', '>=', $startDate)
            ->whereDate('sale_date', '<=', $endDate)
            ->orderByDesc('sale_date')
            ->orderByDesc('id')
            ->paginate(
                15,
                ['*'],
                'sales_page'
            )
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | PAGINATED INCOMING GOODS
        |--------------------------------------------------------------------------
        */

        $incomingGoods = IncomingGood::with(
            'rawMaterial'
        )
            ->whereDate('received_at', '>=', $startDate)
            ->whereDate('received_at', '<=', $endDate)
            ->orderByDesc('received_at')
            ->orderByDesc('id')
            ->paginate(
                15,
                ['*'],
                'incoming_goods_page'
            )
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | PAGINATED OPERATIONAL EXPENSES
        |--------------------------------------------------------------------------
        */

        $operationalExpenses = OperationalExpense::query()
            ->whereDate('expense_date', '>=', $startDate)
            ->whereDate('expense_date', '<=', $endDate)
            ->orderByDesc('expense_date')
            ->orderByDesc('id')
            ->paginate(
                15,
                ['*'],
                'expenses_page'
            )
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | Return View
        |--------------------------------------------------------------------------
        */

        return view(
            'financial-reports.index',
            compact(
                'startDate',
                'endDate',

                'sales',

                'incomingGoods',

                'operationalExpenses',

                'outletIncome',

                'employeeIncome',

                'totalIncome',

                'incomingGoodsExpense',

                'operationalExpense',

                'totalExpense',

                'profit'
            )
        );
    }
}
