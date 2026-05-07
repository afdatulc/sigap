<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $roleAdmin = \Spatie\Permission\Models\Role::create(['name' => 'Admin']);
        $roleMitra = \Spatie\Permission\Models\Role::create(['name' => 'Mitra']);
        $rolePublik = \Spatie\Permission\Models\Role::create(['name' => 'Publik']);

        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@sigap.desa',
            'password' => bcrypt('password'),
        ]);
        $admin->assignRole('Admin');

        $mitra = User::create([
            'name' => 'Mitra Lapangan 1',
            'email' => 'mitra@sigap.desa',
            'password' => bcrypt('password'),
        ]);
        $mitra->assignRole('Mitra');
    }
}
