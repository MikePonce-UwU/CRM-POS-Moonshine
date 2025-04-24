<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Customer;
use App\Models\Order;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'order_number' => fake()->regexify('[A-Za-z0-9]{20}'),
            'customer_id' => Customer::factory(),
            'order_date' => fake()->date(),
            'total_amount' => fake()->randomFloat(0, 0, 9999999999.),
            'status' => fake()->regexify('[A-Za-z0-9]{20}'),
        ];
    }
}
