<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = $request->input('search');

        // ดึงข้อมูลคำสั่งซื้อ 
        $orders = Order::with([
            'customer'               // Eager load customer details
        ])
        ->where(function ($q) use ($query) {
            // ค้นหาจาก CustomerName ใน customer
            $q->whereHas('customer', function ($q) use ($query) {
                $q->where('CustomerName', 'like', "%$query%");
            });
        })
        ->paginate(20)
        ->appends(['search' => $query]);

        return Inertia::render('Product/Index', [
            'orders' => $orders,
            'query' => $query,
        ]);
    }
}