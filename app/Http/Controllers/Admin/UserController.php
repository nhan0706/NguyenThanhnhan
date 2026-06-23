<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
    public function store(Request $request)
    {
        try {
            User::create([
                'fullname' => $request->fullname,
                'username' => $request->username,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'phone'    => $request->phone,
                'address'  => $request->address,
                'gender'   => $request->gender,
                'birthday' => $request->birthday,
                'role'     => $request->role,
                'status'   => $request->status,
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
    public function update(Request $request, string $id)
    {
        try {
            $user = User::find($id);

            if (!$user) {
                return redirect()
                    ->route('admin.user.index')
                    ->with('error', 'Người dùng không tồn tại');
            }

            $data = [
                'fullname' => $request->fullname,
                'username' => $request->username,
                'email'    => $request->email,
                'phone'    => $request->phone,
                'address'  => $request->address,
                'gender'   => $request->gender,
                'birthday' => $request->birthday,
                'role'     => $request->role,
                'status'   => $request->status,
            ];

            // Chỉ cập nhật mật khẩu khi có nhập
            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
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
