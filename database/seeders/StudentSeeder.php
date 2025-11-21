<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Danh sách họ và tên Việt Nam
        $lastNames = [
            'Nguyễn', 'Trần', 'Lê', 'Phạm', 'Hoàng', 'Huỳnh', 'Phan', 'Vũ', 'Võ', 'Đặng',
            'Bùi', 'Đỗ', 'Hồ', 'Ngô', 'Dương', 'Lý', 'Mai', 'Đinh', 'Tô', 'Lưu'
        ];

        $firstNames = [
            'Anh', 'Bảo', 'Chi', 'Dung', 'Đức', 'Giang', 'Hà', 'Hải', 'Hằng', 'Hiền',
            'Hoa', 'Hùng', 'Hương', 'Khang', 'Khánh', 'Lan', 'Long', 'Mai', 'Minh', 'Nam',
            'Ngọc', 'Nhung', 'Phong', 'Phúc', 'Quang', 'Quỳnh', 'Sơn', 'Tâm', 'Thảo', 'Thắng',
            'Thu', 'Thủy', 'Tiên', 'Tuấn', 'Tú', 'Uyên', 'Văn', 'Việt', 'Xuân', 'Yến'
        ];

        $middleNames = [
            'Văn', 'Thị', 'Đức', 'Minh', 'Hoàng', 'Thanh', 'Kim', 'Xuân', 'Thu', 'Hải',
            'Quốc', 'Bảo', 'Ngọc', 'Phương', 'Gia', 'An', 'Tuấn', 'Công', 'Duy', 'Hồng'
        ];

        // Tạo 100 sinh viên
        for ($i = 1; $i <= 100; $i++) {
            // Random tên
            $lastName = $lastNames[array_rand($lastNames)];
            $middleName = rand(0, 1) ? $middleNames[array_rand($middleNames)] : '';
            $firstName = $firstNames[array_rand($firstNames)];
            
            $fullName = trim($lastName . ' ' . $middleName . ' ' . $firstName);
            
            // Tạo email từ tên (không dấu)
            $emailName = $this->removeVietnameseAccents(strtolower($firstName . $middleName . $lastName));
            $email = $emailName . $i . '@student.example.com';
            
            User::create([
                'name' => $fullName,
                'email' => $email,
                'password' => Hash::make('password123'), // Password mặc định
                'role' => 'student',
                'email_verified_at' => now(),
                'created_at' => now()->subDays(rand(1, 30)), // Tạo trong 30 ngày gần đây
                'updated_at' => now(),
            ]);
        }

        $this->command->info('Đã tạo thành công 100 sinh viên!');
    }

    /**
     * Remove Vietnamese accents from string
     */
    private function removeVietnameseAccents($str) {
        $accents = [
            'à', 'á', 'ạ', 'ả', 'ã', 'â', 'ầ', 'ấ', 'ậ', 'ẩ', 'ẫ', 'ă', 'ằ', 'ắ', 'ặ', 'ẳ', 'ẵ',
            'è', 'é', 'ẹ', 'ẻ', 'ẽ', 'ê', 'ề', 'ế', 'ệ', 'ể', 'ễ',
            'ì', 'í', 'ị', 'ỉ', 'ĩ',
            'ò', 'ó', 'ọ', 'ỏ', 'õ', 'ô', 'ồ', 'ố', 'ộ', 'ổ', 'ỗ', 'ơ', 'ờ', 'ớ', 'ợ', 'ở', 'ỡ',
            'ù', 'ú', 'ụ', 'ủ', 'ũ', 'ư', 'ừ', 'ứ', 'ự', 'ử', 'ữ',
            'ỳ', 'ý', 'ỵ', 'ỷ', 'ỹ',
            'đ'
        ];
        
        $replacements = [
            'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a',
            'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e',
            'i', 'i', 'i', 'i', 'i',
            'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o',
            'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u',
            'y', 'y', 'y', 'y', 'y',
            'd'
        ];
        
        return str_replace($accents, $replacements, $str);
    }
}
