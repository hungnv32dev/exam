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
        $endTime = $examStudent->started_at->clone()->addMinutes($exam->duration_minutes);

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

        // Validate answers - cho phép câu trả lời rỗng
        $request->validate([
            'answers' => 'sometimes|array',
            'answers.*' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request, $exam, $examStudent) {
            // Lưu câu trả lời vào database (cả câu rỗng)
            $answers = $request->input('answers', []);
            foreach ($answers as $questionId => $answer) {
                ExamAnswer::updateOrCreate(
                    [
                        'exam_id' => $exam->id,
                        'student_id' => $examStudent->student_id,
                        'question_id' => $questionId,
                    ],
                    [
                        'answer' => trim($answer ?? ''),
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

    public function autoSave(Exam $exam, Request $request)
    {
        try {
            // Kiểm tra quyền student
            if (!Auth::user()->isStudent()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không có quyền truy cập.'
                ], 403);
            }

            $user = Auth::user();

            // Kiểm tra sinh viên có được tham gia đợt thi này không
            $examStudent = ExamStudent::where('exam_id', $exam->id)
                ->where('student_id', $user->id)
                ->first();

            if (!$examStudent) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bạn không được phép tham gia đợt thi này.'
                ]);
            }

            // Kiểm tra đã nộp bài chưa
            if ($examStudent->status === 'submitted') {
                return response()->json([
                    'success' => false,
                    'message' => 'Bạn đã nộp bài trước đó.'
                ]);
            }

            // Kiểm tra thời gian thi - sử dụng thời gian bắt đầu của sinh viên
            $now = Carbon::now();
            
            // Nếu sinh viên chưa bắt đầu thi, cho phép auto-save
            if (!$examStudent->started_at) {
                // Nhưng phải trong khoảng thời gian thi chung
                if ($now < $exam->start_time || $now > $exam->end_time) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Ngoài thời gian thi.'
                    ]);
                }
            } else {
                // Sinh viên đã bắt đầu - kiểm tra thời gian cá nhân
                $studentEndTime = $examStudent->started_at->clone()->addMinutes((int) $exam->duration_minutes);
                
                // Không được vượt quá thời gian kết thúc chung
                if ($studentEndTime > $exam->end_time) {
                    $studentEndTime = $exam->end_time;
                }
                
                // Cho phép auto-save ngay cả khi hết thời gian (để lưu lần cuối)
                // if ($now > $studentEndTime) {
                //     return response()->json([
                //         'success' => false,
                //         'message' => 'Đã hết thời gian làm bài.'
                //     ]);
                // }
            }

            // Debug: Log tất cả request data
            \Log::info('AutoSave Request Debug', [
                'all_request_data' => $request->all(),
                'request_keys' => array_keys($request->all()),
                'request_count' => count($request->all()),
                'has_answers_key' => $request->has('answers'),
                'answers_data' => $request->input('answers', []),
                'raw_input' => $request->getContent()
            ]);

            // Lưu câu trả lời - XỬ LÝ CẢ 2 FORMAT
            $savedAnswers = 0;
            $answersData = [];
            
            // Format 1: answers[123] keys (nếu có)
            foreach ($request->all() as $key => $value) {
                \Log::info('Processing key', ['key' => $key, 'value' => $value]);
                
                if (strpos($key, 'answers[') === 0) {
                    // Extract question ID from answers[123] format
                    preg_match('/answers\[(\d+)\]/', $key, $matches);
                    if (isset($matches[1])) {
                        $questionId = $matches[1];
                        $answerText = trim($value ?? '');
                        
                        \Log::info('Saving answer (format 1)', [
                            'question_id' => $questionId,
                            'answer' => $answerText,
                            'exam_id' => $exam->id,
                            'student_id' => $user->id
                        ]);
                        
                        $examAnswer = ExamAnswer::updateOrCreate(
                            [
                                'exam_id' => $exam->id,
                                'student_id' => $user->id,
                                'question_id' => $questionId,
                            ],
                            [
                                'answer' => $answerText,
                                'updated_at' => $now,
                            ]
                        );
                        
                        $answersData[] = [
                            'question_id' => $questionId,
                            'answer_length' => strlen($answerText),
                            'was_updated' => $examAnswer->wasRecentlyCreated ? 'created' : 'updated',
                            'format' => 'answers[x]'
                        ];
                        
                        $savedAnswers++;
                    }
                }
            }
            
            // Format 2: answers nested array (Laravel parsed format)
            if ($request->has('answers') && is_array($request->input('answers'))) {
                foreach ($request->input('answers') as $questionId => $answerText) {
                    $answerText = trim($answerText ?? '');
                    
                    \Log::info('Saving answer (format 2)', [
                        'question_id' => $questionId,
                        'answer' => $answerText,
                        'exam_id' => $exam->id,
                        'student_id' => $user->id
                    ]);
                    
                    $examAnswer = ExamAnswer::updateOrCreate(
                        [
                            'exam_id' => $exam->id,
                            'student_id' => $user->id,
                            'question_id' => $questionId,
                        ],
                        [
                            'answer' => $answerText,
                            'updated_at' => $now,
                        ]
                    );
                    
                    $answersData[] = [
                        'question_id' => $questionId,
                        'answer_length' => strlen($answerText),
                        'was_updated' => $examAnswer->wasRecentlyCreated ? 'created' : 'updated',
                        'format' => 'answers.nested'
                    ];
                    
                    $savedAnswers++;
                }
            }

            // Debug logging
            \Log::info('Auto-save for exam', [
                'exam_id' => $exam->id,
                'student_id' => $user->id,
                'saved_answers_count' => $savedAnswers,
                'answers_data' => $answersData,
                'request_data_count' => count($request->all())
            ]);

            // Cập nhật trạng thái exam_student nếu chưa bắt đầu
            if ($examStudent->status === 'registered') {
                $examStudent->update([
                    'started_at' => $now,
                    'status' => 'in_progress'
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Đã lưu bài làm thành công.',
                'saved_answers' => $savedAnswers,
                'saved_at' => $now->format('H:i:s'),
                'answers_detail' => $answersData,
                'debug_info' => [
                    'exam_id' => $exam->id,
                    'student_id' => $user->id,
                    'exam_student_status' => $examStudent->status,
                    'student_started_at' => $examStudent->started_at?->format('Y-m-d H:i:s'),
                    'now' => $now->format('Y-m-d H:i:s')
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error('Auto-save error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi lưu bài làm: ' . $e->getMessage()
            ], 500);
        }
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
