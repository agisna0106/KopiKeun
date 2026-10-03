<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $owner = Role::where('nama_role', 'Owner')->first();
        $staffOperasional = Role::where(
            'nama_role',
            'Staff Operasional'
        )->first();
        $karyawan = Role::where(
            'nama_role',
            'Karyawan'
        )->first();

        User::create([
            'name' => 'Owner KopiKeun',
            'email' => 'owner@kopikeun.test',
            'password' => Hash::make('password123'),
            'role_id' => $owner->id_role,
        ]);

        User::create([
            'name' => 'Staff Operasional KopiKeun',
            'email' => 'staff@kopikeun.test',
            'password' => Hash::make('password123'),
            'role_id' => $staffOperasional->id_role,
        ]);

        User::create([
            'name' => 'Karyawan KopiKeun',
            'email' => 'karyawan@kopikeun.test',
            'password' => Hash::make('password123'),
            'role_id' => $karyawan->id_role,
        ]);
    }
}
