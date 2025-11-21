<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class TestController extends Controller
{
    public function testLogin()
    {
        // Test user creation and login
        $users = User::all();

        $testResults = [];

        foreach ($users as $user) {
            // Test if we can verify password
            $testResults[] = [
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'created_at' => $user->created_at->format('Y-m-d H:i:s'),
                'password_test' => 'Ready for login test'
            ];
        }

        return response()->json([
            'total_users' => $users->count(),
            'users' => $testResults,
            'login_info' => [
                'admin_accounts' => [
                    ['email' => 'admin@example.com', 'password' => 'password', 'role' => 'admin'],
                    ['email' => 'admin2@example.com', 'password' => 'admin123', 'role' => 'admin']
                ],
                'student_accounts' => [
                    ['email' => 'student1@example.com', 'password' => 'student123', 'role' => 'student'],
                    ['email' => 'student2@example.com', 'password' => 'student123', 'role' => 'student'],
                    ['email' => 'test@example.com', 'password' => 'test123', 'role' => 'student']
                ]
            ],
            'dashboard_urls' => [
                'admin_dashboard' => url('/admin/dashboard'),
                'student_dashboard' => url('/student/dashboard'),
                'login_page' => url('/login')
            ]
        ]);
    }

    public function testAuth()
    {
        if (Auth::check()) {
            return response()->json([
                'authenticated' => true,
                'user' => Auth::user(),
                'message' => 'User is logged in'
            ]);
        } else {
            return response()->json([
                'authenticated' => false,
                'message' => 'User is not logged in'
            ]);
        }
    }
}
