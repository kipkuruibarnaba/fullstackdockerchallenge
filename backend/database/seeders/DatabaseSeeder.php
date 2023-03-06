<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Weather;
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
         User::factory(20)->create();
         Weather::factory(1)->create();
    }
}
