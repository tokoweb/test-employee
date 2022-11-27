<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory;

use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create('id_ID');

        Product::create([
            'name' => 'Meja',
            'price' => '100000',
        ]);

        Product::create([
            'name' => 'Kursi',
            'price' => '50000',
        ]);
    }
}
