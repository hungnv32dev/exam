<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\UsersImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;

class ImportController extends Controller
{
    public function showImportForm()
    {
        // Kiểm tra quyền admin
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Không có quyền truy cập.');
        }

        return view('admin.import.users');
    }

    public function importUsers(Request $request)
    {
        // Kiểm tra quyền admin
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Không có quyền truy cập.');
        }

        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048'
        ], [
            'file.required' => 'Vui lòng chọn file Excel',
            'file.mimes' => 'File phải có định dạng Excel (xlsx, xls) hoặc CSV',
            'file.max' => 'File không được vượt quá 2MB'
        ]);

        try {
            $import = new UsersImport();
            Excel::import($import, $request->file('file'));

            $results = $import->importResults;

            if ($results['failed'] > 0) {
                return redirect()->back()
                    ->with('warning', "Import hoàn tất với {$results['success']} thành công, {$results['failed']} thất bại")
                    ->with('import_errors', $results['errors']);
            }

            return redirect()->back()
                ->with('success', "Import thành công {$results['success']} người dùng!");

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Lỗi import: ' . $e->getMessage());
        }
    }

    public function downloadTemplate()
    {
        // Kiểm tra quyền admin
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Không có quyền truy cập.');
        }

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="template_import_users.csv"'
        ];

        $callback = function() {
            $file = fopen('php://output', 'w');

            // Header
            fputcsv($file, ['name', 'email', 'password', 'role']);

            // Sample data
            fputcsv($file, ['Nguyễn Văn A', 'student1@example.com', 'password123', 'student']);
            fputcsv($file, ['Trần Thị B', 'student2@example.com', 'password123', 'student']);
            fputcsv($file, ['Lê Văn C', 'admin1@example.com', 'password123', 'admin']);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
