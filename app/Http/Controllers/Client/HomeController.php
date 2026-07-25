<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        // Sản phẩm mới nhất (lấy 8 sản phẩm mới nhất)
        $newProducts = Product::where('status', 1)
            ->select(
                'id',
                'productname',
                'slug',
                'price',
                'pricediscount',
                'image',
                'status'
            )
            ->orderByDesc('created_at')
            ->take(20)
            ->get();

        // Sản phẩm giảm giá (lấy 20 sản phẩm mới nhất)
        $saleProducts = Product::where('status', 1)
            ->select(
                'id',
                'productname',
                'slug',
                'price',
                'pricediscount',
                'image',
                'status'
            )
            ->where('pricediscount', '>', 0)
            ->orderByDesc('created_at')
            ->take(20)
            ->get();

        return view('client.home', compact(
            'newProducts',
            'saleProducts'
        ));
    }
}
