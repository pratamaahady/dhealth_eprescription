<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->setData('admin','password','Administrator');
    }

    public function setData($username, $password, $name){
        User::create([
            'username' => $username,
            'password' => bcrypt($password),
            'name' => $name,
        ]);
    }
}
