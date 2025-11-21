<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Kiểm tra quyền admin
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Không có quyền truy cập.');
        }

        $user = Auth::user();
        $totalUsers = User::count();
        $totalAdmins = User::where('role', 'admin')->count();
        $totalStudents = User::where('role', 'student')->count();
        $recentUsers = User::orderBy('created_at', 'desc')->limit(5)->get();

        return view('admin.dashboard', compact('user', 'totalUsers', 'totalAdmins', 'totalStudents', 'recentUsers'));
    }

    public function users(Request $request)
    {
        // Kiểm tra quyền admin
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Không có quyền truy cập.');
        }

        $query = User::query();

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by role
        if ($request->has('role') && $request->role && $request->role !== 'all') {
            $query->where('role', $request->role);
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        // Kiểm tra quyền admin
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Không có quyền truy cập.');
        }

        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        // Kiểm tra quyền admin
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Không có quyền truy cập.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:admin,student',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users')->with('success', 'User đã được tạo thành công!');
    }

    public function show(User $user)
    {
        // Kiểm tra quyền admin
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Không có quyền truy cập.');
        }

        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        // Kiểm tra quyền admin
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Không có quyền truy cập.');
        }

        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        // Kiểm tra quyền admin
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Không có quyền truy cập.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:6|confirmed',
            'role' => 'required|in:admin,student',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        // Chỉ cập nhật mật khẩu nếu có nhập
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users')->with('success', 'User đã được cập nhật thành công!');
    }

    public function destroy(User $user)
    {
        // Kiểm tra quyền admin
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Không có quyền truy cập.');
        }

        // Không cho phép xóa chính mình
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.users')->with('error', 'Không thể xóa tài khoản của chính mình!');
        }

        $user->delete();

        return redirect()->route('admin.users')->with('success', 'User đã được xóa thành công!');
    }
}
