<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Carbon\Carbon;
use App\Models\Donation;
use App\Models\User;
use App\Models\Notification;
use App\Constants;

class DonationsSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        $verbs = ['supporting', 'aiding', 'assisting', 'backing', 'contributing to', 'helping'];
        $nouns = ['cause', 'mission', 'initiative', 'project', 'endeavor'];


        $users = User::all();

        foreach ($users as $user) {
            for ($i = 0; $i < random_int(5, 10); $i++) {
                $donationUser = User::where('id', '!=', $user->id)->inRandomOrder()->first();

                $daysRange = ($i % 2 === 0) ? [1, 29] : [1, 90];
                $createdAt = Carbon::now()->subDays(rand(...$daysRange))->subHours(rand(1, 24));

                $donationMessage = "Thank you " . $donationUser->name . ", for " . $faker->randomElement($verbs) . " our " . $faker->randomElement($nouns) . ". We truly appreciate your support!";


                $donation = Donation::create([
                    'user_id' => $user->id,
                    'donation_user_id' => $donationUser->id,
                    'amount' => $faker->randomFloat(2, 10, 500),
                    'currency' => Constants::PRIMARY_CURRENCY,
                    'donation_message' => $donationMessage,
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]);

                Notification::create([
                    'user_id' => $user->id,
                    'action_id' => $donation->id,
                    'action_type' => Constants::AT_DONATION,
                    'message' => "{$donationUser->name} donated {$donation->amount} {$donation->currency} to you! \"{$donation->donation_message}\"",
                    'read' => false,
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]);
            }
        }
    }
}
