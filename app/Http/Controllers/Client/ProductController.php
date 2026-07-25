<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show($slug)
    {
        $product = Product::select(
            'id',
            'cateid',
            'brandid',
            'productname',
            'slug',
            'price',
            'pricediscount',
            'image',
            'description'
        )
        ->with([
            'category:cateid,catename',
            'brand:id,brandname',
            'images:id,product_id,image'
        ])
        ->where('slug', $slug)
        ->firstOrFail();

        $relatedProducts = Product::select(
            'id',
            'productname',
            'slug',
            'price',
            'pricediscount',
            'image',
            'cateid'
        )
        ->where('cateid', $product->cateid)
        ->where('id', '<>', $product->id)
        ->take(4)
        ->get();

        return view('client.products.show', compact(
            'product',
            'relatedProducts'
        ));
    }

    public function category($slug, $limit = 12)
    {
        $products = Product::select(
            'products.id',
            'products.productname',
            'products.slug',
            'products.price',
            'products.pricediscount',
            'products.image',
            'categories.catename'
        )
        ->join('categories', 'products.cateid', 'categories.cateid')
        ->where('categories.slug', $slug)
        ->where('products.status', 1)
        ->paginate($limit);

        return view('client.products.category', compact('products'));
    }

    public function brand($slug, $limit = 12)
    {
        $products = Product::select(
            'products.id',
            'products.productname',
            'products.slug',
            'products.price',
            'products.pricediscount',
            'products.image',
            'brands.brandname'
        )
        ->join('brands', 'products.brandid', 'brands.id')
        ->where('brands.slug', $slug)
        ->where('products.status', 1)
        ->paginate($limit);

        return view('client.products.brand', compact('products'));
    }

    public function search(Request $request, $limit = 12)
    {
        $keyword = trim($request->input('keyword'));
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');
        $sortBy = $request->input('sort_by', 'productname');
        $sortDirection = $request->input('sort_direction', 'asc');

        $products = Product::select(
            'products.id',
            'products.productname',
            'products.slug',
            'products.price',
            'products.pricediscount',
            'products.image',
            'categories.catename'
        )
        ->join('categories', 'products.cateid', 'categories.cateid')
        ->where('products.status', 1);

        if ($keyword !== '') {
            $products->whereRaw('LOWER(products.productname) LIKE ?', ['%' . strtolower($keyword) . '%']);
        }

        if ($minPrice !== null && $minPrice !== '') {
            $products->where('products.price', '>=', (float) $minPrice);
        }

        if ($maxPrice !== null && $maxPrice !== '') {
            $products->where('products.price', '<=', (float) $maxPrice);
        }

        $allowedSorts = ['productname', 'price'];
        $allowedDirections = ['asc', 'desc'];

        if (in_array($sortBy, $allowedSorts, true) && in_array($sortDirection, $allowedDirections, true)) {
            $products->orderBy('products.' . $sortBy, $sortDirection);
        } else {
            $products->orderBy('products.productname', 'asc');
        }

        $products = $products->paginate($limit)->appends($request->only(['keyword', 'min_price', 'max_price', 'sort_by', 'sort_direction']));

        return view('client.products.search', compact('products', 'keyword', 'minPrice', 'maxPrice', 'sortBy', 'sortDirection'));
    }
}
