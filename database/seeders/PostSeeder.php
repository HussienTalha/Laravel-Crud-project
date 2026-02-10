<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\Category;
use App\Models\User;
class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $categories = Category::all();

        Post::factory()
            ->count(10)
            ->create( [
                    'user_id' => $users->random()->id,
                    'category_id' => $categories->random()->id
                ]
            );
    }
}
