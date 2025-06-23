<?php

namespace Database\Factories;

use App\Models\Produk;
use App\Models\KategoriProduk;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProdukFactory extends Factory
{
    protected $model = Produk::class;

    public function definition(): array
    {
        return [
            'nama' => $this->faker->words(2, true),
            'kategori_id' => KategoriProduk::inRandomOrder()->first()?->id ?? KategoriProduk::factory(),
            'harga' => $this->faker->randomFloat(2, 10000, 50000),
            'diskon' => $this->faker->numberBetween(0, 100), 
            'thumbnail' => null,
            'template' => null,
            'status' => $this->faker->randomElement(['aktif', 'tidak_aktif']),
        ];
    }
}
