<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      /*   Role::create(['name' => 'Admin']);
        Role::create(['name' => 'Ventas']); */
        Role::create(['name' => 'Cliente mayorista']);
        Role::create(['name' => 'Cliente publico en general']);
        Role::create(['name' => 'Cliente instalador']);
    }
}
