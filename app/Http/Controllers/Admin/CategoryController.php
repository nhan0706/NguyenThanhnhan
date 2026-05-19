<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return "Danh sách danh mục";
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return "Thêm danh mục";
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return "Lưu danh mục";
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return "Xem chi tiết danh mục " . $id;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return "Sửa danh mục " . $id;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return "Cập nhật danh mục " . $id;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return "Xóa danh mục " . $id;
    }
}
