<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order; // ✅ Import Order

class OrderDetail extends Model
{
    use HasFactory;

    protected $table = 'order_details';
    protected $primaryKey = 'OrderDetailID';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'OrderID',
        'ProductID',
        'Quantity',
        'Price',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'OrderID');
    }
}