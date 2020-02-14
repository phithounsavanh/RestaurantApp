<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = 'Alin';
        $user->email = 'alin@gmail.com';
        $user->password =  Hash::make('12345678');
        $user->save();
    }
}
