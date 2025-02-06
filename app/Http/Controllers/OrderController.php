<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Models\Order;
use App\Models\Customer;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;

class OrderController extends Controller
{
    /**
     * Display a listing of the orders.
     */
    public function index(Request $request)
    {
        $query = $request->input('search');

        // ดึงข้อมูลคำสั่งซื้อ พร้อมลูกค้า
        $orders = Order::with('customer') // ดึงข้อมูลลูกค้าของคำสั่งซื้อ
            ->whereHas('customer', function ($q) use ($query) {
                $q->where('CustomerName', 'like', "%$query%");
            })
            ->paginate(20)
            ->appends(['search' => $query]);

        return Inertia::render('Product/Index', [
            'orders' => $orders,
            'query' => $query,
        ]);
    }

    /**
     * แสดงฟอร์มสำหรับสร้างคำสั่งซื้อใหม่
     */
    public function create()
    {
        return Inertia::render('Product/Create');
    }

    /**
     * บันทึกข้อมูลคำสั่งซื้อใหม่
     */
    public function store(Request $request)
    {
        //ตรวจสอบค่าที่ส่งมาจากฟอร์ม
        $validated = $request->validate([
            'CustomerName' => 'required',
            'TotalAmount' => 'required|numeric',
            'OrderDate' => 'required|date',
            'Phone' => 'required',
            'Email' => 'required|email|unique:customers,Email',
            'Address' => 'nullable|string',
        ]);

        // ตรวจสอบว่า OrderDate มีเวลาอยู่หรือไม่
        $formattedOrderDate = Carbon::parse($validated['OrderDate']);

        // หากไม่ได้ระบุเวลาให้ตั้งเวลาเริ่มต้นเป็น 12:00 PM (หรือเวลาที่ต้องการ)
        if ($formattedOrderDate->format('H:i') == '00:00') {
            $formattedOrderDate->setTime(12, 0); // ตั้งเวลาเริ่มต้นเป็น 12:00 PM
        }

        // ค้นหาลูกค้าหรือสร้างลูกค้าใหม่
        $customer = Customer::where('CustomerName', $validated['CustomerName'])->first();
        // หากไม่พบลูกค้า ให้สร้างลูกค้าใหม่
        if (!$customer) {
            $customer = Customer::create([
                'CustomerName' => $validated['CustomerName'],
                'Phone' => $validated['Phone'],
                'Email' => $validated['Email'],
                'Address' => $validated['Address'] ?? null,
            ]);
        }

        // สร้างคำสั่งซื้อใหม่
        $order = Order::create([
            'CustomerID' => $customer->CustomerID,
            'TotalAmount' => $validated['TotalAmount'],
            'OrderDate' => $formattedOrderDate,
        ]);

        // Log the order creation
        Log::info('New order created:', [
            'CustomerName' => $validated['CustomerName'],
            'TotalAmount' => $validated['TotalAmount'],
            'OrderDate' => $formattedOrderDate->toDateTimeString(), // Log วันที่และเวลา
            'Phone' => $validated['Phone'],
            'Email' => $validated['Email'],
        ]);

        // สามารถดึงข้อมูลลูกค้าพร้อมคำสั่งซื้อได้ที่นี่
        $order->load('customer');

        return redirect()->route('orders.index')->with('success', 'Order added successfully.');
    }



    /**
     * แสดงข้อมูลของคำสั่งซื้อ
     */
    public function show(Order $order)
    {
        return Inertia::render('Order/Show', ['order' => $order]);
    }

    /**
     * แสดงฟอร์มสำหรับแก้ไขคำสั่งซื้อ
     */
    public function edit($OrderID)
    {
    // ค้นหาคำสั่งซื้อที่ต้องการแก้ไข
        $order = Order::where('OrderID', $OrderID)->firstOrFail();

    // ส่งข้อมูลคำสั่งซื้อไปยังหน้า Edit
        return Inertia::render('Product/Edit', ['order' => $order]);
    }

    /**
     * อัพเดตข้อมูลคำสั่งซื้อ
     */
    public function update(Request $request, $OrderID)
{
    // ตรวจสอบค่าที่ส่งมาจากฟอร์ม
    $validated = $request->validate([
        'CustomerName' => 'required',
        'TotalAmount' => 'required|numeric',
        'OrderDate' => 'required|date_format:Y-m-d\TH:i', // ตรวจสอบว่าใช้รูปแบบรวมเวลา
    ]);

    // แปลงข้อมูลวันที่และเวลา
    $formattedDateTime = Carbon::createFromFormat('Y-m-d\TH:i', $validated['OrderDate']);

    // หากเวลาเป็น 00:00:00 (ถ้าไม่ได้ระบุเวลาในฟอร์ม)
    if ($formattedDateTime->format('H:i') == '00:00') {
        // กำหนดเวลาเริ่มต้นเป็นเวลา 12:00 PM
        $formattedDateTime->setTime(12, 0); // กำหนดเวลาเป็น 12:00 PM
    }

    // ค้นหาคำสั่งซื้อที่ต้องการอัพเดต
    $order = Order::where('OrderID', $OrderID)->firstOrFail();

    // อัพเดตคำสั่งซื้อ
    $order->update([
        'TotalAmount' => $validated['TotalAmount'],
        'OrderDate' => $formattedDateTime, // ใช้เวลาที่ถูกต้อง
    ]);

    // อัพเดตข้อมูลลูกค้า
    if ($order->customer) {
        $order->customer->update([
            'CustomerName' => $validated['CustomerName'],
        ]);
    }

    // บันทึกข้อมูลใน log
    Log::info('Order updated:', [
        'OrderID' => $OrderID,
        'TotalAmount' => $validated['TotalAmount'],
        'OrderDate' => $formattedDateTime->toDateTimeString(), // แสดงวันที่และเวลาใน log
        'CustomerName' => $validated['CustomerName'],
    ]);

    return redirect()->route('orders.index')->with('success', 'Order updated successfully.');
}

    /**
     * ลบข้อมูลคำสั่งซื้อ
     */
    public function destroy($OrderID)
    {
        // ค้นหาคำสั่งซื้อที่ต้องการลบ
        $order = Order::where('OrderID', $OrderID)->firstOrFail();
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Order deleted successfully.');
    }
}