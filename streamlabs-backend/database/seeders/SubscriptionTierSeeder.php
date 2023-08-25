<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SubscriptionTier;
use App\Constants;

class SubscriptionTierSeeder extends Seeder
{
    public function run(): void
    {
        $defaultTiers = [
            ['name' => 'Tier 1', 'price' => 5, 'currency' => Constants::PRIMARY_CURRENCY],
            ['name' => 'Tier 2', 'price' => 10, 'currency' => Constants::PRIMARY_CURRENCY],
            ['name' => 'Tier 3', 'price' => 15, 'currency' => Constants::PRIMARY_CURRENCY],
        ];

        foreach ($defaultTiers as $tier) {
            SubscriptionTier::create($tier);
        }
    }
}
