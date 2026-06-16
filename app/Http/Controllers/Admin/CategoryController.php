<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Category;

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
       Category::create([ 
            'catename'   => $request->catename,
            'slug'       => $request->slug,
            'status'     => $request->status,
            'sort_order' => $request->sort_order,
            'description'=> $request->description,
        ]); 

        return redirect()->route('category.index');
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
        $category = DB::table('categories')->where('cateid', $id)->first();
        if (!$category) {
            return redirect()->route('category.index');
        }
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, string $id)
{
    $category = Category::find($id);

    if (!$category) {
        return redirect()->route('category.index');
    }

    $category->update([
        'catename'   => $request->catename,
        'slug'       => $request->slug,
        'status'     => $request->status,
        'sort_order' => $request->sort_order,
        'description'=> $request->description,
    ]);

    return redirect()->route('category.index');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::table('categories')->where('cateid', $id)->delete();
        return redirect()->route('category.index');
    }
}
