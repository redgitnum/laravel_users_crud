<?php

namespace Database\Factories;

use App\Models\Worker;
use Illuminate\Database\Eloquent\Factories\Factory;

class WorkerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Worker::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => 1,
            'postal_state' => $this->faker->state,
            'postal_city' => $this->faker->city,
            'postal_code' => $this->faker->postcode,
            'postal_street' => $this->faker->streetName,
            'postal_number' => $this->faker->buildingNumber,
            'address_state' => $this->faker->name,
            'address_city' => $this->faker->city,
            'address_code' => $this->faker->postcode,
            'address_street' => $this->faker->streetName,
            'address_number' => $this->faker->buildingNumber,
        ];
    }
}
