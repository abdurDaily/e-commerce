<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = new User();
        $users->name = 'abdur';
        $users->email = 'abdur@gmail.com';
        $users->password = bcrypt('password');
        $users->save();
    }
}
