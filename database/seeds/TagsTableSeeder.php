<?php

use Illuminate\Database\Seeder;
use App\Tag;
use App\User;
use Faker\Generator as Faker;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i=0; $i < 30; $i++) {
            $user = User::inRandomOrder()->first();
            $tag = new Tag;
            $tag->user_id = $user->id;
            $tag->name = $faker->sentence(2, true);
            $tag->save();
        }
    }
}
