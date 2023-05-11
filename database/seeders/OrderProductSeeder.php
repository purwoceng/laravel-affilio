<?php

namespace Database\Seeders;

use App\Models\OrderProduct;
use Illuminate\Database\Seeder;

class OrderProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // OrderProduct::factory(50)->create();

        $orderProducts = json_decode(file_get_contents(public_path() . "/dummy_data/order_products.json"), true);

        foreach ($orderProducts as $key => $value) {
            OrderProduct::create([
                "order_id" => $value['order_id'],
                "origin_product_id"=> $value['origin_product_id'],
                "product_name"=> $value['product_name'],
                "quantity"=> $value['quantity'],
                "weight"=> $value['weight'],
                "total_weight"=> $value['total_weight'],
                "price_markup"=> $value['price_markup'],
                "total_price_markup"=> $value['total_price_markup'],
                "origin_price"=> $value['origin_price'],
                "total_origin_price"=> $value['total_origin_price'],
                "price"=> $value['price'],
                "total_price"=> $value['total_price'],
                "profit"=> $value['profit'],
                "total_profit"=> $value['total_profit'],
                "variant_id"=> $value['variant_id'],
                "variant_name"=> $value['variant_name'],
            ]);
        }
    }
}
