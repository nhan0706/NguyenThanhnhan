<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CartController extends Controller
{
    public function show()
    {
        return view('client.cart.show');
    }

    public function addToCart(Request $request, $id)
    {
        $product = Product::select('id', 'productname', 'slug', 'price', 'pricediscount', 'image')->findOrFail($id);

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                'productid' => $product->id,
                'productname' => $product->productname,
                'slug' => $product->slug,
                'image' => $product->image,
                'price' => $product->pricediscount ?: $product->price,
                'quantity' => 1,
            ];
        }

        session()->put('cart', $cart);

        return response()->json([
            'status' => true,
            'message' => 'Đã thêm sản phẩm vào giỏ hàng.',
            'cartCount' => collect($cart)->sum('quantity'),
        ]);
    }

    public function removeCart($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
        }

        if (empty($cart)) {
            session()->forget('cart');
        } else {
            session()->put('cart', $cart);
        }

        $total = collect($cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        return response()->json([
            'status' => true,
            'message' => 'Đã xóa sản phẩm.',
            'cartCount' => collect($cart)->sum('quantity'),
            'total' => $total,
            'isEmpty' => empty($cart),
        ]);
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'fullname' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:500',
            'note' => 'nullable|string|max:400',
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->back()->with('error', 'Giỏ hàng trống.');
        }

        DB::beginTransaction();

        try {
            $customer = Customer::where('phone', $request->phone)->first();
            $customerid = null;

            if (empty($customer)) {
                $cus_afterinsert = Customer::create([
                    'fullname' => $request->fullname,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'email' => $request->email,
                ]);
                $customerid = $cus_afterinsert->id;
            } else {
                $customerid = $customer->id;
            }

            $totalAmount = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

            $order = Order::create([
                'order_code' => 'DH' . time(),
                'customer_id' => $customerid,
                'total_amount' => $totalAmount,
                'status_id' => 1,
                'note' => $request->note,
            ]);

            $orderItems = [];
            foreach ($cart as $item) {
                $orderItems[] = [
                    'order_id' => $order->id,
                    'product_id' => $item['productid'],
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            OrderItem::insert($orderItems);

            DB::commit();
            session()->forget('cart');

            return back()->with('success', 'Đặt hàng thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
}
