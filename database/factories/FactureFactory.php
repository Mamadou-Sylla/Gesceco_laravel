<?php

namespace Database\Factories;

use App\Models\Facture;
use Illuminate\Database\Eloquent\Factories\Factory;

class FactureFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Facture::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $Money = [10000,15000,20000,25000];
        $Num = [001260621, 002260621, 003260621, 004260621, 005260621];

        return [
                # code...
                'numero' => $this->faker->randomElement($Num),
                'montant' => $this->faker->randomElement($Money),
                'date' => $this->faker->date()
        ];
    }
}
