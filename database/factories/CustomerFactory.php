<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Customer::class;

    public function definition(): array
    {
        return [
            'name'         => $this->faker->name(50),
            'socialReason' => $this->faker->text(100),
            'cnpj'         => $this->faker->text(16),
            'created_at'   => Carbon::now(),
        ];
    }
}
