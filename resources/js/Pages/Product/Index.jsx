import { Inertia } from '@inertiajs/inertia';
import { useState } from 'react';

export default function Index({ orders, query }) {
    const [search, setSearch] = useState(query || '');

    // ฟังก์ชันค้นหา
    const handleSearch = (e) => {
        e.preventDefault();
        if (search.trim()) {
            Inertia.get(route('products.index'), { search });
        }
    };

    // ฟังก์ชันรีเฟรชการค้นหา
    const handleRefresh = () => {
        setSearch('');
        Inertia.get(route('products.index'), { search: '' });
    };

    return (
        <div className="container mx-auto p-8">
            <h1 className="mb-8 text-4xl font-extrabold text-gray-800">
                Order Details
            </h1>

            {/* ฟอร์มค้นหา */}
            <div className="mb-8 flex items-center space-x-4 rounded-lg bg-white p-4 shadow-lg">
                <input
                    type="text"
                    value={search}
                    onChange={(e) => setSearch(e.target.value)}
                    placeholder="Search by OrderID, ProductID, Customer Name..."
                    className="flex-1 rounded-l-lg border border-gray-300 p-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-500"
                />
                <button
                    type="submit"
                    onClick={handleSearch}
                    className="w-full flex-shrink-0 rounded-r-lg bg-gray-600 px-4 py-2 font-semibold text-white transition hover:bg-gray-700 sm:w-auto"
                >
                    Search
                </button>
                <button
                    type="button"
                    onClick={handleRefresh}
                    className="w-full flex-shrink-0 rounded-lg bg-gray-200 px-4 py-2 text-gray-700 transition hover:bg-gray-300 sm:w-auto"
                >
                    <i className="fa fa-sync-alt" aria-hidden="true"></i>{' '}
                    Refresh
                </button>
            </div>

            {/* ตารางข้อมูลคำสั่งซื้อ */}
            <div className="overflow-x-auto rounded-lg bg-white shadow-lg">
                <table className="min-w-full table-auto border-collapse border border-gray-300">
                    <thead>
                        <tr className="bg-gray-100">
                            <th className="border px-6 py-3 text-left text-sm font-medium text-gray-600">
                                OrderID
                            </th>
                            <th className="border px-6 py-3 text-left text-sm font-medium text-gray-600">
                                Customer Name
                            </th>
                            <th className="border px-6 py-3 text-left text-sm font-medium text-gray-600">
                                Total Amount
                            </th>
                            <th className="border px-6 py-3 text-left text-sm font-medium text-gray-600">
                                Order Date
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {orders.data.map((order) => (
                            <tr
                                key={order.OrderID}
                                className="border-b hover:bg-gray-50"
                            >
                                <td className="border px-6 py-4 text-sm text-gray-800">
                                    {order.OrderID}
                                </td>
                                {/* Access ProductID from orderDetails -> product */}
                                {/* Access CustomerName from customer */}
                                <td className="border px-6 py-4 text-sm text-gray-800">
                                    {order.customer?.CustomerName}
                                </td>
                                <td className="border px-6 py-4 text-sm text-gray-800">
                                    {order.TotalAmount}
                                </td>
                                <td className="border px-6 py-4 text-sm text-gray-800">
                                    {order.OrderDate}
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>

            {/* การแบ่งหน้า (Pagination) */}
            <div className="mt-8 flex justify-center">
                {orders.links.map((link) => (
                    <button
                        key={link.label}
                        onClick={() => Inertia.get(link.url)}
                        className={`mx-2 rounded-lg px-4 py-2 text-lg font-medium ${link.active ? 'bg-gray-600 text-white' : 'bg-gray-200 text-gray-700'} transition hover:bg-gray-500`}
                        dangerouslySetInnerHTML={{ __html: link.label }}
                    />
                ))}
            </div>
        </div>
    );
}
