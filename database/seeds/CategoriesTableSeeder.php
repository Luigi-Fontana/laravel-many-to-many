<?php

use Illuminate\Database\Seeder;
use App\Category;
use App\User;
use Faker\Generator as Faker;

class CategoriesTableSeeder extends Seeder
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
            $category = new Category;
            $category->user_id = $user->id;
            $category->name = $faker->sentence(3, true);
            $category->description = $faker->sentence(6, true);
            $category->save();
        }
    }
}
