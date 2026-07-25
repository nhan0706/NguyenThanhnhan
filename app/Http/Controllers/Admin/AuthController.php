<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // Hiển thị trang đăng nhập
    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    }

    // Xử lý đăng nhập
    public function postLogin(Request $request)
    {
        // Validate - kiểm tra dữ liệu đầu vào
        $request->validate(
            [
                'username' => 'required',
                'password' => 'required',
            ],
            [
                'required' => ':attribute không được để trống',
            ],
            [
                'username' => 'Tên đăng nhập',
                'password' => 'Mật khẩu',
            ]
        );

        // first(): lấy record đầu tiên theo username
        $user = User::where('username', $request->username)->first();

        // Nếu không tìm thấy người dùng
        if (!$user) {
            return back()
                ->with('error', 'Username không tồn tại')
                ->withInput();
        }

        // Kiểm tra mật khẩu
        $check = Hash::check($request->password, $user->password);

        // Nếu mật khẩu không đúng
        if (!$check) {
            return back()
                ->with('error', 'Mật khẩu không đúng')
                ->withInput();
        }

        // Kiểm tra người dùng có chọn Remember me hay không
        $remember = $request->has('remember');

        // Đăng nhập
        Auth::login($user, $remember);

        // Tạo Session mới để bảo mật
        $request->session()->regenerate();

        // Chuyển đến Dashboard
        return redirect()->intended(route('admin.dashboard'));
    }

    // Đăng xuất
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    // Hiển thị trang đổi mật khẩu
    public function changePassword()
    {
        return view('admin.users.change-password');
    }

    // Xử lý đổi mật khẩu
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ], [
            'current_password.required' => 'Mật khẩu cũ không được để trống',
            'new_password.required' => 'Mật khẩu mới không được để trống',
            'new_password.min' => 'Mật khẩu mới phải có ít nhất :min ký tự',
            'new_password.confirmed' => 'Mật khẩu xác nhận không khớp',
        ]);

        $user = Auth::user();

        if (! Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Mật khẩu cũ không chính xác');
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Đổi mật khẩu thành công');
    }

    // Hiển thị trang Quên mật khẩu
    public function forgotPassword()
    {
        return view('admin.users.forgotpassword');
    }

    // Xử lý Quên mật khẩu
    public function postForgotpassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ], [
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không đúng định dạng',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user) {
            return back()->with('error', 'Email không tồn tại trong hệ thống')->withInput();
        }

        $passrandom = Str::random(10);
        $passencrypted = Hash::make($passrandom);

        $user->update([
            'password' => $passencrypted,
        ]);

        $html = "<h2>Mật khẩu mới của bạn là: $passrandom</h2>\n<p>Vui lòng đổi mật khẩu sau khi đăng nhập.</p>";

        Mail::html($html, function ($message) use ($request) {
            $message->to($request->email)
                ->subject('Đặt lại mật khẩu');
        });

        return back()->with('success', 'Đã gửi mật khẩu mới. Bạn vui lòng kiểm tra email của bạn');
    }
}