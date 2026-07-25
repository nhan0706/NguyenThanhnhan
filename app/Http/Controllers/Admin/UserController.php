<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($limit=10)
    {
        $list = User::select('id', 'fullname', 'username', 'email', 'phone', 'address', 'role', 'status')
            ->orderBy('fullname')
            ->paginate($limit);

        return view('admin.users.index', compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        try {
            $validated = $request->validated();

            User::create([
                'fullname' => $validated['fullname'],
                'username' => $validated['username'],
                'email'    => $validated['email'],
                'password' => Hash::make($validated['password']),
                'phone'    => $validated['phone'],
                'address'  => $validated['address'],
                'gender'   => $validated['gender'],
                'birthday' => $validated['birthday'],
                'role'     => $validated['role'],
                'status'   => $validated['status'],
            ]);

            return redirect()
                ->route('admin.user.index')
                ->with('success', 'Thêm người dùng thành công');
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
        $user = User::find($id);
        if (!$user) {
            return redirect()
                ->route('admin.user.index')
                ->with('error', 'Người dùng không tồn tại');
        }
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, string $id)
    {
        try {
            $user = User::find($id);

            if (!$user) {
                return redirect()
                    ->route('admin.user.index')
                    ->with('error', 'Người dùng không tồn tại');
            }

            $validated = $request->validated();

            $data = [
                'fullname' => $validated['fullname'],
                'username' => $validated['username'],
                'email'    => $validated['email'],
                'phone'    => $validated['phone'],
                'address'  => $validated['address'],
                'gender'   => $validated['gender'],
                'birthday' => $validated['birthday'],
                'role'     => $validated['role'],
                'status'   => $validated['status'],
            ];

            // Chỉ cập nhật mật khẩu khi có nhập
            if ($request->filled('password')) {
                $data['password'] = Hash::make($validated['password']);
            }

            $user->update($data);

            return redirect()
                ->route('admin.user.index')
                ->with('success', 'Cập nhật người dùng thành công');
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
