<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::create([
            'nama_role' => 'Owner',
        ]);

        Role::create([
            'nama_role' => 'Staff Operasional',
        ]);

        Role::create([
            'nama_role' => 'Karyawan',
        ]);
    }
}
