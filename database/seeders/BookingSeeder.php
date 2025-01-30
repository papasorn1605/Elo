<?php

namespace Database\Seeders;
use App\Models\Booking;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Booking::factory(100)->create(); // สร้างข้อมูล Booking 100 รายการ
    }

}