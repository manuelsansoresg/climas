<?php

namespace Database\Seeders;

use App\Models\Warehouse;
use Illuminate\Database\Seeder;

class WareHouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $warehouse = new Warehouse();
        $warehouse->name = 'JACU';
        $warehouse->location = 'Calle Principal 123';
        $warehouse->save();
    }
}
