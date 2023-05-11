<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Order::factory(50)->create();

        $orders = json_decode(file_get_contents(public_path() . "/dummy_data/orders.json"), true);

        foreach ($orders as $key => $value) {
            Order::create([
                "member_id" => $value['member_id'],
                "origin_order_id" => $value['origin_order_id'],
                "origin_order_code" => $value['origin_order_code'],
                "waybill_number" => $value['waybill_number'],
                "origin_invoice_id" => $value['origin_invoice_id'],
                "origin_invoice_code" => $value['origin_invoice_code'],
                "order_code" => $value['order_code'],
                "invoice_id" => $value['invoice_id'],
                "invoice_code" => $value['invoice_code'],
                "supplier_id" => $value['supplier_id'],
                "supplier_name" => $value['supplier_name'],
                "supplier_address" => $value['supplier_address'],
                "name" => $value['name'],
                "phone" => $value['phone'],
                "province_id" => $value['province_id'],
                "province_name" => $value['province_name'],
                "city_id" => $value['city_id'],
                "city_name" => $value['city_name'],
                "subdistrict_id" => $value['subdistrict_id'],
                "subdistrict_name" => $value['subdistrict_name'],
                "address" => $value['address'],
                "note" => $value['note'],
                "postal_code" => $value['postal_code'],
                "status" => $value['status'],
                "payment_status" => $value['payment_status'],
                "unique_code" => $value['unique_code'],
                "subtotal" => $value['subtotal'],
                "shipping_cost" => $value['shipping_cost'],
                "total" => $value['total'],
                "shipping_courier" => $value['shipping_courier'],
                "shipping_service" => $value['shipping_service'],
            ]);
        }
    }
}
