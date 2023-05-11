<?php

namespace Database\Factories;

use App\Models\Invoice;
use App\Models\Member;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $status =['unpaid','paid','awaiting_supplier','on_process','on_shipping','received','success','complain','cancel','cancel_but_unpaid'];
        $index = array_rand($status, 1);
        $generateStatus = $status[$index];

        $statusPayment = ['paid','unpaid','cancel'];
        $key = array_rand($statusPayment,1);
        $generatePaymentStatus = $statusPayment[$key];

        return [
            'member_id' => rand(1,Member::count()),
            'origin_order_id' => rand(1,50),
            'origin_order_code' => 'LPX_'. mt_rand(1000000000, 9999999999),
            'waybill_number' => uniqid(),
            'origin_invoice_id' => rand(1,50),
            'origin_invoice_code' => 'Invoice_'. mt_rand(1000000000, 9999999999),
            'order_code' => 'APX_' .  mt_rand(1000000000, 9999999999),
            'invoice_id' => rand('1',Invoice::count()),
            'invoice_code' => 'IX_'. mt_rand(1000000000, 9999999999),
            'supplier_id' => rand(1,50),
            'supplier_name' => $this->faker->name(1,5),
            'supplier_address' => $this->faker->streetAddress,
            'name' => $this->faker->name(1,5),
            'phone' => $this->faker->numerify('############'),
            'province_id' => rand(1,100),
            'province_name' => $this->faker->state,
            'city_id' => rand(1,100),
            'city_name' => $this->faker->city,
            'subdistrict_id' => rand(1,100),
            'subdistrict_name' => $this->faker->city,
            'address' => $this->faker->streetAddress,
            'note' => $this->faker->text(20),
            'postal_code' => $this->faker->postcode(),
            'status'=> $generateStatus,
            'payment_status' => $generatePaymentStatus,
            'unique_code' => $this->faker->unique()->randomNumber(3),
            'subtotal' => $this->faker->numerify('#######'),
            'shipping_cost' => $this->faker->numerify('#######'),
            'total' => $this->faker->numerify('#######'),
            'shipping_courier' => 'IDE',
            'shipping_service' => 'Express',
        ];
    }
}
