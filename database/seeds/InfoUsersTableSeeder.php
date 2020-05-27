<?php

use Illuminate\Database\Seeder;
use App\InfoUser;
use Faker\Generator as Faker;

class InfoUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i=1; $i <= 10; $i++) {
            $info = new InfoUser;
            $info->user_id = $i;
            $info->bio = $faker->paragraph(6, true);
            $info->linkedin = $faker->sentence(6, true);
            $info->twitter = $faker->sentence(6, true);
            $info->facebook = $faker->sentence(6, true);
            $info->photo = $faker->sentence(6, true);
            $info->save();
        }
    }
}
