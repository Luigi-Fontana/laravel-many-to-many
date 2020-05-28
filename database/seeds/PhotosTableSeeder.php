<?php

use Illuminate\Database\Seeder;
use App\Photo;
use App\User;
use Faker\Generator as Faker;

class PhotosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i=0; $i < 20; $i++) {
            $user = User::inRandomOrder()->first();
            $photo = new Photo;
            $photo->user_id = $user->id;
            $photo->name = $faker->sentence(3, true);
            $photo->path = 'https://picsum.photos/200/300';
            $photo->description = $faker->sentence(6, true);
            $photo->save();
        }
    }
}
