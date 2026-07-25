<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Hiển thị trang đăng nhập
    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }

        return view('client.auth.login');
    }

    // Xử lý đăng nhập khách hàng
    public function postLogin(Request $request)
    {
        $request->validate([
            'login_id' => 'required',
            'password' => 'required',
        ], [
            'login_id.required' => 'Email hoặc Tên đăng nhập không được để trống',
            'password.required' => 'Mật khẩu không được để trống',
        ]);

        $loginInput = $request->input('login_id');
        $fieldType = filter_var($loginInput, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $user = User::where($fieldType, $loginInput)->first();

        if (!$user) {
            return back()->with('error', 'Tài khoản không tồn tại trên hệ thống')->withInput();
        }

        if (isset($user->status) && $user->status == 0) {
            return back()->with('error', 'Tài khoản của bạn đã bị khóa')->withInput();
        }

        if (!Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Mật khẩu không chính xác')->withInput();
        }

        $remember = $request->has('remember');
        Auth::login($user, $remember);
        $request->session()->regenerate();

        return redirect()->route('home')->with('success', 'Đăng nhập thành công! Chào mừng ' . ($user->fullname ?? $user->username));
    }

    // Hiển thị trang đăng ký
    public function register()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }

        return view('client.auth.register');
    }

    // Xử lý đăng ký tài khoản khách hàng mới
    public function postRegister(Request $request)
    {
        $request->validate([
            'fullname' => 'required|string|max:255',
            'username' => 'required|string|max:50|unique:users,username',
            'email'    => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'phone'    => 'nullable|string|max:20',
            'gender'   => 'required|in:0,1,2',
        ], [
            'fullname.required' => 'Họ và tên không được để trống',
            'username.required' => 'Tên đăng nhập không được để trống',
            'username.unique'   => 'Tên đăng nhập đã tồn tại',
            'email.required'    => 'Email không được để trống',
            'email.email'       => 'Email không đúng định dạng',
            'email.unique'      => 'Email đã được đăng ký',
            'password.required' => 'Mật khẩu không được để trống',
            'password.min'      => 'Mật khẩu phải có ít nhất :min ký tự',
            'password.confirmed'=> 'Mật khẩu xác nhận không khớp',
            'gender.required'   => 'Vui lòng chọn giới tính',
            'gender.in'         => 'Giới tính không hợp lệ',
        ]);

        $user = User::create([
            'fullname' => $request->fullname,
            'username' => $request->username,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'phone'    => $request->phone,
            'gender'   => $request->gender,
            'role'     => 3, // Khách hàng
            'status'   => 1, // Kích hoạt
        ]);

        Auth::login($user);

        return redirect()->route('home')->with('success', 'Đăng ký tài khoản thành công!');
    }

    // Đăng xuất
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Đã đăng xuất tài khoản!');
    }
}
