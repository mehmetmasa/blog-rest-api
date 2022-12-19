<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Article::insert([
            'title' => 'PHP',
            'slug' => "php-article",
            'content' => 1,
            'tag' => 'PHP, Laravel',
            'situation' => 1,
            'categoryId' => 1,
            'authorId' => 1
        ]);
    }
}
