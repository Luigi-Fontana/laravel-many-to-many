<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Generator as Faker;
use Carbon\Carbon;
use App\Page;
use App\Category;
use App\User;
use App\Photo;
use App\Tag;


class PagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i=0; $i < 50; $i++) {
            $user = User::inRandomOrder()->first();
            $category = Category::inRandomOrder()->first();
            $page = new Page;
            $page->user_id = $user->id;
            $page->category_id = $category->id;
            $page->title = $faker->sentence(3, true);
            $page->summary = $faker->sentence(6, true);
            $page->body = $faker->paragraph(6, true);
            $now = Carbon::now()->format('Y-m-d-H-i-s');
            $page->slug = Str::slug($page->title, '-') . $now;
            $page->save();

            $photos = Photo::inRandomOrder()->limit(rand(1,5))->get();
            $page->photos()->attach($photos);

            $tags = Tag::inRandomOrder()->limit(rand(1,10))->get();
            $page->tags()->attach($tags);
        }
    }
}
