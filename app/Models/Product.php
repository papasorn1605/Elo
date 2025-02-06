<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer; // ✅ Import Customer
use App\Models\OrderDetail; // ✅ Import OrderDetail

class Product extends Model
{
    use HasFactory;

    // กำหนดชื่อตารางในฐานข้อมูล
    protected $table = 'products';

    // กำหนด Primary Key
    protected $primaryKey = 'ProductID';

    // ระบุว่า Primary Key เป็น Auto-Increment หรือไม่
    public $incrementing = true;
    protected $keyType = 'int';

    // ปิด timestamps ถ้าไม่มี created_at และ updated_at
    public $timestamps = false;

    // ระบุฟิลด์ที่สามารถบันทึกได้
    protected $fillable = [
        'ProductID',
        'ProductName',
        'Stock',
        'UnitPrice',
    ];

    // 🔹 ความสัมพันธ์กับ Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'CustomerID');
    }

    // 🔹 ความสัมพันธ์กับ OrderDetail
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'ProductID');
    }
}