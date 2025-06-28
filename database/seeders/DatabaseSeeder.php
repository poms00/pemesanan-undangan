<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // Tambahkan ini
use App\Models\KategoriProduk;
use App\Models\Produk;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //  User::factory(2)->create();
        //  User::create([
        //      'name' => 'Admin',
        //            'email' => 'admin@example.com',
        //      'password' => Hash::make('12345678'), // tetap harus di-hash
        //     'role' => 'admin',
        //    'email_verified_at' => now(),
        // ]);

        //  User::create([
        //      'name' => 'User Biasa',
        //    'email' => 'user@example.com',
        //   'password' => Hash::make('12345678'),
        //   'role' => 'user',
        //   'email_verified_at' => now(),
        // ]);


        KategoriProduk::factory()->count(3)->create();


        //Produk::factory()->count(5)->create();


    }
}
