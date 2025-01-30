<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // For DB facade
use Inertia\Inertia; // For Inertia

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) // เพิ่มตัวแปร $request เพื่อรับค่าจากคำขอ
    {
        // รับค่าคำค้นหาจาก input ชื่อ 'search' ที่มาจากหน้าเว็บ
        $query = $request->input('search');

        // ดึงข้อมูลคำสั่งซื้อจากตาราง orders, order_details, และ products ที่ตรงกับคำค้นหา
        $orders = DB::table('orders')
    ->join('order_details', 'orders.OrderID', '=', 'order_details.OrderID')
    ->join('products', 'order_details.ProductID', '=', 'products.ProductID')
    ->join('customers', 'orders.CustomerID', '=', 'customers.CustomerID')
    ->where('orders.OrderID', 'like', '%' . $query . '%')
    ->orWhere('order_details.ProductID', 'like', '%' . $query . '%')
    ->orWhere('products.Productname', 'like', '%' . $query . '%')
    ->orWhere('customers.CustomerName', 'like', '%' . $query . '%')
    ->orWhere('customers.Phone', 'like', '%' . $query . '%')
    ->orWhere('customers.Email', 'like', '%' . $query . '%')
    ->orWhere('order_details.OrderDetailID', '=', $query)
    ->orWhere('order_details.updated_at', 'like', '%' . $query . '%')
    ->orWhere('orders.created_at', 'like', '%' . $query . '%')
    ->orWhere('orders.TotalAmount', 'like', '%' . $query . '%') // แก้ไขเป็นคอลัมน์ TotalAmount ใน orders
    ->paginate(20)
    ->appends(['search' => $query]);


        // ส่งข้อมูลคำสั่งซื้อและคำค้นหาไปยังหน้า Inertia 'Order/Index'
        return Inertia::render('Product/Index', [
            'orders' => $orders,
            'query' => $query,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}