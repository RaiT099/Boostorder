<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Products;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Products::create([
            'title' => 'Samsung S23',
            'price' => 2100.00,
            'qty' => 1,
            'stock' => 5,
            'desc' => 'smart phone',
            'image' => 'https://images.samsung.com/is/image/samsung/p6pim/my/2401/gallery/my-galaxy-s24-plus-sm-s926bzvcxme-thumb-539302881'
        ]);

        Products::create([
            'title' => 'Samsung S24',
            'price' => 3100.00,
            'qty' => 1,
            'stock' => 5,
            'desc' => 'smart phone',
            'image' => 'https://images.samsung.com/is/image/samsung/p6pim/my/2401/gallery/my-galaxy-s24-490083-sm-s921blbqxme-thumb-539375697?imwidth=480'
        ]);

        Products::create([
            'title' => 'Iphone 15',
            'price' => 100.00,
            'qty' => 1,
            'stock' => 5,
            'desc' => 'smart phone',
            'image' => 'https://store.storeimages.cdn-apple.com/8567/as-images.apple.com/is/iphone-15-pro-model-unselect-gallery-2-202309?wid=2560&hei=1440&fmt=p-jpg&qlt=80&.v=1693010535416'
        ]);
    }
}
