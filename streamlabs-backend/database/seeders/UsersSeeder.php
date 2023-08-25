<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;


class UsersSeeder extends Seeder
{
    public function run()
    {

        User::create([
            'name' => "Yuvraj Singh",
            'email' => "me@iyuvraajsingh.com",
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        User::factory(1000)->create();
    }
}
