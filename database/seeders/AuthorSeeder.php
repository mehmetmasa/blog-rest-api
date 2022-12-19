<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Author::insert([
            [
                'name' => 'Author Test',
                'username' => 'author',
                'password' =>app('hash')->make('author'),
                'situation' => AUTHOR_ACTIVE,
            ]
        ]);
    }
}
