<?php

namespace Database\Factories;

use App\Models\Cantine;
use Illuminate\Database\Eloquent\Factories\Factory;

class CantineFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Cantine::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $NumBat = ['A','B','C','D','E'];
        $num = [1,2,3,4,5];
        return [
                # code...
                'numero' => $this->faker->randomElement($NumBat).'00',
                'batiment' => $this->faker->randomElement($NumBat)
            
        ];
    }
}
