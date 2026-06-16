<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index($limit=10)
{
    // QUERY BUILDER
    // $list = DB::table('users')
    //     ->select('id', 'fullname', 'username', 'email', 'phone', 'address', 'role', 'status')
    //     ->where('status', 1)
    //     ->orderBy('fullname')
    //     ->get();

    // ORM ELOQUENT
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
        $user = User::create([
        'fullname' => $request->fullname,
        'username' => $request->username,
        'email'    => $request->email,
        'password' => $request->password,
        'phone'    => $request->phone,
        'address'  => $request->address,
        'gender'   => $request->gender,
        'birthday' => $request->birthday,
        'role'     => $request->role,
        'status'   => $request->status,
        ]);

        return redirect()->route('user.index');

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

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id) 
    { 
        $user = User::find($id);
         if (!$user) { return redirect()->route('user.index'); } 
         $data = [ 
            'fullname' => $request->fullname, 
            'username' => $request->username, 
            'email' => $request->email, 
            'phone' => $request->phone, 
            'address' => $request->address, 
            'gender' => $request->gender, 
            'birthday' => $request->birthday, 
            'role' => $request->role, 
            'status' => $request->status, 
        ]; // Chỉ cập nhật mật khẩu khi có nhập 
        if ($request->filled('password')) { 
            $data['password'] = Hash::make($request->password); 
        } 
        $user->update($data); 
        return redirect()->route('user.index'); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
