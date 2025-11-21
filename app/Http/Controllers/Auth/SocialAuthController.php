<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Tìm user đã tồn tại theo Google ID hoặc email
            $user = User::where('google_id', $googleUser->id)
                      ->orWhere('email', $googleUser->email)
                      ->first();

            if ($user) {
                // Cập nhật Google ID và avatar nếu chưa có
                if (!$user->google_id) {
                    $user->update([
                        'google_id' => $googleUser->id,
                        'avatar' => $googleUser->avatar
                    ]);
                }
            } else {
                // Tạo user mới với Google account
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'avatar' => $googleUser->avatar,
                    'role' => 'student', // Mặc định là student
                    'email_verified_at' => now(),
                ]);
            }

            // Đăng nhập user
            Auth::login($user, true);

            // Redirect dựa trên role
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard')
                    ->with('success', 'Đăng nhập Google thành công!');
            } else {
                return redirect()->route('student.dashboard')
                    ->with('success', 'Đăng nhập Google thành công!');
            }

        } catch (\Exception $e) {
            return redirect()->route('login')
                ->with('error', 'Đăng nhập Google thất bại. Vui lòng thử lại.');
        }
    }
}
