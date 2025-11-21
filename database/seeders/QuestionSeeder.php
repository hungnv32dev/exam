<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Question;
use App\Models\User;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the first admin user
        $adminUser = User::where('role', 'admin')->first();

        if (!$adminUser) {
            $this->command->error('No admin user found. Please create an admin user first.');
            return;
        }

        $questions = [
            [
                'title' => 'Giải thích về Lập trình Hướng đối tượng',
                'description' => 'Trình bày các khái niệm cơ bản và nguyên lý của lập trình hướng đối tượng',
                'content' => 'Hãy giải thích chi tiết về lập trình hướng đối tượng (OOP) bao gồm:

1. Khái niệm cơ bản về OOP
2. 4 nguyên lý cơ bản: Encapsulation, Inheritance, Polymorphism, Abstraction
3. Ưu điểm và nhược điểm của OOP
4. So sánh với lập trình cấu trúc
5. Cho ví dụ cụ thể bằng ngôn ngữ lập trình mà bạn biết

Yêu cầu: Trả lời chi tiết, có ví dụ minh họa và giải thích rõ ràng từng phần.',
                'youtube_url' => 'https://www.youtube.com/watch?v=pTB0EiLXUC8',
                'category' => 'Lập trình',
                'status' => 'active',
                'created_by' => $adminUser->id,
            ],
            [
                'title' => 'Phân tích thuật toán Sắp xếp',
                'description' => 'So sánh và phân tích các thuật toán sắp xếp phổ biến',
                'content' => 'Hãy phân tích và so sánh các thuật toán sắp xếp sau:

1. Bubble Sort
2. Selection Sort
3. Insertion Sort
4. Merge Sort
5. Quick Sort

Cho mỗi thuật toán, hãy trình bày:
- Cách hoạt động (mô tả bằng lời)
- Độ phức tạp thời gian (best, average, worst case)
- Độ phức tạp không gian
- Ưu điểm và nhược điểm
- Khi nào nên sử dụng thuật toán đó

Kết luận: Đưa ra nhận xét tổng quan về việc lựa chọn thuật toán phù hợp.',
                'youtube_url' => null,
                'category' => 'Thuật toán',
                'status' => 'active',
                'created_by' => $adminUser->id,
            ],
            [
                'title' => 'Database Normalization và Design',
                'description' => 'Thiết kế cơ sở dữ liệu và áp dụng các dạng chuẩn hóa',
                'content' => 'Cho hệ thống quản lý thư viện với các yêu cầu sau:
- Quản lý sách, tác giả, thể loại
- Quản lý độc giả và thẻ thư viện
- Quản lý việc mượn/trả sách
- Lưu trữ lịch sử mượn trả

Nhiệm vụ:
1. Thiết kế ERD (Entity Relationship Diagram) cho hệ thống
2. Chuyển đổi ERD thành các bảng cụ thể
3. Áp dụng chuẩn hóa dữ liệu đến dạng chuẩn 3NF
4. Giải thích tại sao cần chuẩn hóa và lợi ích của việc này
5. Viết một số câu truy vấn SQL mẫu cho hệ thống

Lưu ý: Vẽ sơ đồ rõ ràng và giải thích từng bước thiết kế.',
                'youtube_url' => 'https://www.youtube.com/watch?v=GFQaEYEc8_8',
                'category' => 'Cơ sở dữ liệu',
                'status' => 'active',
                'created_by' => $adminUser->id,
            ],
            [
                'title' => 'Phát triển Web với Laravel Framework',
                'description' => 'Xây dựng ứng dụng web sử dụng Laravel và các pattern phổ biến',
                'content' => 'Bạn được yêu cầu xây dựng một ứng dụng blog đơn giản với Laravel. Hãy trình bày:

1. Kiến trúc MVC trong Laravel:
   - Giải thích vai trò của Model, View, Controller
   - Cách Laravel implement pattern này

2. Thiết kế database cho blog:
   - Bảng posts, categories, users, comments
   - Relationships giữa các bảng
   - Migration files

3. Implement các tính năng:
   - Authentication & Authorization
   - CRUD operations cho posts
   - Comment system
   - File upload cho images

4. Best practices:
   - Validation
   - Error handling
   - Security considerations
   - Performance optimization

Yêu cầu: Giải thích code và lý do lựa chọn từng approach.',
                'youtube_url' => null,
                'category' => 'Web Development',
                'status' => 'active',
                'created_by' => $adminUser->id,
            ],
            [
                'title' => 'Phân tích tình huống: Tối ưu hóa hiệu suất hệ thống',
                'description' => 'Giải quyết vấn đề hiệu suất trong ứng dụng thực tế',
                'content' => 'Tình huống: Bạn là developer của một ứng dụng e-commerce đang gặp vấn đề:

Vấn đề:
- Website tải chậm khi có nhiều người dùng truy cập đồng thời
- Database queries mất nhiều thời gian
- Trang product listing load > 5 giây
- Server CPU usage cao (>80%)
- Memory usage tăng liên tục

Yêu cầu phân tích và đề xuất giải pháp:

1. Database Optimization:
   - Phân tích và tối ưu queries
   - Indexing strategy
   - Database connection pooling

2. Application Level:
   - Caching strategies (Redis, Memcached)
   - Code optimization
   - Memory management

3. Infrastructure:
   - Load balancing
   - CDN implementation
   - Horizontal/Vertical scaling

4. Monitoring:
   - Tools để monitor performance
   - Key metrics cần theo dõi

Đưa ra roadmap cụ thể với priority và timeline thực hiện.',
                'youtube_url' => 'https://www.youtube.com/watch?v=zwG5Kqs3Dws',
                'category' => 'Performance',
                'status' => 'active',
                'created_by' => $adminUser->id,
            ],
        ];

        foreach ($questions as $questionData) {
            Question::create($questionData);
        }

        $this->command->info('Question seeder completed successfully!');
    }
}
