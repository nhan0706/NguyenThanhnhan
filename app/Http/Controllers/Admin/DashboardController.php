<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalBrands = Brand::count();
        $totalOrders = Order::count();
        $totalRevenue = Order::where('status_id', 4)->sum('total_amount'); // 4 = Completed (Đã hoàn thành)

        $latestProducts = Product::with(['category', 'brand'])->orderBy('created_at', 'desc')->take(5)->get();
        $latestOrders = Order::with(['customer', 'statusRelation'])->orderBy('created_at', 'desc')->take(5)->get();

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalCategories',
            'totalBrands',
            'totalOrders',
            'totalRevenue',
            'latestProducts',
            'latestOrders'
        ));
    }
}
