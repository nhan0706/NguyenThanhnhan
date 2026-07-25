<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PostRequest;
use Illuminate\Support\Facades\DB;
use App\Models\Post;
use App\Models\User;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($limit = 10)
    {
        $list = Post::select('id', 'title', 'image', 'status', 'user_id')
            ->with(['user:id,fullname'])
            ->orderBy('title')
            ->paginate($limit);

        return view('admin.posts.index', compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::select('id', 'fullname')->get();
        return view('admin.posts.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        try {
            $validated = $request->validated();

            Post::create([
                'title'       => $validated['title'],
                'slug'        => $validated['slug'],
                'content'     => $validated['content'],
                'status'      => $validated['status'],
                'user_id'     => $validated['user_id'],
            ]);

            return redirect()
                ->route('admin.post.index')
                ->with('success', 'Thêm bài viết thành công');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
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
        $post = Post::find($id);
        if (!$post) {
            return redirect()
                ->route('admin.post.index')
                ->with('error', 'Bài viết không tồn tại');
        }
        $users = User::select('id', 'fullname')->get();
        return view('admin.posts.edit', compact('post', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, string $id)
    {
        try {
            $post = Post::find($id);

            if (!$post) {
                return redirect()
                    ->route('admin.post.index')
                    ->with('error', 'Bài viết không tồn tại');
            }

            $validated = $request->validated();

            $post->update([
                'title'       => $validated['title'],
                'slug'        => $validated['slug'],
                'content'     => $validated['content'],
                'status'      => $validated['status'],
                'user_id'     => $validated['user_id'],
            ]);

            return redirect()
                ->route('admin.post.index')
                ->with('success', 'Cập nhật bài viết thành công');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
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
