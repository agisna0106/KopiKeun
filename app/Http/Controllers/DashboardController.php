<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

use App\Models\IncomingGood;
use App\Models\OperationalExpense;
use App\Models\Product;
use App\Models\Sale;

use App\Models\Distribution;
use App\Models\Employee;
use App\Models\RawMaterial;
use App\Models\RemainingProduct;

class DashboardController extends Controller
{
    public function index(Request $request): View|RedirectResponse
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        $role = $user->role?->nama_role;

        if ($role === 'Owner') {


            $startDate = now()->startOfMonth();
            $endDate = now();


            $sales = Sale::with('details')
                ->whereBetween('sale_date', [
                    $startDate->toDateString(),
                    $endDate->toDateString(),
                ])
                ->get();

            $outletIncome = $sales
                ->where('sale_source', 'Outlet')
                ->sum(function ($sale) {
                    return $sale->details->sum('subtotal');
                });

            $employeeIncome = $sales
                ->where('sale_source', 'Employee')
                ->sum(function ($sale) {
                    return $sale->details->sum('subtotal');
                });

            $totalIncome = $outletIncome + $employeeIncome;


            $incomingGoods = IncomingGood::whereBetween(
                'received_at',
                [
                    $startDate->toDateString(),
                    $endDate->toDateString(),
                ]
            )->get();

            $incomingGoodsExpense = $incomingGoods->sum(function ($item) {
                return $item->quantity * $item->unit_cost;
            });

            $operationalExpense = OperationalExpense::whereBetween(
                'expense_date',
                [
                    $startDate->toDateString(),
                    $endDate->toDateString(),
                ]
            )->sum('amount');

            $totalExpense = $incomingGoodsExpense + $operationalExpense;


            $profit = $totalIncome - $totalExpense;


            $activeProducts = Product::where('status', 'Active')->count();


            $chartLabels = [];
            $chartIncome = [];
            $chartExpense = [];

            $currentDate = $startDate->copy();

            while ($currentDate->lte($endDate)) {

                $dateString = $currentDate->toDateString();


                $dailyIncome = $sales
                    ->filter(function ($sale) use ($dateString) {
                        return $sale->sale_date->toDateString() === $dateString;
                    })
                    ->sum(function ($sale) {
                        return $sale->details->sum('subtotal');
                    });


                $dailyIncomingGoods = $incomingGoods
                    ->filter(function ($item) use ($dateString) {
                        return $item->received_at->toDateString() === $dateString;
                    })
                    ->sum(function ($item) {
                        return $item->quantity * $item->unit_cost;
                    });


                $dailyOperationalExpense = OperationalExpense::whereDate(
                    'expense_date',
                    $dateString
                )->sum('amount');

                $dailyExpense =
                    $dailyIncomingGoods +
                    $dailyOperationalExpense;

                /*
                | Chart Data
                */

                $chartLabels[] = $currentDate->format('d M');
                $chartIncome[] = $dailyIncome;
                $chartExpense[] = $dailyExpense;

                $currentDate->addDay();
            }


            return view('dashboard.owner', compact(
                'startDate',
                'endDate',
                'outletIncome',
                'employeeIncome',
                'totalIncome',
                'incomingGoodsExpense',
                'operationalExpense',
                'totalExpense',
                'profit',
                'activeProducts',
                'chartLabels',
                'chartIncome',
                'chartExpense'
            ));
        }


        if ($role === 'Admin') {


            $activeProducts = Product::where('status', 'Active')->count();

            $activeRawMaterials = RawMaterial::where(
                'status',
                'Active'
            )->count();

            $lowStockMaterials = RawMaterial::where(
                'status',
                'Active'
            )
                ->whereColumn('current_stock', '<=', 'minimum_stock')
                ->count();

            $activeEmployees = Employee::where(
                'status',
                'Active'
            )->count();


            $recentDistributions = Distribution::with([
                'employee.user',
                'details.baseDrink',
            ])
                ->latest('distribution_date')
                ->latest()
                ->take(5)
                ->get();


            $recentSales = Sale::with([
                'employee.user',
                'details.product',
            ])
                ->latest('sale_date')
                ->latest()
                ->take(5)
                ->get();


            $recentRemainingProducts = RemainingProduct::with([
                'details.baseDrink',
            ])
                ->latest('recorded_at')
                ->latest()
                ->take(5)
                ->get();


            $recentIncomingGoods = IncomingGood::with(
                'rawMaterial'
            )
                ->latest('received_at')
                ->latest()
                ->take(5)
                ->get();

            return view('dashboard.admin', compact(
                'activeProducts',
                'activeRawMaterials',
                'lowStockMaterials',
                'activeEmployees',
                'recentDistributions',
                'recentSales',
                'recentRemainingProducts',
                'recentIncomingGoods'
            ));
        }

        if ($role === 'Karyawan') {

            $employee = $user->employee;

            if (!$employee) {
                abort(403, 'Employee profile not found.');
            }


            $today = now()->toDateString();

            $todayDistribution = Distribution::with([
                'details.baseDrink',
            ])
                ->where('employee_id', $employee->id)
                ->whereDate('distribution_date', $today)
                ->latest()
                ->first();


            $todaySales = Sale::with([
                'details.product',
            ])
                ->where('employee_id', $employee->id)
                ->where('sale_source', 'Employee')
                ->whereDate('sale_date', $today)
                ->get();

            $todaySalesTotal = $todaySales->sum(function ($sale) {
                return $sale->details->sum('subtotal');
            });


            $recentDistributions = Distribution::with([
                'details.baseDrink',
            ])
                ->where('employee_id', $employee->id)
                ->latest('distribution_date')
                ->latest()
                ->take(5)
                ->get();


            $recentSales = Sale::with([
                'details.product',
            ])
                ->where('employee_id', $employee->id)
                ->where('sale_source', 'Employee')
                ->latest('sale_date')
                ->latest()
                ->take(5)
                ->get();

            return view('dashboard.karyawan', compact(
                'employee',
                'todayDistribution',
                'todaySales',
                'todaySalesTotal',
                'recentDistributions',
                'recentSales'
            ));
        }

        return abort(403, 'Role pengguna tidak dikenali.');
    }
}
