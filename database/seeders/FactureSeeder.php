<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class FactureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Facture::factory()->count(5)->create(); 
    }
}
