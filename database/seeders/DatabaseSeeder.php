<?php

namespace Database\Seeders;

use App\Models\Messages;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call([
            UserSeeder::class,
            MessageTypeSeeder::class,
            StatusTypeSeeder::class,
        ]);
//        User::factory()->count(5)->create();
//        Messages::factory()->count(250)->create();
    }
}
