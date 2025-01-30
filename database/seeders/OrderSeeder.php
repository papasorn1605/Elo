<?php

namespace Database\Seeders;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Order::factory(100)->create()->each(function ($order) {
            // ตรวจสอบว่ามีการสร้าง Order หรือไม่
            if (!$order->id) {
                throw new \Exception('Order ID is null');
            }
            // สร้าง OrderDetail สำหรับแต่ละ Order
            OrderDetail::factory(3)->create([
                'OrderID' => $order->id,  // ใช้ OrderID ที่ไม่เป็น null
            ]);
        });
    }
}