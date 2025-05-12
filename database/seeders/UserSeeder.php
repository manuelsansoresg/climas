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
        $data_user = array('name' => 'Alejandro',
        'email' => 'manuelsansoresg@gmail.com', 'password' => bcrypt('demor00txx'));
        $user = new User($data_user);
        $user->save();
    }
}
