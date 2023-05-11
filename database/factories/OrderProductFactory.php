<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'order_id' =>rand(1,Order::count()),
            'origin_product_id' => rand(1,50),
            'product_name' => $this->faker->name(1,8),
            'quantity' => rand(1,5),
            'weight' => $this->faker->numerify('###'),
            'total_weight' => $this->faker->numerify('###'),
            'price_markup' => $this->faker->numerify('#######'),
            'total_price_markup' => $this->faker->numerify('#######'),
            'origin_price' => $this->faker->numerify('#######'),
            'total_origin_price' => $this->faker->numerify('#######'),
            'price' => $this->faker->numerify('#######'),
            'total_price' => $this->faker->numerify('#######'),
            'profit' => $this->faker->numerify('#######'),
            'total_profit' => $this->faker->numerify('#######'),
        ];
    }
}
