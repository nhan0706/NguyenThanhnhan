<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\ProductImage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     $list = DB::table('products')
    //         ->join('categories', 'products.cateid', '=', 'categories.cateid')
    //         ->leftJoin('brands', 'products.brandid', '=', 'brands.id')
    //         ->select(
    //             'products.id',
    //             'products.productname',
    //             'products.price',
    //             'products.image',
    //             'products.status',
    //             'categories.catename',
    //             'brands.brandname'
    //         )
    //         ->orderBy('products.productname')
    //         ->get();

    //     return view('admin.products.index', compact('list'));
    // }
        public function index($limit = 10)
    {
        $list = Product::with([
            'category:cateid,catename',
            'brand:id,brandname'
        ])
        ->select(
            'id',
            'productname',
            'price',
            'image',
            'status',
            'cateid',
            'brandid'
        )
        ->orderBy('productname')
        ->paginate($limit);

        return view('admin.products.index', compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     */
        public function create()
    {
        $categories = Category::select('cateid', 'catename')->get();
        $brands = Brand::select('id', 'brandname')->get();

        return view('admin.products.create', compact('categories', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
        public function store(ProductRequest $request)
    {
        try {
            // Upload hình ảnh chính
            $fileName = null;
            if ($request->hasFile('img')) {
                $file = $request->file('img');
                $fileName = Str::slug($request->productname) . '-' . time() . '.' . $file->extension();
                $file->storeAs('products', $fileName, 'public');
            }

            // Lưu sản phẩm
            $product = Product::create([
                'productname'   => $request->productname,
                'slug'          => $request->slug,
                'cateid'        => $request->cateid,
                'brandid'       => $request->brandid,
                'price'         => $request->price,
                'pricediscount' => $request->pricediscount ?? 0,
                'description'   => $request->description,
                'status'        => $request->status,
                'image'         => $fileName,
            ]);

            // Upload hình ảnh phụ
            if ($request->hasFile('imgs')) {
                $i = 1;
                $time = time();
                foreach ($request->file('imgs') as $file) {
                    $fileName = $product->id . '_' . $time . '_' . $i . '.' . $file->extension();
                    $file->storeAs('products', $fileName, 'public');
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image' => $fileName,
                    ]);
                    $i++;
                }
            }

            return redirect()
                ->route('admin.product.index')
                ->with('success', 'Thêm sản phẩm thành công');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Thêm thất bại.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $product = Product::with('images')->find($id);
        if (!$product) {
            return redirect()->route('admin.product.index')->with('error', 'Sản phẩm không tồn tại');
        }
        $categories = Category::select('cateid', 'catename')->get();
        $brands = Brand::select('id', 'brandname')->get();

        return view('admin.products.edit', compact('product', 'categories', 'brands'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, string $id)
    {
        try {
            $product = Product::find($id);

            if (!$product) {
                return redirect()
                    ->route('admin.product.index')
                    ->with('error', 'Sản phẩm không tồn tại');
            }

            $fileName = $product->image;
            if ($request->hasFile('img')) {
                if ($fileName) {
                    Storage::disk('public')->delete('products/' . $fileName);
                }

                $file = $request->file('img');
                $fileName = Str::slug($request->productname) . '-' . time() . '.' . $file->extension();
                $file->storeAs('products', $fileName, 'public');
            }

            $product->update([
                'productname'   => $request->productname,
                'slug'          => $request->slug,
                'cateid'        => $request->cateid,
                'brandid'       => $request->brandid,
                'price'         => $request->price,
                'pricediscount' => $request->pricediscount ?? 0,
                'status'        => $request->status,
                'description'   => $request->description,
                'image'         => $fileName,
            ]);

            if ($request->hasFile('imgs')) {
                $i = 1;
                $time = time();
                foreach ($request->file('imgs') as $file) {
                    $fileName = $product->id . '_' . $time . '_' . $i . '.' . $file->extension();
                    $file->storeAs('products', $fileName, 'public');
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image' => $fileName,
                    ]);
                    $i++;
                }
            }

            return redirect()
                ->route('admin.product.index')
                ->with('success', 'Cập nhật sản phẩm thành công');
                
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Cập nhật thất bại. Vui lòng thử lại.');
        }
    }

    /**
     * Remove the specified resource from storage (Soft Delete).
     */
    public function destroy(string $id)
    {
        try {
            Product::findOrFail($id)->delete();
            return redirect()
                ->route('admin.product.index')
                ->with('success', 'Xóa sản phẩm thành công (đã đưa vào thùng rác).');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Thực hiện thất bại.');
        }
    }

    /**
     * Display list of trashed products.
     */
    public function trash()
    {
        $trashCount = Product::onlyTrashed()->count();
        $list = Product::onlyTrashed()
            ->with([
                'category:cateid,catename',
                'brand:id,brandname'
            ])
            ->orderBy('productname')
            ->paginate(10);

        return view('admin.products.trash', compact('list', 'trashCount'));
    }

    /**
     * Restore a soft-deleted product.
     */
    public function restore($id)
    {
        try {
            Product::onlyTrashed()->findOrFail($id)->restore();
            return redirect()
                ->route('admin.product.trash')
                ->with('success', 'Khôi phục thành công.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Khôi phục thất bại.');
        }
    }

    /**
     * Restore all soft-deleted products.
     */
    public function restoreAll()
    {
        try {
            Product::onlyTrashed()->restore();
            return redirect()
                ->route('admin.product.trash')
                ->with('success', 'Khôi phục tất cả thành công.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Khôi phục tất cả thất bại.');
        }
    }

    /**
     * Permanently delete the specified product.
     */
    public function forceDelete($id)
    {
        try {
            $product = Product::onlyTrashed()->findOrFail($id);
            
            // Delete main image from storage
            if ($product->image) {
                Storage::disk('public')->delete('products/' . $product->image);
            }
            
            // Delete sub images from storage and DB
            foreach ($product->images as $image) {
                Storage::disk('public')->delete('products/' . $image->image);
                $image->delete();
            }

            $product->forceDelete();
            return redirect()
                ->route('admin.product.trash')
                ->with('success', 'Xóa vĩnh viễn thành công.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Xóa thất bại.');
        }
    }

    /**
     * Permanently delete all soft-deleted products.
     */
    public function forceDeleteAll()
    {
        try {
            $products = Product::onlyTrashed()->get();
            foreach ($products as $product) {
                if ($product->image) {
                    Storage::disk('public')->delete('products/' . $product->image);
                }
                foreach ($product->images as $image) {
                    Storage::disk('public')->delete('products/' . $image->image);
                    $image->delete();
                }
                $product->forceDelete();
            }
            return redirect()
                ->route('admin.product.trash')
                ->with('success', 'Xóa vĩnh viễn tất cả thành công.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Xóa vĩnh viễn tất cả thất bại.');
        }
    }

    public function test1()
    {
        return redirect()->route('admin.dashboard');
    }

    public function test2()
    {
        return redirect('/admin/dashboard');
    }
}
