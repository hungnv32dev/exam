<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;

class UsersImport implements ToCollection, WithHeadingRow, WithValidation
{
    use Importable;

    public $importResults = [
        'total' => 0,
        'success' => 0,
        'failed' => 0,
        'errors' => []
    ];

    public function collection(Collection $rows)
    {
        $this->importResults['total'] = $rows->count();

        foreach ($rows as $index => $row) {
            try {
                // Kiểm tra email đã tồn tại
                if (User::where('email', $row['email'])->exists()) {
                    $this->importResults['failed']++;
                    $this->importResults['errors'][] = [
                        'row' => $index + 2,
                        'error' => "Email {$row['email']} đã tồn tại"
                    ];
                    continue;
                }

                // Tạo user mới
                User::create([
                    'name' => $row['name'] ?? $row['ho_ten'] ?? 'Unknown',
                    'email' => $row['email'],
                    'password' => Hash::make($row['password'] ?? 'password123'),
                    'role' => $row['role'] ?? 'student',
                    'email_verified_at' => now(),
                ]);

                $this->importResults['success']++;

            } catch (\Exception $e) {
                $this->importResults['failed']++;
                $this->importResults['errors'][] = [
                    'row' => $index + 2,
                    'error' => $e->getMessage()
                ];
            }
        }
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'name' => 'nullable|string|max:255',
            'ho_ten' => 'nullable|string|max:255',
            'role' => 'nullable|in:admin,student',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'email.required' => 'Email là bắt buộc',
            'email.email' => 'Email không đúng định dạng',
            'role.in' => 'Role chỉ được phép: admin, student',
        ];
    }
}
