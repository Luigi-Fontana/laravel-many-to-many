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
        $files = Storage::disk('public')->files('images');
        foreach ($files as $file) {
            $user =  User::inRandomOrder()->first();
            $photo = new Photo;
            $photo->user_id = $user->id;
            $photo->name = 'Titolo Immagine';
            $photo->path = $file;
            $photo->description = 'Descrizione Immagine';
            $photo->save();
        }
    }
}
