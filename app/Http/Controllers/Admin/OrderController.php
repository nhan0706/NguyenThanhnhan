<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['customer', 'statusRelation'])->orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('order_code', 'LIKE', "%{$search}%")
                  ->orWhereHas('customer', function ($qCustomer) use ($search) {
                      $qCustomer->where('fullname', 'LIKE', "%{$search}%")
                                ->orWhere('phone', 'LIKE', "%{$search}%")
                                ->orWhere('email', 'LIKE', "%{$search}%");
                  });
            });
        }

        // Global Statistics
        $totalOrders = Order::count();
        $totalRevenue = Order::where('status_id', 4)->sum('total_amount'); // 4 = Completed (Đã hoàn thành)

        $orders = $query->paginate(20)->withQueryString();

        return view('admin.orders.index', compact('orders', 'totalOrders', 'totalRevenue'));
    }

    public function show($id)
    {
        $order = Order::with(['customer', 'items.product', 'statusRelation'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status_id' => 'required|integer|exists:order_statuses,id',
            'payment_status' => 'required|string|in:' . implode(',', array_keys(Order::getPaymentStatusesList())),
        ], [
            'status_id.required' => 'Vui lòng chọn trạng thái đơn hàng.',
            'status_id.exists' => 'Trạng thái đơn hàng không hợp lệ.',
            'payment_status.required' => 'Vui lòng chọn trạng thái thanh toán.',
            'payment_status.in' => 'Trạng thái thanh toán không hợp lệ.',
        ]);

        $order = Order::findOrFail($id);
        $order->status_id = $request->status_id;
        $order->payment_status = $request->payment_status;
        $order->save();

        return redirect()->back()->with('success', 'Cập nhật trạng thái đơn hàng thành công.');
    }
}
