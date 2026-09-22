<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use App\Models\Role;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $owner = Role::where('nama_role', 'Owner')->first();
        $admin = Role::where('nama_role', 'Admin')->first();
        $karyawan = Role::where('nama_role', 'Karyawan')->first();

        User::create([
            'name' => 'Owner KopiKeun',
            'email' => 'owner@kopikeun.test',
            'password' => Hash::make('password123'),
            'role_id' => $owner->id_role,
        ]);

        User::create([
            'name' => 'Admin KopiKeun',
            'email' => 'admin@kopikeun.test',
            'password' => Hash::make('password123'),
            'role_id' => $admin->id_role,
        ]);

        User::create([
            'name' => 'Karyawan KopiKeun',
            'email' => 'karyawan@kopikeun.test',
            'password' => Hash::make('password123'),
            'role_id' => $karyawan->id_role,
        ]);
    }
}
