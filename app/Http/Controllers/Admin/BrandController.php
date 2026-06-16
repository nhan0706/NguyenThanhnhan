<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
    public function store(Request $request)
    {
    $brand = Brand::create([
        'brandname'  => $request->brandname,
        'slug'       => $request->slug,
        'status'     => $request->status,
        'sort_order' => $request->sort_order,
        'description'=> $request->description,
    ]);

    return redirect()->route('brand.index');

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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    $brand = Brand::find($id);

    if (!$brand) {
        return redirect()->route('brand.index');
    }

    $brand->update([
        'brandname'   => $request->brandname,
        'slug'        => $request->slug,
        'status'      => $request->status,
        'sort_order'  => $request->sort_order,
        'description' => $request->description,
    ]);

    return redirect()->route('brand.index');
}
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
