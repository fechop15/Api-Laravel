<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //php artisan db:seed --class=PostSeeder
        $faker = Faker::create();
        for ($i = 0; $i < 20; $i++) {
            $title = $faker->sentence;
            $content = $faker->text(3000);
            $slug = Str::slug($title);
            $post=Post::create([
                'title' => $title,
                'content' => $content,
                'slug' => $slug,
                'user_id' => rand(1, 2),
                'is_published' => $faker->boolean(),
            ]);
            for ($j = 0; $j < 10; $j++) {
                DB::table('comments')->insert(array(
                    'content' => $faker->sentence,
                    'is_published' => $faker->boolean(),
                    'post_id' => $post->id,
                    'user_id' => rand(1, 2),

                ));
            }
        }
    }
}
