<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user=\App\Models\User::create(
        [
            'name'=>'super admin',
            'email'=>'Admin22@gmail.com',
            'password' => Hash::make('AA@0932'),
            'user_type'=>'super_admin',
        ]);

    }
}

