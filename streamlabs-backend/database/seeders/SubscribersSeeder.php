<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Carbon\Carbon;
use App\Models\Subscriber;
use App\Models\SubscriptionTier;
use App\Models\User;
use App\Models\Notification;
use App\Constants;

class SubscribersSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        $subscriptionTiers = SubscriptionTier::all()->pluck('name', 'id')->toArray();
        $tierIds = array_keys($subscriptionTiers);

        $users = User::all();

        foreach ($users as $user) {
            for ($i = 0; $i < random_int(5, 10); $i++) {
                $subscriberUser = User::where('id', '!=', $user->id)->inRandomOrder()->first();
                
                $daysRange = ($i % 2 === 0) ? [1, 29] : [1, 90];
                $createdAt = Carbon::now()->subDays(rand(...$daysRange))->subHours(rand(1, 24));
                

                $subscriber = Subscriber::create([
                    'user_id' => $user->id,
                    'subscriber_id' => $subscriberUser->id,
                    'subscription_tier_id' => $faker->randomElement($tierIds),
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]);

                $tierName = $subscriptionTiers[$subscriber->subscription_tier_id];

                Notification::create([
                    'user_id' => $user->id,
                    'action_id' => $subscriber->id,
                    'action_type' => Constants::AT_SUBSCRIBER,
                    'message' => "{$subscriberUser->name} ({$tierName}) subscribed to you!",
                    'read' => false,
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]);

            }
        }
    }
}
