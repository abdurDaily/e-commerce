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

        $userData = [
            [
                'name' => 'abdur',
                'email' => 'abdur@gmail.com',
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'test',
                'email' => 'test@gmail.com',
                'password' => bcrypt('password'),
            ],
        ];


        foreach($userData as $user){
            $userData = new User();
            $userData->name = $user['name'];
            $userData->email = $user['email'];
            $userData->password = $user['password'];
            $userData->save();
        }
    }
}
