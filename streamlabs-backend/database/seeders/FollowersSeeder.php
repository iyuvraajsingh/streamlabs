<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Carbon\Carbon;
use App\Models\Follower;
use App\Models\User;
use App\Models\Notification;
use App\Constants;



class FollowersSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create(); 

        $users = User::all();

        foreach ($users as $user) {
            for ($i = 0; $i < random_int(5, 10); $i++) {
                $followerUser = User::where('id', '!=', $user->id)->inRandomOrder()->first();
                
                $daysRange = ($i % 2 === 0) ? [1, 29] : [1, 90];
                $createdAt = Carbon::now()->subDays(rand(...$daysRange))->subHours(rand(1, 24));

                $follower = Follower::create([
                    'user_id' => $user->id,
                    'follower_id' => $followerUser->id,
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]);

                Notification::create([
                    'user_id' => $user->id,
                    'action_id' => $follower->id,
                    'action_type' => Constants::AT_FOLLOWER,
                    'message' => "{$followerUser->name} followed you!",
                    'read' => false,
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]);
            }
        }
    }
}
