<?php

namespace Database\Seeders;

use App\Models\Post;
use Faker\Factory;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        foreach(range(1,5) as $index){
             Post::create([
                 'title'=> $faker->paragraph,
                 'description'=> $faker->text
             ]);
        }
    }
}
