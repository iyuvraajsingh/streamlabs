<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Carbon\Carbon;
use App\Models\MerchSale;
use App\Models\User;
use App\Models\Notification;
use App\Models\Item;
use App\Constants;

class MerchSalesSeeder extends Seeder
{
    public function run(): void
    {
        
        $faker = Faker::create();

        $items = Item::all()->pluck('name', 'id')->toArray();
        $itemIds = array_keys($items);
        

        $users = User::all();

        foreach ($users as $user) {
            for ($i = 0; $i < random_int(5, 10); $i++) {
                $saleUser = User::where('id', '!=', $user->id)->inRandomOrder()->first();
               
                $daysRange = ($i % 2 === 0) ? [1, 29] : [1, 90];
                $createdAt = Carbon::now()->subDays(rand(...$daysRange))->subHours(rand(1, 24));

                $merchSale = MerchSale::create([
                    'user_id' => $user->id,
                    'sale_user_id' => $saleUser->id,
                    'item_id' => $faker->randomElement($itemIds),
                    'amount' => $faker->randomFloat(2, 5, 100),
                    'currency' => Constants::PRIMARY_CURRENCY,
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]);

                $itemName = $items[$merchSale->item_id];

                Notification::create([
                    'user_id' => $user->id,
                    'action_id' => $merchSale->id,
                    'action_type' => Constants::AT_MERCH_SALE,
                    'message' => "{$saleUser->name} bought {$itemName} from you for {$merchSale->amount} {$merchSale->currency}!",
                    'read' => false,
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]);
            }
        }
    }
}
