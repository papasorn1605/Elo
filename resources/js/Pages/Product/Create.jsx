import { Inertia } from '@inertiajs/inertia';
import { useState } from 'react';
// สร้าง state สำหรับเก็บข้อมูลฟอร์ม
export default function AddOrderForm() {
    const [formData, setFormData] = useState({
        CustomerName: '',
        TotalAmount: '',
        OrderDate: '',
        Phone: '',
        Email: '',
        Address: '', // เพิ่มฟิลด์ Address
    });
    // สร้าง state สำหรับเก็บข้อผิดพลาด
    const [errors, setErrors] = useState({});
    // ฟังก์ชันสำหรับจัดการการเปลี่ยนแปลงในฟอร์ม
    const handleChange = (e) => {
        const { name, value } = e.target;
        setFormData({
            ...formData,
            [name]: value,
        });
    };
    // ฟังก์ชันสำหรับจัดการการส่งฟอร์ม
    const handleSubmit = (e) => {
        e.preventDefault();

        setErrors({}); // รีเซ็ตข้อผิดพลาดก่อนส่งข้อมูล

        // ตรวจสอบข้อมูล
        let formErrors = {};

        if (!formData.CustomerName) {
            formErrors.CustomerName = 'Customer Name is required.';
        }
        if (!formData.TotalAmount) {
            formErrors.TotalAmount = 'Total Amount is required.';
        }
        if (!formData.OrderDate) {
            formErrors.OrderDate = 'Order Date is required.';
        }
        if (!formData.Phone) {
            formErrors.Phone = 'Phone number is required.';
        }
        if (!formData.Email) {
            formErrors.Email = 'Email is required.';
        }
        if (!formData.Address) {
            formErrors.Address = 'Address is required.';
        }
        // ถ้ามีข้อผิดพลาด ให้ตั้งค่า errors และหยุดการส่งฟอร์ม
        if (Object.keys(formErrors).length > 0) {
            setErrors(formErrors);
            return;
        }

        // ส่งข้อมูลไปที่เซิร์ฟเวอร์
        Inertia.post(route('orders.store'), formData, {
            onSuccess: () => {
                // รีเซ็ตฟอร์มเมื่อส่งข้อมูลสำเร็จ
                setFormData({
                    CustomerName: '',
                    TotalAmount: '',
                    OrderDate: '',
                    Phone: '',
                    Email: '',
                    Address: '', // รีเซ็ต Address
                });
            },
            onError: (err) => {
                // ตั้งค่าข้อผิดพลาดเมื่อเกิดข้อผิดพลาดในการส่งข้อมูล
                setErrors(err);
            },
        });
    };

    return (
        <div className="container mx-auto p-8">
            <h1 className="mb-8 text-4xl font-extrabold text-gray-800">
                Add New Order
            </h1>

            <div className="mb-8 flex items-center space-x-4 rounded-lg bg-white p-6 shadow-lg">
                <form onSubmit={handleSubmit} className="w-full space-y-6">
                    {/* Customer Name */}
                    <div className="form-group">
                        <label className="block text-sm font-medium text-gray-700">
                            Customer Name
                        </label>
                        <input
                            type="text"
                            name="CustomerName"
                            value={formData.CustomerName}
                            onChange={handleChange}
                            required
                            className="mt-1 block w-full rounded-lg border border-gray-300 p-3 focus:outline-none focus:ring-2 focus:ring-gray-500"
                        />
                        {errors.CustomerName && (
                            <div className="text-sm text-red-500">
                                {errors.CustomerName}
                            </div>
                        )}
                    </div>

                    {/* Total Amount */}
                    <div className="form-group">
                        <label className="block text-sm font-medium text-gray-700">
                            Total Amount
                        </label>
                        <input
                            type="number"
                            name="TotalAmount"
                            value={formData.TotalAmount}
                            onChange={handleChange}
                            required
                            className="mt-1 block w-full rounded-lg border border-gray-300 p-3 focus:outline-none focus:ring-2 focus:ring-gray-500"
                        />
                        {errors.TotalAmount && (
                            <div className="text-sm text-red-500">
                                {errors.TotalAmount}
                            </div>
                        )}
                    </div>

                    {/* Order Date */}
                    <div className="form-group">
                        <label className="block text-sm font-medium text-gray-700">
                            Order Date
                        </label>
                        <input
                            type="date"
                            name="OrderDate"
                            value={formData.OrderDate}
                            onChange={handleChange}
                            required
                            className="mt-1 block w-full rounded-lg border border-gray-300 p-3 focus:outline-none focus:ring-2 focus:ring-gray-500"
                        />
                        {errors.OrderDate && (
                            <div className="text-sm text-red-500">
                                {errors.OrderDate}
                            </div>
                        )}
                    </div>

                    {/* Phone */}
                    <div className="form-group">
                        <label className="block text-sm font-medium text-gray-700">
                            Phone
                        </label>
                        <input
                            type="text"
                            name="Phone"
                            value={formData.Phone}
                            onChange={handleChange}
                            required
                            className="mt-1 block w-full rounded-lg border border-gray-300 p-3 focus:outline-none focus:ring-2 focus:ring-gray-500"
                        />
                        {errors.Phone && (
                            <div className="text-sm text-red-500">
                                {errors.Phone}
                            </div>
                        )}
                    </div>

                    {/* Email */}
                    <div className="form-group">
                        <label className="block text-sm font-medium text-gray-700">
                            Email
                        </label>
                        <input
                            type="email"
                            name="Email"
                            value={formData.Email}
                            onChange={handleChange}
                            required
                            className="mt-1 block w-full rounded-lg border border-gray-300 p-3 focus:outline-none focus:ring-2 focus:ring-gray-500"
                        />
                        {errors.Email && (
                            <div className="text-sm text-red-500">
                                {errors.Email}
                            </div>
                        )}
                    </div>

                    {/* Address */}
                    <div className="form-group">
                        <label className="block text-sm font-medium text-gray-700">
                            Address
                        </label>
                        <input
                            type="text"
                            name="Address"
                            value={formData.Address}
                            onChange={handleChange}
                            required
                            className="mt-1 block w-full rounded-lg border border-gray-300 p-3 focus:outline-none focus:ring-2 focus:ring-gray-500"
                        />
                        {errors.Address && (
                            <div className="text-sm text-red-500">
                                {errors.Address}
                            </div>
                        )}
                    </div>

                    {/* แสดงข้อผิดพลาดทั่วไป */}
                    {errors.general && (
                        <div className="text-sm text-red-500">
                            {errors.general}
                        </div>
                    )}

                    <div className="form-group">
                        <button
                            type="submit"
                            className="w-full rounded-lg bg-gray-600 px-6 py-3 font-semibold text-white transition duration-300 hover:bg-gray-700"
                        >
                            Add Order
                        </button>
                    </div>
                </form>
            </div>
        </div>
    );
}
