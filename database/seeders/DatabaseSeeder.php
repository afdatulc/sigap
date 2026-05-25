<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Rumah;
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
            'email' => 'admin@.desa',
            'password' => bcrypt('password'),
        ]);
        $admin->assignRole('Admin');

        $mitra = User::create([
            'name' => 'Mitra Lapangan 1',
            'email' => 'mitra@sigap.desa',
            'password' => bcrypt('password'),
        ]);
        $mitra->assignRole('Mitra');

        Rumah::create([
            'nama_kepala_rumah' => 'Ahmad Sujarwo',
            'alamat' => 'Jl. Merdeka No. 10',
            'rt_rw' => '001/001',
            'jumlah_kk' => 2,
            'status_listrik' => 'listrik pln dengan meteran',
            'memiliki_usaha' => true,
            'latitude' => -3.444444,
            'longitude' => 114.833333,
            'status_verifikasi' => 'verified',
            'created_by' => $admin->id,
        ]);

        Rumah::create([
            'nama_kepala_rumah' => 'Siti Aminah',
            'alamat' => 'Gg. Kancil No. 5',
            'rt_rw' => '002/001',
            'jumlah_kk' => 1,
            'status_listrik' => 'listrik pln tanpa meteran',
            'memiliki_usaha' => false,
            'latitude' => -3.455555,
            'longitude' => 114.844444,
            'status_verifikasi' => 'verified',
            'created_by' => $admin->id,
        ]);

        Rumah::create([
            'nama_kepala_rumah' => 'Hendra Wijaya',
            'alamat' => 'Jl. Pelangi No. 22',
            'rt_rw' => '003/001',
            'jumlah_kk' => 3,
            'status_listrik' => 'listrik pln dengan meteran',
            'memiliki_usaha' => true,
            'latitude' => -3.466666,
            'longitude' => 114.855555,
            'status_verifikasi' => 'verified',
            'created_by' => $mitra->id,
        ]);
    }
}
