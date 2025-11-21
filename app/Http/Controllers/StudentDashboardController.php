<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Exam;
use App\Models\ExamStudent;
use App\Models\ExamAnswer;
use Carbon\Carbon;

class StudentDashboardController extends Controller
{
    public function index()
    {
        // Kiểm tra quyền student
        if (!Auth::user()->isStudent()) {
            abort(403, 'Không có quyền truy cập.');
        }

        $user = Auth::user();

        // Lấy các đợt thi mà sinh viên được tham gia
        $allExams = Exam::whereHas('examStudents', function($query) use ($user) {
            $query->where('student_id', $user->id);
        })
        ->with(['examStudents' => function($query) use ($user) {
            $query->where('student_id', $user->id);
        }])
        ->orderBy('start_time', 'desc')
        ->get();

        // Lấy các đợt thi sắp diễn ra
        $upcomingExams = $allExams->where('start_time', '>', now())
                                 ->sortBy('start_time')
                                 ->take(5);

        // Lấy lịch thi hôm nay
        $todayExams = $allExams->filter(function($exam) {
            return $exam->start_time->format('Y-m-d') === now()->format('Y-m-d');
        })->sortBy('start_time');

        // Thống kê
        $examStats = [
            'total_exams' => $allExams->count(),
            'completed_exams' => $allExams->filter(function($exam) {
                return $exam->examStudents->first() && $exam->examStudents->first()->status === 'submitted';
            })->count(),
            'upcoming_exams' => $upcomingExams->count(),
            'average_score' => ExamAnswer::where('student_id', $user->id)
                                        ->whereNotNull('score')
                                        ->avg('score') ?? 0
        ];

        return view('student.dashboard', compact('user', 'allExams', 'upcomingExams', 'todayExams', 'examStats'));
    }

    public function profile()
    {
        // Kiểm tra quyền student
        if (!Auth::user()->isStudent()) {
            abort(403, 'Không có quyền truy cập.');
        }

        $user = Auth::user();
        return view('student.profile', compact('user'));
    }

    public function exams()
    {
        // Kiểm tra quyền student
        if (!Auth::user()->isStudent()) {
            abort(403, 'Không có quyền truy cập.');
        }

        $user = Auth::user();

        // Lấy các đợt thi mà sinh viên được tham gia
        $exams = Exam::whereHas('examStudents', function($query) use ($user) {
            $query->where('student_id', $user->id);
        })
        ->with(['examQuestions' => function($query) {
            $query->orderBy('order_number')->with('question');
        }, 'examStudents' => function($query) use ($user) {
            $query->where('student_id', $user->id);
        }])
        ->orderBy('start_time', 'desc')
        ->get();

        return view('student.exams', compact('user', 'exams'));
    }

    public function startExam(Exam $exam)
    {
        // Kiểm tra quyền student
        if (!Auth::user()->isStudent()) {
            abort(403, 'Không có quyền truy cập.');
        }

        $user = Auth::user();

        // Kiểm tra sinh viên có được tham gia đợt thi này không
        $examStudent = ExamStudent::where('exam_id', $exam->id)
            ->where('student_id', $user->id)
            ->first();

        if (!$examStudent) {
            return redirect()->route('student.exams')
                ->with('error', 'Bạn không được phép tham gia đợt thi này.');
        }

        // Kiểm tra đã nộp bài chưa
        if ($examStudent->status === 'submitted') {
            return redirect()->route('student.exam.result', $exam)
                ->with('info', 'Bạn đã nộp bài. Xem kết quả thi.');
        }

        // Kiểm tra thời gian thi
        $now = Carbon::now();
        if ($now < $exam->start_time) {
            return redirect()->route('student.exams')
                ->with('error', 'Đợt thi chưa bắt đầu.');
        }

        if ($now > $exam->end_time) {
            return redirect()->route('student.exams')
                ->with('error', 'Đợt thi đã kết thúc.');
        }

        // Cập nhật thời gian bắt đầu nếu chưa có
        if (!$examStudent->started_at) {
            $examStudent->update([
                'started_at' => $now,
                'status' => 'in_progress'
            ]);
        }

        // Tính thời gian kết thúc dựa trên thời gian bắt đầu + duration
        $endTime = $examStudent->started_at->addMinutes($exam->duration_minutes);

        // Không được vượt quá thời gian kết thúc của đợt thi
        if ($endTime > $exam->end_time) {
            $endTime = $exam->end_time;
        }

        // Load câu hỏi theo thứ tự
        $exam->load(['examQuestions' => function($query) {
            $query->orderBy('order_number')->with('question');
        }]);

        // Load existing answers (nếu sinh viên đã trả lời một số câu)
        $existingAnswers = ExamAnswer::where('exam_id', $exam->id)
            ->where('student_id', $user->id)
            ->pluck('answer', 'question_id')
            ->toArray();

        return view('student.taking-exam', compact('exam', 'examStudent', 'endTime', 'existingAnswers'));
    }

