<?php

namespace Database\Seeders;

use App\Models\Assignment;
use App\Models\BaseDrink;
use App\Models\Cart;
use App\Models\Distribution;
use App\Models\DistributionOperationalDetail;
use App\Models\DistributionProductDetail;
use App\Models\Employee;
use App\Models\IncomingGood;
use App\Models\OperationalExpense;
use App\Models\OperationalItem;
use App\Models\Product;
use App\Models\RawMaterial;
use App\Models\RawMaterialStockRecord;
use App\Models\Region;
use App\Models\Role;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class KopiKeunSeeder extends Seeder
{
    private const MARKER = 'Seeder KopiKeun 2026';

    public function run(): void
    {
        DB::transaction(function (): void {
            mt_srand(2026);

            $roles = $this->seedRoles();
            $employees = $this->seedUsersAndEmployees($roles);
            $baseDrinks = $this->seedBaseDrinks();
            $products = $this->seedProducts($baseDrinks);
            $rawMaterials = $this->seedRawMaterials();
            $operationalItems = $this->seedOperationalItems();
            $assignments = $this->seedAssignments($employees);

            $this->removePreviousGeneratedTransactions();
            $this->seedSalesAndDistributions($employees, $assignments, $baseDrinks, $products, $operationalItems);
            $this->seedInventoryHistory($rawMaterials);
            // $this->seedOperationalExpenses();
        });
    }

    private function seedRoles(): array
    {
        $result = [];
        foreach (['Owner', 'Staff Operasional', 'Karyawan'] as $name) {
            $result[$name] = Role::firstOrCreate(['nama_role' => $name]);
        }
        return $result;
    }

    private function seedUsersAndEmployees(array $roles): array
    {
        $accounts = [
            ['name' => 'Owner KopiKeun', 'email' => 'owner@kopikeun.test', 'role' => 'Owner'],
            ['name' => 'Staff Operasional KopiKeun', 'email' => 'staff@kopikeun.test', 'role' => 'Staff Operasional'],
            ['name' => 'Ajis Muslim', 'email' => 'ajis@kopikeun.test', 'role' => 'Karyawan', 'code' => 'KK-EMP-001', 'phone' => '081234560001'],
            ['name' => 'Hafidz', 'email' => 'hafidz@kopikeun.test', 'role' => 'Karyawan', 'code' => 'KK-EMP-002', 'phone' => '081234560002'],
        ];

        $employees = [];
        foreach ($accounts as $account) {
            $user = User::updateOrCreate(
                ['email' => $account['email']],
                [
                    'name' => $account['name'],
                    'password' => Hash::make('password123'),
                    'role_id' => $roles[$account['role']]->id_role,
                ]
            );

            if (isset($account['code'])) {
                $employees[$account['name']] = Employee::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'employee_code' => $account['code'],
                        'phone' => $account['phone'],
                        'address' => 'Alamat dummy - KopiKeun',
                        'status' => 'Active',
                    ]
                );
            }
        }

        return $employees;
    }

    private function seedBaseDrinks(): array
    {
        $definitions = [
            'Americano' => ['capacity' => 1200, 'serving' => 150],
            'Kopi Susu' => ['capacity' => 1200, 'serving' => 120],
            'Kopi Susu Gula Aren' => ['capacity' => 1200, 'serving' => 120],
        ];
        $result = [];
        foreach ($definitions as $name => $data) {
            $result[$name] = BaseDrink::updateOrCreate(
                ['name' => $name],
                [
                    'bottle_capacity_ml' => $data['capacity'],
                    'standard_serving_ml' => $data['serving'],
                    'status' => 'Active',
                ]
            );
        }
        return $result;
    }

    private function seedProducts(array $baseDrinks): array
    {
        $definitions = [
            'Kopi Susu Butterscotch' => ['base' => 'Kopi Susu', 'price' => 9000],
            'Kopi Susu Hazelnut' => ['base' => 'Kopi Susu', 'price' => 9000],
            'Kopi Susu Karamel' => ['base' => 'Kopi Susu', 'price' => 9000],
            'Kopi Susu Gula Aren' => ['base' => 'Kopi Susu Gula Aren', 'price' => 8000],
            'Kopi Susu Latte' => ['base' => 'Kopi Susu', 'price' => 8000],
            'Americano' => ['base' => 'Americano', 'price' => 5000],
        ];

        $result = [];
        foreach ($definitions as $name => $data) {
            $result[$name] = Product::updateOrCreate(
                ['name' => $name],
                [
                    'base_drink_id' => $baseDrinks[$data['base']]->id,
                    'price' => $data['price'],
                    'status' => 'Active',
                ]
            );
        }
        return $result;
    }

    private function seedRawMaterials(): array
    {
        $definitions = [
            'Biji kopi' => ['unit' => 'kg', 'stock' => 15, 'minimum' => 3],
            'Susu UHT' => ['unit' => 'liter', 'stock' => 40, 'minimum' => 8],
            'Gula aren cair' => ['unit' => 'liter', 'stock' => 15, 'minimum' => 3],
            'Sirup butterscotch' => ['unit' => 'botol', 'stock' => 8, 'minimum' => 2],
            'Sirup hazelnut' => ['unit' => 'botol', 'stock' => 8, 'minimum' => 2],
            'Sirup karamel' => ['unit' => 'botol', 'stock' => 8, 'minimum' => 2],
            'Cup plastik' => ['unit' => 'pcs', 'stock' => 1000, 'minimum' => 200],
            'Es batu' => ['unit' => 'kg', 'stock' => 50, 'minimum' => 10],
        ];
        $result = [];
        foreach ($definitions as $name => $data) {
            $result[$name] = RawMaterial::updateOrCreate(
                ['name' => $name],
                [
                    'unit' => $data['unit'],
                    'current_stock' => $data['stock'],
                    'minimum_stock' => $data['minimum'],
                    'status' => 'Active',
                ]
            );
        }
        return $result;
    }

    private function seedOperationalItems(): array
    {
        $definitions = [
            'Cup holder' => ['unit' => 'pcs', 'stock' => 300, 'minimum_stock' => 50],
            'Sedotan' => ['unit' => 'pcs', 'stock' => 1000, 'minimum_stock' => 200],
            'Kantong plastik' => ['unit' => 'pcs', 'stock' => 500, 'minimum_stock' => 100],
            'Tisu' => ['unit' => 'pack', 'stock' => 100, 'minimum_stock' => 20],
            'Lap kecil' => ['unit' => 'pcs', 'stock' => 20, 'minimum_stock' => 5],
        ];
        $result = [];
        foreach ($definitions as $name => $data) {
            $result[$name] = OperationalItem::updateOrCreate(
                ['name' => $name],
                $data + ['status' => 'active']
            );
        }
        return $result;
    }

    private function seedAssignments(array $employees): array
    {
        $cartAjis = Cart::updateOrCreate(['code' => 'KK-CART-001'], [
            'name' => 'Gerobak Ajis Muslim', 'description' => 'Gerobak penjualan Ajis Muslim', 'status' => 'active',
        ]);
        $cartHafidz = Cart::updateOrCreate(['code' => 'KK-CART-002'], [
            'name' => 'Gerobak Hafidz', 'description' => 'Gerobak penjualan Hafidz', 'status' => 'active',
        ]);
        $regionAjis = Region::firstOrCreate(['name' => 'Wilayah Penjualan A'], [
            'description' => 'Wilayah dummy penugasan Ajis Muslim', 'status' => 'active',
        ]);
        $regionHafidz = Region::firstOrCreate(['name' => 'Wilayah Penjualan B'], [
            'description' => 'Wilayah dummy penugasan Hafidz', 'status' => 'active',
        ]);

        return [
            'Ajis Muslim' => Assignment::updateOrCreate(
                ['employee_id' => $employees['Ajis Muslim']->id, 'cart_id' => $cartAjis->id, 'region_id' => $regionAjis->id],
                ['start_date' => '2026-06-01', 'end_date' => null, 'status' => 'Active', 'notes' => self::MARKER . ' - penugasan Ajis Muslim']
            ),
            'Hafidz' => Assignment::updateOrCreate(
                ['employee_id' => $employees['Hafidz']->id, 'cart_id' => $cartHafidz->id, 'region_id' => $regionHafidz->id],
                ['start_date' => '2026-06-01', 'end_date' => null, 'status' => 'Active', 'notes' => self::MARKER . ' - penugasan Hafidz']
            ),
        ];
    }

    private function removePreviousGeneratedTransactions(): void
    {
        $saleIds = Sale::where('notes', 'like', self::MARKER . '%')->pluck('id');
        if ($saleIds->isNotEmpty()) {
            SaleDetail::whereIn('sale_id', $saleIds)->delete();
            Sale::whereIn('id', $saleIds)->delete();
        }

        $distributionIds = Distribution::where('notes', 'like', self::MARKER . '%')->pluck('id');
        if ($distributionIds->isNotEmpty()) {
            DistributionOperationalDetail::whereIn('distribution_id', $distributionIds)->delete();
            DistributionProductDetail::whereIn('distribution_id', $distributionIds)->delete();
            Distribution::whereIn('id', $distributionIds)->delete();
        }

        IncomingGood::where('notes', 'like', self::MARKER . '%')->delete();
        RawMaterialStockRecord::where('notes', 'like', self::MARKER . '%')->delete();
        OperationalExpense::where('notes', 'like', self::MARKER . '%')->delete();
    }

    private function seedSalesAndDistributions(array $employees, array $assignments, array $baseDrinks, array $products, array $operationalItems): void
    {
        $dailyTotals = [
            '2026-06-01' => 72, '2026-06-02' => 93, '2026-06-03' => 98, '2026-06-04' => 119,
            '2026-06-05' => 113, '2026-06-06' => 116, '2026-06-07' => 354, '2026-06-08' => 79,
            '2026-06-09' => 30, '2026-06-10' => 71, '2026-06-11' => 49, '2026-06-12' => 53,
            '2026-06-13' => 39, '2026-06-14' => 156, '2026-06-15' => 34, '2026-06-16' => 88,
            '2026-06-17' => 62, '2026-06-18' => 21, '2026-06-19' => 54, '2026-06-20' => 72,
            '2026-06-21' => 220, '2026-06-22' => 43, '2026-06-23' => 47, '2026-06-24' => 31,
            '2026-06-25' => 32, '2026-06-26' => 36, '2026-06-27' => 121, '2026-06-28' => 324,
            '2026-07-04' => 105, '2026-07-05' => 155, '2026-07-06' => 69, '2026-07-07' => 46,
            '2026-07-08' => 105, '2026-07-09' => 60, '2026-07-10' => 97, '2026-07-11' => 55,
            '2026-07-12' => 27, '2026-07-13' => 85, '2026-07-14' => 68, '2026-07-15' => 43,
            '2026-07-16' => 27, '2026-07-17' => 58, '2026-07-18' => 240, '2026-07-19' => 100,
            '2026-07-20' => 31, '2026-07-21' => 51, '2026-07-22' => 49, '2026-07-23' => 47,
            '2026-07-24' => 78, '2026-07-25' => 81, '2026-07-26' => 81, '2026-07-27' => 40,
            '2026-07-28' => 26, '2026-07-29' => 65, '2026-07-30' => 72,
        ];

        $employeeNames = ['Ajis Muslim', 'Hafidz'];
        $productByPrice = [
            9 => [$products['Kopi Susu Butterscotch']->id, $products['Kopi Susu Hazelnut']->id, $products['Kopi Susu Karamel']->id],
            8 => [$products['Kopi Susu Gula Aren']->id, $products['Kopi Susu Latte']->id],
            5 => [$products['Americano']->id],
        ];
        $baseForProduct = [
            $products['Kopi Susu Butterscotch']->id => $baseDrinks['Kopi Susu']->id,
            $products['Kopi Susu Hazelnut']->id => $baseDrinks['Kopi Susu']->id,
            $products['Kopi Susu Karamel']->id => $baseDrinks['Kopi Susu']->id,
            $products['Kopi Susu Gula Aren']->id => $baseDrinks['Kopi Susu Gula Aren']->id,
            $products['Kopi Susu Latte']->id => $baseDrinks['Kopi Susu']->id,
            $products['Americano']->id => $baseDrinks['Americano']->id,
        ];

        $dayIndex = 0;
        foreach ($dailyTotals as $date => $totalThousands) {
            $coins = $this->makeExactProductMix($totalThousands);
            $distributionCount = $totalThousands >= 200 ? 2 : 1;
            $groups = $distributionCount === 2 ? $this->splitProductMix($coins) : [$coins];

            foreach ($groups as $groupIndex => $group) {
                $employeeName = $distributionCount === 2
                    ? $employeeNames[$groupIndex]
                    : $employeeNames[$dayIndex % 2];
                $assignment = $assignments[$employeeName];

                $distribution = Distribution::create([
                    'assignment_id' => $assignment->id,
                    'distribution_date' => $date,
                    'notes' => self::MARKER . " - distribusi {$employeeName} untuk {$date}",
                ]);

                $groupProductCounts = [];
                foreach ($group as $coin) {
                    $options = $productByPrice[$coin];
                    $productId = $options[mt_rand(0, count($options) - 1)];
                    $groupProductCounts[$productId] = ($groupProductCounts[$productId] ?? 0) + 1;
                }

                $sale = Sale::create([
                    'sale_source' => 'Distribusi',
                    'distribution_id' => $distribution->id,
                    'sale_date' => $date,
                    'notes' => self::MARKER . " - penjualan {$employeeName}; target {$date}",
                ]);

                $baseQuantities = [];
                foreach ($groupProductCounts as $productId => $quantity) {
                    $product = Product::findOrFail($productId);
                    SaleDetail::create([
                        'sale_id' => $sale->id,
                        'product_id' => $productId,
                        'quantity' => $quantity,
                        'subtotal' => $quantity * (int) $product->price,
                    ]);
                    $baseId = $baseForProduct[$productId];
                    $baseQuantities[$baseId] = ($baseQuantities[$baseId] ?? 0) + $quantity;
                }

                foreach ($baseDrinks as $baseDrink) {
                    $sold = $baseQuantities[$baseDrink->id] ?? 0;
                    if ($sold > 0) {
                        DistributionProductDetail::create([
                            'distribution_id' => $distribution->id,
                            'base_drink_id' => $baseDrink->id,
                            'quantity_distributed' => max($sold + 2, (int) ceil($sold * 1.2)),
                            'quantity_returned' => 0,
                        ]);
                    }
                }

                foreach ($operationalItems as $item) {
                    DistributionOperationalDetail::create([
                        'distribution_id' => $distribution->id,
                        'operational_item_id' => $item->id,
                        'quantity_distributed' => mt_rand(1, 5),
                        'quantity_returned' => 0,
                    ]);
                }
            }
            $dayIndex++;
        }
    }

    /** Return a list of product price denominations (in thousands) that sums exactly to the daily target. */
    private function makeExactProductMix(int $target): array
    {
        $memo = [];
        $solve = function (int $remaining) use (&$solve, &$memo): ?array {
            if ($remaining === 0) return [];
            if ($remaining < 0) return null;
            if (array_key_exists($remaining, $memo)) return $memo[$remaining];

            $denominations = [9, 8, 5];
            shuffle($denominations);
            foreach ($denominations as $value) {
                if ($remaining >= $value) {
                    $tail = $solve($remaining - $value);
                    if ($tail !== null) {
                        return $memo[$remaining] = array_merge([$value], $tail);
                    }
                }
            }
            return $memo[$remaining] = null;
        };

        $mix = $solve($target);
        if ($mix === null) {
            throw new \RuntimeException("Nominal {$target} ribu tidak dapat dibentuk dari harga produk.");
        }
        return $mix;
    }

    private function splitProductMix(array $coins): array
    {
        shuffle($coins);
        $cut = mt_rand(1, count($coins) - 1);
        return [array_slice($coins, 0, $cut), array_slice($coins, $cut)];
    }

    private function seedInventoryHistory(array $rawMaterials): void
    {
        foreach ($rawMaterials as $index => $material) {
            $quantity = match ($material->unit) {
                'kg' => 10,
                'liter' => 20,
                'botol' => 5,
                default => 300,
            };

            IncomingGood::create([
                'raw_material_id' => $material->id,
                'quantity' => $quantity,
                'unit_cost' => match ($material->unit) {
                    'kg' => 90000,
                    'liter' => 18000,
                    'botol' => 45000,
                    default => 500,
                },
                'received_at' => $material->id % 2 === 0 ? '2026-06-01' : '2026-07-01',
                'supplier' => 'Supplier Dummy KopiKeun',
                'notes' => self::MARKER . ' - stok awal bahan baku',
            ]);

            RawMaterialStockRecord::create([
                'raw_material_id' => $material->id,
                'stock' => $material->current_stock,
                'recorded_at' => '2026-07-30',
                'notes' => self::MARKER . ' - snapshot stok akhir periode',
            ]);
        }

    }

    // private function seedOperationalExpenses(): void
    // {
    //     $expenses = [
    //         ['name' => 'Transportasi operasional', 'amount' => 75000, 'date' => '2026-06-01'],
    //         ['name' => 'Pembelian es batu', 'amount' => 50000, 'date' => '2026-06-07'],
    //         ['name' => 'Kebersihan dan perlengkapan', 'amount' => 65000, 'date' => '2026-06-15'],
    //         ['name' => 'Transportasi distribusi', 'amount' => 85000, 'date' => '2026-07-04'],
    //         ['name' => 'Perawatan gerobak', 'amount' => 100000, 'date' => '2026-07-18'],
    //         ['name' => 'Pembelian perlengkapan', 'amount' => 55000, 'date' => '2026-07-30'],
    //     ];
    //     foreach ($expenses as $expense) {
    //         OperationalExpense::create([
    //             'name' => $expense['name'],
    //             'amount' => $expense['amount'],
    //             'expense_date' => $expense['date'],
    //             'notes' => self::MARKER . ' - pengeluaran dummy',
    //         ]);
    //     }
    // }
}
