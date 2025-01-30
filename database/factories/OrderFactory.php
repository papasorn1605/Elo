<?php

namespace Database\Factories;
use App\Models\Order;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition()
    {
        return [
            'OrderDate' => $this->faker->dateTimeThisCentury(),
            'CustomerID' => Customer::inRandomOrder()->first()->CustomerID,  // ดึงข้อมูลลูกค้าแบบสุ่ม
            'TotalAmount' => $this->faker->randomFloat(2, 20, 500),
        ];
    }


    /**
     * สร้างสถานะที่บ่งบอกว่าออเดอร์นี้เป็นออเดอร์ที่ไม่ได้รับการชำระ
     */
    public function unpaid(): static
    {
        return $this->state(fn (array $attributes) => [
            'TotalAmount' => 0, // กำหนดยอดรวมเป็น 0 เพื่อบ่งบอกว่าเป็นออเดอร์ที่ไม่ได้ชำระ
        ]);
    }
}