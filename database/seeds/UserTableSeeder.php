<?php

use App\Models\User;  
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder  
{
    public function run()
    {
        User::create([
            'name' => 'admin',
            'password' => bcrypt('123123'),
            'email' => 'admin@qq.com',
            'phone' => '13211111111',
            'role' => 'admin'
        ]);
    }
}