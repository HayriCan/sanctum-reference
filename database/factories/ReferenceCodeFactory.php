<?php

namespace Database\Factories;

use App\Models\ReferenceCode;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReferenceCodeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ReferenceCode::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'code' => $this->faker->unique()->isbn10(),
            'referrer_id' => 1,
            'active' => true,
        ];
    }
}
