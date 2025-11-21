<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Exam;
use App\Models\Question;
use App\Models\User;
use App\Models\ExamQuestion;
use App\Models\ExamStudent;
use Carbon\Carbon;

class ExamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get admin user and questions, students
        $adminUser = User::where('role', 'admin')->first();
        $questions = Question::where('status', 'active')->get();
        $students = User::where('role', 'student')->get();

        if (!$adminUser || $questions->count() === 0 || $students->count() === 0) {
            $this->command->error('Please ensure there are admin users, questions, and students before running this seeder.');
            return;
        }

        $exams = [
            [
                'name' => 'Đợt thi cuối kỳ Lập trình Web',
                'duration_minutes' => 90,
                'start_time' => Carbon::now()->addDays(7)->setHour(9)->setMinute(0),
                'end_time' => Carbon::now()->addDays(7)->setHour(11)->setMinute(0),
                'description' => 'Đợt thi cuối kỳ môn Lập trình Web. Sinh viên cần hoàn thành tất cả câu hỏi trong thời gian quy định.',
                'status' => 'active',
                'created_by' => $adminUser->id,
            ],
            [
                'name' => 'Kiểm tra giữa kỳ Cơ sở dữ liệu',
                'duration_minutes' => 60,
                'start_time' => Carbon::now()->addDays(3)->setHour(14)->setMinute(0),
                'end_time' => Carbon::now()->addDays(3)->setHour(16)->setMinute(0),
                'description' => 'Kiểm tra kiến thức về thiết kế và quản lý cơ sở dữ liệu.',
                'status' => 'active',
                'created_by' => $adminUser->id,
            ],
            [
                'name' => 'Đánh giá thuật toán và cấu trúc dữ liệu',
                'duration_minutes' => 120,
                'start_time' => Carbon::now()->addDays(10)->setHour(8)->setMinute(0),
                'end_time' => Carbon::now()->addDays(10)->setHour(11)->setMinute(0),
                'description' => 'Đánh giá khả năng phân tích và thiết kế thuật toán.',
                'status' => 'draft',
                'created_by' => $adminUser->id,
            ],
        ];

        foreach ($exams as $examData) {
            // Create exam with auto-generated code
            $examData['code'] = Exam::generateUniqueCode();
            $exam = Exam::create($examData);

            // Add 3-4 questions randomly
            $selectedQuestions = $questions->shuffle()->take(rand(3, min(4, $questions->count())));
            foreach ($selectedQuestions as $index => $question) {
                ExamQuestion::create([
                    'exam_id' => $exam->id,
                    'question_id' => $question->id,
                    'order_number' => $index + 1,
                ]);
            }

            // Add random students (60-80% of total students)
            $numStudents = round($students->count() * (rand(60, 80) / 100));
            $selectedStudents = $students->shuffle()->take($numStudents);

            foreach ($selectedStudents as $student) {
                ExamStudent::create([
                    'exam_id' => $exam->id,
                    'student_id' => $student->id,
                    'registered_at' => Carbon::now()->subHours(rand(1, 48)),
                    'status' => 'registered',
                ]);
            }
        }

        $this->command->info('Exam seeder completed successfully!');
        $this->command->info('Created ' . count($exams) . ' exams with questions and students.');
    }
}
