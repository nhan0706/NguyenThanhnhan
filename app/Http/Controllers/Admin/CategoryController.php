<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($limit=10)
    {
    //     $list = DB::table('categories')
    //         ->select('cateid', 'catename', 'slug', 'image', 'status')
    //         ->where('status', 1)
    //         ->orderBy('catename')
    //         ->get();

    //     return view('admin.categories.index', compact('list'));
    // }
    //ORM ELOQUENT
    $list = Category::select('cateid','catename','slug','image','status')
        ->orderBy('catename')

        ->paginate($limit);
    return view('admin.categories.index', compact('list'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'catename' => 'required|min:3|max:100|unique:categories,catename',
            'slug' => 'required|min:5|max:150|unique:categories,slug|regex:/^[a-z0-9\-]+$/',
            'sort_order' => 'required|integer|min:0',
            'status' => 'required|in:0,1',
            'img' => 'nullable|image|mimes:jpeg,jpeg,png,webp|max:200',
        ],
        [
            'catename.required' => 'Tên loại sản phẩm không được để trống.',
            'catename.min' => 'Tên loại sản phẩm tối thiểu 3 ký tự.',
            'catename.max' => 'Tên loại sản phẩm không vượt quá 100 ký tự.',
            'catename.unique' => 'Tên loại sản phẩm đã tồn tại.',
            'slug.required' => 'Slug không được để trống.',
            'slug.min' => 'Slug tối thiểu 5 ký tự.',
            'slug.max' => 'Slug không vượt quá 150 ký tự.',
            'slug.unique' => 'Slug đã tồn tại.',
            'slug.regex' => 'Slug chỉ được chứa chữ thường, số và dấu gạch ngang (-).',
            'sort_order.required' => 'Thứ tự sắp xếp không được để trống.',
            'sort_order.integer' => 'Thứ tự sắp xếp phải là số.',
            'sort_order.min' => 'Thứ tự sắp xếp không được âm.',
            'status.required' => 'Trạng thái không được để trống.',
            'status.in' => 'Trạng thái không hợp lệ.',
            'img.image' => ':attribute phải là hình ảnh.',
            'img.mimes' => ':attribute chỉ chấp nhận định dạng: jpg, jpeg, png, webp.',
            'img.max' => ':attribute không được vượt quá 200 KB.',
        ],
        [
            'catename' => 'Tên loại sản phẩm',
            'slug' => 'Slug',
            'sort_order' => 'Thứ tự sắp xếp',
            'status' => 'Trạng thái',
            'img' => 'Hình ảnh',
        ]);

        try {
            $fileName = null;
            if ($request->hasFile('img')) {
                $file = $request->file('img');
                $fileName = Str::slug($request->catename) . '-' . time() . '.' . $file->extension();
                $file->storeAs('categories', $fileName, 'public');
            }

            Category::create([ 
                'catename'   => $validated['catename'],
                'slug'       => $validated['slug'],
                'image'      => $fileName,
                'status'     => $validated['status'],
                'sort_order' => $validated['sort_order'],
                'description'=> $request->description,
            ]);

            return redirect()
                ->route('admin.category.index')
                ->with('success', 'Thêm loại sản phẩm thành công');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Lỗi khi lưu loại sản phẩm. Vui lòng thử lại.');
        }
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
        $category = Category::find($id);
        if (!$category) {
            return redirect()
                ->route('admin.category.index')
                ->with('error', 'Loại sản phẩm không tồn tại');
        }
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $category = Category::find($id);

            if (!$category) {
                return redirect()
                    ->route('admin.category.index')
                    ->with('error', 'Loại sản phẩm không tồn tại');
            }

            // Validation với unique bỏ qua bản ghi hiện tại
            $validated = $request->validate([
                'catename' => 'required|min:3|max:100|unique:categories,catename,' . $id.',cateid',
                'slug' => [
                    'required',
                    'min:5',
                    'max:150',
                    'regex:/^[a-z0-9\-]+$/',
                    Rule::unique('categories', 'slug')->ignore($id, 'cateid'),
                ],
                'sort_order' => 'required|integer|min:0',
                'status' => 'required|in:0,1',
                'img' => 'nullable|image|mimes:jpeg,jpeg,png,webp|max:200',
            ],
            [
                'catename.required' => 'Tên loại sản phẩm không được để trống.',
                'catename.min' => 'Tên loại sản phẩm tối thiểu 3 ký tự.',
                'catename.max' => 'Tên loại sản phẩm không vượt quá 100 ký tự.',
                'catename.unique' => 'Tên loại sản phẩm đã tồn tại.',
                'slug.required' => 'Slug không được để trống.',
                'slug.min' => 'Slug tối thiểu 5 ký tự.',
                'slug.max' => 'Slug không vượt quá 150 ký tự.',
                'slug.unique' => 'Slug đã tồn tại.',
                'slug.regex' => 'Slug chỉ được chứa chữ thường, số và dấu gạch ngang (-).',
                'sort_order.required' => 'Thứ tự sắp xếp không được để trống.',
                'sort_order.integer' => 'Thứ tự sắp xếp phải là số.',
                'sort_order.min' => 'Thứ tự sắp xếp không được âm.',
                'status.required' => 'Trạng thái không được để trống.',
                'status.in' => 'Trạng thái không hợp lệ.',
                'img.image' => ':attribute phải là hình ảnh.',
                'img.mimes' => ':attribute chỉ chấp nhận định dạng: jpg, jpeg, png, webp.',
                'img.max' => ':attribute không được vượt quá 200 KB.',
            ],
            [
                'catename' => 'Tên loại sản phẩm',
                'slug' => 'Slug',
                'sort_order' => 'Thứ tự sắp xếp',
                'status' => 'Trạng thái',
                'img' => 'Hình ảnh',
            ]);

            // handle image: keep existing filename unless new uploaded
            $fileName = $category->image;
            if ($request->hasFile('img')) {
                // delete old file
                if ($fileName) {
                    Storage::disk('public')->delete('categories/' . $fileName);
                }
                $file = $request->file('img');
                $fileName = Str::slug($request->catename) . '-' . time() . '.' . $file->extension();
                $file->storeAs('categories', $fileName, 'public');
            }

            $category->update([
                'catename'   => $validated['catename'],
                'slug'       => $validated['slug'],
                'image'      => $fileName,
                'status'     => $validated['status'],
                'sort_order' => $validated['sort_order'],
                'description'=> $request->description,
            ]);

            return redirect()
                ->route('admin.category.index')
                ->with('success', 'Cập nhật loại sản phẩm thành công');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }
    
    /**
     * Soft delete the specified resource.
     */
    public function destroy(string $id)
    {
        try {
            Category::findOrFail($id)->delete();
            return redirect()
                ->route('admin.category.index')
                ->with('success', 'Xóa thành công.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Thực hiện thất bại.');
        }
    }

    /**
     * Restore a soft-deleted resource.
     */
    public function restore($id)
    {
        try {
            Category::onlyTrashed()->findOrFail($id)->restore();
            return redirect()
                ->route('admin.category.trash')
                ->with('success', 'Khôi phục thành công.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Khôi phục thất bại.');
        }
    }

    /**
     * Restore all soft-deleted resources.
     */
    public function restoreAll()
    {
        try {
            Category::onlyTrashed()->restore();
            return redirect()
                ->route('admin.category.trash')
                ->with('success', 'Khôi phục tất cả thành công.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Khôi phục tất cả thất bại.');
        }
    }

    /**
     * Permanently delete the specified resource.
     */
    public function forceDelete($id)
    {
        try {
            Category::onlyTrashed()->findOrFail($id)->forceDelete();
            return redirect()
                ->route('admin.category.trash')
                ->with('success', 'Xóa vĩnh viễn thành công.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Xóa thất bại.');
        }
    }

    /**
     * Permanently delete all soft-deleted resources.
     */
    public function forceDeleteAll()
    {
        try {
            Category::onlyTrashed()->forceDelete();
            return redirect()
                ->route('admin.category.trash')
                ->with('success', 'Xóa vĩnh viễn tất cả thành công.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Xóa vĩnh viễn tất cả thất bại.');
        }
    }

    /**
     * Display list of trashed categories.
     */
    public function trash()
    {
        $trashCount = Category::onlyTrashed()->count();
        $list = Category::onlyTrashed()->orderBy('catename')->paginate(10);

        return view('admin.categories.trash', compact('list', 'trashCount'));
    }
    
}
