<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Tạo user admin để đăng nhập
        User::factory()->create([
            'name' => 'Administrator',
            'email' => 'hungnv3@fpt.edu.vn',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // Tạo user admin thứ 2
        // User::factory()->create([
        //     'name' => 'Admin User',
        //     'email' => 'admin2@example.com',
        //     'password' => bcrypt('admin123'),
        //     'role' => 'admin',
        // ]);

        // Tạo user sinh viên
        User::factory()->create([
            'name' => 'Nguyễn Việt Hùng',
            'email' => 'hungnvbg@gmail.com',
            'password' => bcrypt('student123'),
            'role' => 'student',
        ]);

        // Tạo user sinh viên thứ 2
        // User::factory()->create([
        //     'name' => 'Trần Thị B',
        //     'email' => 'student2@example.com',
        //     'password' => bcrypt('student123'),
        //     'role' => 'student',
        // ]);

        // // Tạo user test (sinh viên)
        // User::factory()->create([
        //     'name' => 'Test Student',
        //     'email' => 'test@example.com',
        //     'password' => bcrypt('test123'),
        //     'role' => 'student',
        // ]);

        // Chạy các seeder
        $this->call([
            StudentSeeder::class,
            // QuestionSeeder::class,
            // ExamSeeder::class,
        ]);
    }
}
