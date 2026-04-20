<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\Admin::create([
            'name' => 'Admin User',
            'email' => 'admin@arts.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
        ]);

        $products = [
            [
                'product_id' => 'ST10001',
                'name' => 'Watercolor Set',
                'description' => '24 vibrant colors professional watercolor set.',
                'price' => 25.00,
                'stock_quantity' => 50,
                'category' => 'Art Supplies',
            ],
            [
                'product_id' => 'ST10002',
                'name' => 'Sketchbook A4',
                'description' => 'High-quality 150gsm paper for sketching.',
                'price' => 12.50,
                'stock_quantity' => 100,
                'category' => 'Stationery',
            ],
            [
                'product_id' => 'ST10003',
                'name' => 'Calligraphy Pen',
                'description' => 'Fine tip calligraphy pen for artistic writing.',
                'price' => 8.00,
                'stock_quantity' => 75,
                'category' => 'Stationery',
            ],
            [
                'product_id' => 'GF10001',
                'name' => 'Artistic Mug',
                'description' => 'Ceramic mug with artistic splatter design.',
                'price' => 15.00,
                'stock_quantity' => 30,
                'category' => 'Gifts',
            ],
        ];

        foreach ($products as $product) {
            \App\Models\Product::create($product);
        }
    }
}
