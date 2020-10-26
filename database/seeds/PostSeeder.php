<?php

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
        factory(App\Post::class, 500)->create()->each(function ($post) {
            $languages = \App\Language::inRandomOrder()->take(rand(1,3))->get();
            $services = \App\Service::inRandomOrder()->take(rand(1,7))->get();
            $post->languages()->saveMany($languages);
            $post->services()->saveMany($services);
        });
    }
}
