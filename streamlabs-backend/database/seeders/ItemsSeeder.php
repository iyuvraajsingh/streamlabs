<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Item;

class ItemsSeeder extends Seeder
{
    public function run(): void
    {
        $defaultItems = [
            ['name' => 'T-shirt'],
            ['name' => 'Jeans'],
            ['name' => 'Dress'],
            ['name' => 'Sweater'],
            ['name' => 'Hoodie'],
            ['name' => 'Jacket'],
            ['name' => 'Blouse'],
            ['name' => 'Skirt'],
            ['name' => 'Pants'],
            ['name' => 'Shorts'],
            ['name' => 'Coat'],
            ['name' => 'Hat'],
            ['name' => 'Scarf'],
            ['name' => 'Gloves'],
            ['name' => 'Socks'],
            ['name' => 'Shoes'],
            ['name' => 'Boots'],
            ['name' => 'Sneakers'],
            ['name' => 'Belt'],
            ['name' => 'Pajamas'],
        ];

        foreach ($defaultItems as $item) {
            Item::create($item);
        }
    }
}
