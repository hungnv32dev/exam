<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Exam;
use App\Models\Question;
use App\Models\User;
use App\Models\ExamQuestion;
use App\Models\ExamStudent;
use Carbon\Carbon;

class ExamController extends Controller
{
    public function index(Request $request)
    {
        // Kiểm tra quyền admin
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Không có quyền truy cập.');
        }

        $query = Exam::with(['creator', 'examQuestions', 'examStudents']);

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $exams = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.exams.index', compact('exams'));
    }

    public function create()
    {
        // Kiểm tra quyền admin
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Không có quyền truy cập.');
        }

        $questions = Question::where('status', 'active')->orderBy('title')->get();
        $students = User::where('role', 'student')->orderBy('name')->get();

        return view('admin.exams.create', compact('questions', 'students'));
    }

    public function store(Request $request)
    {
        // Kiểm tra quyền admin
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Không có quyền truy cập.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'duration_minutes' => 'required|integer|min:1|max:600',
            'start_time' => 'required|date|after:now',
            'end_time' => 'required|date|after:start_time',
            'description' => 'nullable|string',
            'status' => 'required|in:draft,active',
            'questions' => 'required|array|min:1',
            'questions.*' => 'exists:questions,id',
            'students' => 'required|array|min:1',
            'students.*' => 'exists:users,id',
        ]);

        // Validate students are actually students
        $studentUsers = User::whereIn('id', $request->students)->where('role', 'student')->pluck('id');
        if ($studentUsers->count() !== count($request->students)) {
            return back()->withErrors(['students' => 'Một số user được chọn không phải là sinh viên.'])->withInput();
        }

        DB::transaction(function () use ($request) {
            // Create exam
            $exam = Exam::create([
                'name' => $request->name,
                'code' => Exam::generateUniqueCode(),
                'duration_minutes' => $request->duration_minutes,
                'start_time' => Carbon::parse($request->start_time),
                'end_time' => Carbon::parse($request->end_time),
                'description' => $request->description,
                'status' => $request->status,
                'created_by' => Auth::id(),
            ]);

            // Add questions with order
            foreach ($request->questions as $index => $questionId) {
                ExamQuestion::create([
                    'exam_id' => $exam->id,
                    'question_id' => $questionId,
                    'order_number' => $index + 1,
                ]);
            }

            // Add students
            foreach ($request->students as $studentId) {
                ExamStudent::create([
                    'exam_id' => $exam->id,
                    'student_id' => $studentId,
                    'registered_at' => now(),
                    'status' => 'registered',
                ]);
            }
        });

        return redirect()->route('admin.exams.index')->with('success', 'Đợt thi đã được tạo thành công!');
    }

    public function show(Exam $exam)
    {
        // Kiểm tra quyền admin
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Không có quyền truy cập.');
        }

        $exam->load([
            'creator',
            'examQuestions' => function($query) {
                $query->orderBy('order_number')->with('question');
            },
            'examStudents.student'
        ]);

        return view('admin.exams.show', compact('exam'));
    }

    public function edit(Exam $exam)
    {
        // Kiểm tra quyền admin
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Không có quyền truy cập.');
        }

        if (!$exam->canBeEdited()) {
            return redirect()->route('admin.exams.index')
                ->with('error', 'Đợt thi này không thể chỉnh sửa.');
        }

        $questions = Question::where('status', 'active')->orderBy('title')->get();
        $students = User::where('role', 'student')->orderBy('name')->get();

        $exam->load([
            'examQuestions' => function($query) {
                $query->orderBy('order_number')->with('question');
            },
            'examStudents.student'
        ]);

        $selectedQuestions = $exam->examQuestions->pluck('question_id')->toArray();
        $selectedStudents = $exam->examStudents->pluck('student_id')->toArray();

        return view('admin.exams.edit', compact('exam', 'questions', 'students', 'selectedQuestions', 'selectedStudents'));
    }

    public function update(Request $request, Exam $exam)
    {
        // Kiểm tra quyền admin
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Không có quyền truy cập.');
        }

        if (!$exam->canBeEdited()) {
            return redirect()->route('admin.exams.index')
                ->with('error', 'Đợt thi này không thể chỉnh sửa.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'duration_minutes' => 'required|integer|min:1|max:600',
            'start_time' => 'required|date|after:now',
            'end_time' => 'required|date|after:start_time',
            'description' => 'nullable|string',
            'status' => 'required|in:draft,active',
            'questions' => 'required|array|min:1',
            'questions.*' => 'exists:questions,id',
            'students' => 'required|array|min:1',
            'students.*' => 'exists:users,id',
        ]);

        // Validate students are actually students
        $studentUsers = User::whereIn('id', $request->students)->where('role', 'student')->pluck('id');
        if ($studentUsers->count() !== count($request->students)) {
            return back()->withErrors(['students' => 'Một số user được chọn không phải là sinh viên.'])->withInput();
        }

        DB::transaction(function () use ($request, $exam) {
            // Update exam
            $exam->update([
                'name' => $request->name,
                'duration_minutes' => $request->duration_minutes,
                'start_time' => Carbon::parse($request->start_time),
                'end_time' => Carbon::parse($request->end_time),
                'description' => $request->description,
                'status' => $request->status,
            ]);

            // Update questions
            $exam->examQuestions()->delete();
            foreach ($request->questions as $index => $questionId) {
                ExamQuestion::create([
                    'exam_id' => $exam->id,
                    'question_id' => $questionId,
                    'order_number' => $index + 1,
                ]);
            }

            // Update students
            $exam->examStudents()->delete();
            foreach ($request->students as $studentId) {
                ExamStudent::create([
                    'exam_id' => $exam->id,
                    'student_id' => $studentId,
                    'registered_at' => now(),
                    'status' => 'registered',
                ]);
            }
        });

        return redirect()->route('admin.exams.index')->with('success', 'Đợt thi đã được cập nhật thành công!');
    }

    public function destroy(Exam $exam)
    {
        // Kiểm tra quyền admin
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Không có quyền truy cập.');
        }

        if (!$exam->canBeDeleted()) {
            return redirect()->route('admin.exams.index')
                ->with('error', 'Không thể xóa đợt thi này.');
        }

        $exam->delete();

        return redirect()->route('admin.exams.index')->with('success', 'Đợt thi đã được xóa thành công!');
    }

    // API endpoint to get questions for AJAX
    public function getQuestions(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        $questions = Question::where('status', 'active')
            ->when($request->search, function($query, $search) {
                return $query->where('title', 'like', "%{$search}%");
            })
            ->orderBy('title')
            ->get(['id', 'title', 'description', 'category']);

        return response()->json($questions);
    }

    // API endpoint to get students for AJAX
    public function getStudents(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        $students = User::where('role', 'student')
            ->when($request->search, function($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->orderBy('name')
            ->get(['id', 'name', 'email']);

        return response()->json($students);
    }
}
