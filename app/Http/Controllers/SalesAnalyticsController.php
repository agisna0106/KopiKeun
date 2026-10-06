<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SalesAnalyticsController extends Controller
{
    public function index(Request $request): View
    {
        /*
        |--------------------------------------------------------------------------
        | Periode
        |--------------------------------------------------------------------------
        */

        $startDate = $request->input(
            'start_date',
            now('Asia/Jakarta')->startOfMonth()->format('Y-m-d')
        );

        $endDate = $request->input(
            'end_date',
            now('Asia/Jakarta')->format('Y-m-d')
        );

        /*
        |--------------------------------------------------------------------------
        | Query dasar penjualan
        |--------------------------------------------------------------------------
        */

        $salesQuery = Sale::query()
            ->whereDate('sale_date', '>=', $startDate)
            ->whereDate('sale_date', '<=', $endDate);

        /*
        |--------------------------------------------------------------------------
        | Ringkasan
        |--------------------------------------------------------------------------
        */

        $sales = (clone $salesQuery)
            ->with('details')
            ->get();

        $totalTransactions = $sales->count();

        $totalProductsSold = $sales->sum(
            fn ($sale) => $sale->details->sum('quantity')
        );

        $totalRevenue = $sales->sum(
            fn ($sale) => $sale->details->sum('subtotal')
        );

        /*
        |--------------------------------------------------------------------------
        | Kinerja Karyawan
        |--------------------------------------------------------------------------
        |
        | Sale Employee
        |   -> Distribution
        |       -> Assignment
        |           -> Employee
        |
        */

        $employeePerformance = (clone $salesQuery)
            ->where('sale_source', 'Employee')
            ->with([
                'details',
                'distribution.assignment.employee.user',
            ])
            ->get()
            ->groupBy(function ($sale) {
                return $sale->distribution?->assignment?->employee?->id;
            })
            ->filter(function ($sales) {
                return $sales->first()
                    ?->distribution
                    ?->assignment
                    ?->employee;
            })
            ->map(function ($sales) {
                $employee = $sales->first()
                    ->distribution
                    ->assignment
                    ->employee;

                return [
                    'employee' => $employee,
                    'employee_name' => $employee->user?->name ?? '-',
                    'transaction_count' => $sales->count(),
                    'products_sold' => $sales->sum(
                        fn ($sale) => $sale->details->sum('quantity')
                    ),
                    'revenue' => $sales->sum(
                        fn ($sale) => $sale->details->sum('subtotal')
                    ),
                ];
            })
            ->sortByDesc('revenue')
            ->values();

        /*
        |--------------------------------------------------------------------------
        | Kinerja Wilayah
        |--------------------------------------------------------------------------
        |
        | Sale Employee
        |   -> Distribution
        |       -> Assignment
        |           -> Region
        |
        */

        $regionPerformance = (clone $salesQuery)
            ->where('sale_source', 'Employee')
            ->with([
                'details',
                'distribution.assignment.region',
            ])
            ->get()
            ->groupBy(function ($sale) {
                return $sale->distribution?->assignment?->region?->id;
            })
            ->filter(function ($sales) {
                return $sales->first()
                    ?->distribution
                    ?->assignment
                    ?->region;
            })
            ->map(function ($sales) {
                $region = $sales->first()
                    ->distribution
                    ->assignment
                    ->region;

                return [
                    'region' => $region,
                    'region_name' => $region->name ?? '-',
                    'transaction_count' => $sales->count(),
                    'products_sold' => $sales->sum(
                        fn ($sale) => $sale->details->sum('quantity')
                    ),
                    'revenue' => $sales->sum(
                        fn ($sale) => $sale->details->sum('subtotal')
                    ),
                ];
            })
            ->sortByDesc('revenue')
            ->values();

        /*
        |--------------------------------------------------------------------------
        | Produk Terlaris
        |--------------------------------------------------------------------------
        */

        $productPerformance = (clone $salesQuery)
            ->with('details.product')
            ->get()
            ->flatMap(function ($sale) {
                return $sale->details;
            })
            ->groupBy('product_id')
            ->map(function ($details) {
                $product = $details->first()->product;

                return [
                    'product' => $product,
                    'product_name' => $product->name ?? '-',
                    'quantity_sold' => $details->sum('quantity'),
                    'revenue' => $details->sum('subtotal'),
                ];
            })
            ->sortByDesc('quantity_sold')
            ->values();

        /*
        |--------------------------------------------------------------------------
        | Tren Penjualan
        |--------------------------------------------------------------------------
        */

        $salesTrend = (clone $salesQuery)
            ->with('details')
            ->get()
            ->groupBy(function ($sale) {
                return $sale->sale_date->format('Y-m-d');
            })
            ->map(function ($sales, $date) {
                return [
                    'date' => $date,
                    'revenue' => $sales->sum(
                        fn ($sale) => $sale->details->sum('subtotal')
                    ),
                ];
            })
            ->sortBy('date')
            ->values();

        return view('sales-analytics.index', compact(
            'startDate',
            'endDate',
            'totalTransactions',
            'totalProductsSold',
            'totalRevenue',
            'employeePerformance',
            'regionPerformance',
            'productPerformance',
            'salesTrend'
        ));
    }
}
