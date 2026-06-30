<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BrandRequest;
use App\Models\Brand;
use Illuminate\Support\Facades\DB;

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

            Brand::create([
                'brandname'  => $validated['brandname'],
                'slug'       => $validated['slug'],
                'status'     => $validated['status'],
                'sort_order' => $validated['sort_order'],
                'description'=> $request->description,
            ]);

         return redirect()
            ->route('admin.brands.index')
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
            $brand = Brand::find($id);

            if (!$brand) {
                return redirect()
                    ->route('admin.brand.index')
                    ->with('error', 'Thương hiệu không tồn tại');
            }

            $validated = $request->validated();

            $brand->update([
                'brandname'   => $validated['brandname'],
                'slug'        => $validated['slug'],
                'status'      => $validated['status'],
                'sort_order'  => $validated['sort_order'],
                'description' => $request->description,
            ]);

            return redirect()
                ->route('admin.brands.index')
                ->with('success', 'Cập nhật thành công.');
        } catch (\Exception $e) {
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