    public function submitExam(Request $request, Exam $exam)
    {
        // Kiểm tra quyền student
        if (!Auth::user()->isStudent()) {
            abort(403, 'Không có quyền truy cập.');
        }

        $user = Auth::user();

        // Kiểm tra sinh viên có được tham gia đợt thi này không
        $examStudent = ExamStudent::where('exam_id', $exam->id)
            ->where('student_id', $user->id)
            ->first();

        if (!$examStudent) {
            return redirect()->route('student.exams')
                ->with('error', 'Bạn không được phép tham gia đợt thi này.');
        }

        // Kiểm tra đã nộp bài chưa
        if ($examStudent->status === 'submitted') {
            return redirect()->route('student.exam.result', $exam)
                ->with('info', 'Bạn đã nộp bài trước đó.');
        }

        // Validate answers
        $request->validate([
            'answers' => 'required|array',
            'answers.*' => 'required|string',
        ]);

        DB::transaction(function () use ($request, $exam, $examStudent) {
            // Lưu câu trả lời vào database
            foreach ($request->answers as $questionId => $answer) {
                ExamAnswer::updateOrCreate(
                    [
                        'exam_id' => $exam->id,
                        'student_id' => $examStudent->student_id,
                        'question_id' => $questionId,
                    ],
                    [
                        'answer' => $answer,
                    ]
                );
            }

            // Cập nhật trạng thái đã nộp bài
            $examStudent->update([
                'submitted_at' => Carbon::now(),
                'status' => 'submitted'
            ]);
        });

        return redirect()->route('student.exam.result', $exam)
            ->with('success', 'Bài thi đã được nộp thành công!');
    }

    public function examResult(Exam $exam)
    {
        // Kiểm tra quyền student
        if (!Auth::user()->isStudent()) {
            abort(403, 'Không có quyền truy cập.');
        }

        $user = Auth::user();

        // Kiểm tra sinh viên có được tham gia đợt thi này không
        $examStudent = ExamStudent::where('exam_id', $exam->id)
            ->where('student_id', $user->id)
            ->first();

        if (!$examStudent) {
            return redirect()->route('student.exams')
                ->with('error', 'Bạn không được phép xem đợt thi này.');
        }

        // Kiểm tra đã nộp bài chưa
        if ($examStudent->status !== 'submitted') {
            return redirect()->route('student.exams')
                ->with('error', 'Bạn chưa nộp bài.');
        }

        // Lấy câu trả lời từ database
        $answers = ExamAnswer::where('exam_id', $exam->id)
            ->where('student_id', $user->id)
            ->pluck('answer', 'question_id')
            ->toArray();

        // Load câu hỏi và answers của sinh viên
        $exam->load(['examQuestions' => function($query) {
            $query->orderBy('order_number')->with('question');
        }]);

        // Load exam answers với grades
        $examAnswers = ExamAnswer::where('exam_id', $exam->id)
            ->where('student_id', $user->id)
            ->with('question')
            ->get()
            ->keyBy('question_id');

        return view('student.exam-result', compact('exam', 'examStudent', 'answers', 'examAnswers'));
    }
}
