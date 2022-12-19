<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::insert([
            'nameSurname' => 'Admin',
            'username' => 'admin',
            'password' => app('hash')->make('admin'),
            'situation' => 1
        ]);
    }
}
