<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $limit = 10)
    {
        $query = Customer::orderBy('fullname');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('fullname', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('phone', 'LIKE', "%{$search}%")
                  ->orWhere('address', 'LIKE', "%{$search}%");
            });
        }

        $list = $query->paginate($limit)->withQueryString();

        return view('admin.customers.index', compact('list'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $customer = Customer::with(['orders.statusRelation'])->findOrFail($id);
        return view('admin.customers.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $customer = Customer::findOrFail($id);
        return view('admin.customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $customer = Customer::findOrFail($id);

        $request->validate([
            'fullname' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:customers,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ], [
            'fullname.required' => 'Họ tên không được để trống.',
            'email.email' => 'Email không đúng định dạng.',
            'email.unique' => 'Email đã tồn tại.',
        ]);

        try {
            $customer->update($request->only('fullname', 'email', 'phone', 'address'));
            return redirect()
                ->route('admin.customer.index')
                ->with('success', 'Cập nhật thông tin khách hàng thành công.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $customer = Customer::findOrFail($id);

        // Check if customer has orders
        if ($customer->orders()->count() > 0) {
            return redirect()
                ->route('admin.customer.index')
                ->with('error', 'Không thể xóa khách hàng này vì đã phát sinh đơn hàng.');
        }

        try {
            $customer->delete();
            return redirect()
                ->route('admin.customer.index')
                ->with('success', 'Xóa khách hàng thành công.');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.customer.index')
                ->with('error', $e->getMessage());
        }
    }
}
