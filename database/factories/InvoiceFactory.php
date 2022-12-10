<?php

namespace Database\Factories;

use App\Models\Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

    protected $model = Invoice::class;

    public function definition()
    {
        $status =['unpaid','confirm','pending','paid','cancel','refund'];
        $index = array_rand($status, 1);
        $generateStatus = $status[$index];

        $code = 'AF' .$this->faker->numerify('##########');

        return [
            'code' => $code,
            'payment_code' => 0,
            'payment_method' => 'midtrans',
            'member_id' => $this->faker->boolean(50),
            'type'=> 'order',
            'username' => $this->faker->userName,
            'subtotal' => $this->faker->numerify('######'),
            'fee_midtrans' => $this->faker->numerify('######'),
            'shipping_cost' => $this->faker->numerify('######'),
            'total' => $this->faker->numerify('######'),
            'description' => $this->faker->text(30),
            'status' => $generateStatus,
            'whatsapp_number' => $this->faker->phoneNumber,
            'publish' => '1',
        ];
    }
}
