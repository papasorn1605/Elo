import { Inertia } from '@inertiajs/inertia';
import { useState } from 'react';

export default function Edit({ order }) {
    // กำหนด state สำหรับข้อมูลในฟอร์ม โดยการตั้งค่าเริ่มต้นจากข้อมูล order
    const [formData, setFormData] = useState({
        CustomerName: order.CustomerName || '',
        TotalAmount: order.TotalAmount || '',
        OrderDate: order.OrderDate ? order.OrderDate.replace(' ', 'T') : '', // เปลี่ยนจาก YYYY-MM-DD HH:MM:SS เป็น YYYY-MM-DDTHH:MM
    });

    // ฟังก์ชันสำหรับการจัดการการเปลี่ยนแปลงในช่อง input
    const handleChange = (e) => {
        const { name, value } = e.target;
        setFormData({
            ...formData,
            [name]: value,
        });
    };

    // ฟังก์ชันส่งข้อมูลไปยัง server เมื่อส่งฟอร์ม
    const handleSubmit = (e) => {
        e.preventDefault();
        Inertia.put(route('order.update', order.OrderID), formData); // ส่งข้อมูลไปยัง backend
    };

    return (
        <div className="container mx-auto p-8">
            <h1 className="mb-8 text-4xl font-extrabold text-gray-800">
                Edit Order
            </h1>
            <form onSubmit={handleSubmit} className="space-y-6">
                {/* ช่องกรอก CustomerName */}
                <div>
                    <label
                        htmlFor="CustomerName"
                        className="block text-sm font-medium text-gray-600"
                    >
                        Customer Name
                    </label>
                    <input
                        type="text"
                        id="CustomerName"
                        name="CustomerName"
                        value={formData.CustomerName} // ใช้ค่า formData เพื่อให้ชื่อเก่าแสดงใน input
                        onChange={handleChange}
                        required
                        className="mt-2 w-full rounded-lg border-gray-300 p-3 text-sm focus:outline-none focus:ring-2 focus:ring-gray-500"
                    />
                </div>

                {/* ช่องกรอก TotalAmount */}
                <div>
                    <label
                        htmlFor="TotalAmount"
                        className="block text-sm font-medium text-gray-600"
                    >
                        Total Amount
                    </label>
                    <input
                        type="number"
                        id="TotalAmount"
                        name="TotalAmount"
                        value={formData.TotalAmount} // ใช้ค่า formData
                        onChange={handleChange}
                        required
                        className="mt-2 w-full rounded-lg border-gray-300 p-3 text-sm focus:outline-none focus:ring-2 focus:ring-gray-500"
                    />
                </div>

                {/* ช่องกรอก OrderDate */}
                <div>
                    <label
                        htmlFor="OrderDate"
                        className="block text-sm font-medium text-gray-600"
                    >
                        Order Date
                    </label>
                    <input
                        type="datetime-local"
                        id="OrderDate"
                        name="OrderDate"
                        value={formData.OrderDate} // ใช้ค่า formData
                        onChange={handleChange}
                        required
                        className="mt-2 w-full rounded-lg border-gray-300 p-3 text-sm focus:outline-none focus:ring-2 focus:ring-gray-500"
                    />
                </div>

                {/* ปุ่ม submit */}
                <div className="mt-6">
                    <button
                        type="submit"
                        className="w-full rounded-lg bg-gray-500 px-4 py-2 text-white hover:bg-gray-600 sm:w-auto"
                    >
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    );
}
