<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        for ($i = 0; $i < 20; $i++) {
            DB::table('guides')->insert([
                'title' => $faker->text(200),
                'description' => $faker->text(3000),
                'user_id' => $faker->numberBetween(6,12),
                'image_path' => 'uxAEUXlMrFt8LpUJejehWWGhfpPpynNobH4UtFMU.jpg'
            ]);
        }
        //\App\Models\User::factory(10)->create();
    }
}
