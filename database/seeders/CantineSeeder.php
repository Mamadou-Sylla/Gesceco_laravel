<?php

namespace Database\Seeders;

use App\Models\Cantine;
use Illuminate\Database\Seeder;

class CantineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Cantine::factory()->count(5)->create(); 
    }
}
