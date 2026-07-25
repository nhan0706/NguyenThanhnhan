<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BrandRequest;
use App\Models\Brand;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index($limit = 10)
{
    // QUERY BUILDER
    // $list = DB::table('brands')
    //     ->select('id', 'brandname', 'slug', 'image', 'status')
    //     ->where('status', 1)
    //     ->orderBy('brandname')
    //     ->get();

    // ORM ELOQUENT
    $list = Brand::select('id', 'brandname', 'slug', 'image', 'status')
        ->orderBy('brandname')
        ->paginate($limit);

    return view('admin.brands.index', compact('list'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.brands.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BrandRequest $request)
    {
        try {
            $validated = $request->validated();
            $fileName = null;
            if ($request->hasFile('img')) {
                $file = $request->file('img');
                $fileName = Str::slug($request->brandname) . '-' . time() . '.' . $file->extension();
                $file->storeAs('brands', $fileName, 'public');
            }

            Brand::create([
                'brandname'  => $validated['brandname'],
                'slug'       => $validated['slug'],
                'image'      => $fileName,
                'status'     => $validated['status'],
                'sort_order' => $validated['sort_order'],
                'description'=> $request->description,
            ]);

         return redirect()
            ->route('admin.brand.index')
            ->with('success', 'Thêm thành công.');
    } catch (\Exception $e) {

        return redirect()
            ->back()
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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $brand = Brand::find($id);
        if (!$brand) {
            return redirect()
                ->route('admin.brand.index')
                ->with('error', 'Thương hiệu không tồn tại');
        }
        return view('admin.brands.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BrandRequest $request, string $id)
{
    try {
        // 1. Tìm brand theo id và kiểm tra tồn tại
        $brand = Brand::find($id);

        if (!$brand) {
            return redirect()
                ->route('admin.brand.index')
                ->with('error', 'Thương hiệu không tồn tại');
        }

        // 2. Lấy dữ liệu đã được validate từ BrandRequest
        $validated = $request->validated();

        // 3. Xử lý hình ảnh (Giữ tên cũ hoặc upload mới)
        $fileName = $brand->image;
        if ($request->hasFile('img')) {
            // Xóa hình ảnh cũ nếu có
            if ($fileName) {
                Storage::disk('public')->delete('brands/' . $fileName);
            }
            
            // Upload hình ảnh mới
            $file = $request->file('img');
            // Sử dụng $validated['brandname'] để đảm bảo an toàn dữ liệu
            $fileName = Str::slug($validated['brandname']) . '-' . time() . '.' . $file->extension();
            $file->storeAs('brands', $fileName, 'public');
        }

        // 4. Cập nhật dữ liệu vào Database
        $brand->update([
            'brandname'   => $validated['brandname'],
            'slug'        => $validated['slug'],
            'status'      => $validated['status'],
            'sort_order'  => $validated['sort_order'] ?? 0, // Đề phòng trường hợp sort_order không bắt buộc
            'description' => $validated['description'] ?? $request->description,
            'image'       => $fileName,
        ]);

        return redirect()
            ->route('admin.brand.index')
            ->with('success', 'Cập nhật thành công.');

    } catch (\Exception $e) {
        // Ghi log lỗi nếu cần thiết để dễ debug: Log::error($e->getMessage());
        return redirect()
            ->back()
            ->withInput()
            ->with('error', 'Cập nhật thất bại.');
    }
}
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
