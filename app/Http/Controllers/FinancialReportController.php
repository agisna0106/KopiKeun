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
        $startDate = $request->input(
            'start_date',
            now()->startOfMonth()->format('Y-m-d')
        );

        $endDate = $request->input(
            'end_date',
            now()->format('Y-m-d')
        );

        /*
        These queries not affecting the summary.
        */

        $salesForSummary = Sale::with('details')
            ->whereBetween('sale_date', [$startDate, $endDate])
            ->get();

        $outletIncome = $salesForSummary
            ->where('sale_source', 'Outlet')
            ->sum(function ($sale) {
                return $sale->details->sum('subtotal');
            });

        $employeeIncome = $salesForSummary
            ->where('sale_source', 'Employee')
            ->sum(function ($sale) {
                return $sale->details->sum('subtotal');
            });

        $totalIncome = $outletIncome + $employeeIncome;

        $incomingGoodsForSummary = IncomingGood::query()
            ->whereBetween('received_at', [$startDate, $endDate])
            ->get();

        $incomingGoodsExpense = $incomingGoodsForSummary->sum(
            function ($item) {
                return $item->quantity * $item->unit_cost;
            }
        );

        $operationalExpense = OperationalExpense::query()
            ->whereBetween('expense_date', [$startDate, $endDate])
            ->sum('amount');

        $totalExpense = $incomingGoodsExpense + $operationalExpense;

        $profit = $totalIncome - $totalExpense;

        /*
        |--------------------------------------------------------------------------
        | Paginated Detail Queries
        |--------------------------------------------------------------------------
        */

        $sales = Sale::with([
            'employee.user',
            'details.product',
        ])
            ->whereBetween('sale_date', [$startDate, $endDate])
            ->orderByDesc('sale_date')
            ->latest()
            ->paginate(15, ['*'], 'sales_page')
            ->withQueryString();

        $incomingGoods = IncomingGood::with('rawMaterial')
            ->whereBetween('received_at', [$startDate, $endDate])
            ->orderByDesc('received_at')
            ->latest()
            ->paginate(15, ['*'], 'incoming_goods_page')
            ->withQueryString();

        $operationalExpenses = OperationalExpense::query()
            ->whereBetween('expense_date', [$startDate, $endDate])
            ->orderByDesc('expense_date')
            ->latest()
            ->paginate(15, ['*'], 'expenses_page')
            ->withQueryString();

        return view('financial-reports.index', compact(
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
        ));
    }
}
