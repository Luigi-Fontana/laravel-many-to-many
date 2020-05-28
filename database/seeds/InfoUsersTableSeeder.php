<?php

use Illuminate\Database\Seeder;
use App\InfoUser;
use App\User;
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
        $users = User::doesntHave('info')->get();
        // $infos = InfoUser:all();

        foreach ($users as $user) {
            $info = new InfoUser;
            $info->user_id = $user->id;
            $info->bio = $faker->paragraph(6, true);
            $info->linkedin = $faker->sentence(3, true);
            $info->twitter = $faker->sentence(3, true);
            $info->facebook = $faker->sentence(3, true);
            $info->photo = 'https://picsum.photos/200/200';
            $info->save();
        }
    }
}
