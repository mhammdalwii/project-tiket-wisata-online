<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role; // <-- Wajib ada
use App\Models\User;               // <-- Wajib ada

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Membuat 3 Role Utama
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $pengelola = Role::firstOrCreate(['name' => 'pengelola']);
        $wisatawan = Role::firstOrCreate(['name' => 'wisatawan']);

        // 2. Memberikan akses Admin ke semua akun yang sudah ada
        // Ini memastikan akun Anda tetap punya akses setelah Role dibuat
        $users = User::all();
        foreach ($users as $user) {
            $user->assignRole($admin);
        }
    }
}
