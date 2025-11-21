<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Question;

class QuestionController extends Controller
{
    public function index(Request $request)
    {
        // Kiểm tra quyền admin
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Không có quyền truy cập.');
        }

        $query = Question::with('creator');

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter by category
        if ($request->has('category') && $request->category && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        $questions = $query->orderBy('created_at', 'desc')->paginate(10);

        // Get available categories
        $categories = Question::whereNotNull('category')
            ->distinct()
            ->pluck('category')
            ->filter()
            ->sort()
            ->values();

        return view('admin.questions.index', compact('questions', 'categories'));
    }

    public function create()
    {
        // Kiểm tra quyền admin
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Không có quyền truy cập.');
        }

        return view('admin.questions.create');
    }

    public function store(Request $request)
    {
        // Kiểm tra quyền admin
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Không có quyền truy cập.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'content' => 'required|string',
            'youtube_url' => 'nullable|url',
            'category' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        // Validate YouTube URL if provided
        if ($request->youtube_url) {
            $pattern = '/(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/';
            if (!preg_match($pattern, $request->youtube_url)) {
                return back()->withErrors(['youtube_url' => 'URL YouTube không hợp lệ.'])->withInput();
            }
        }

        Question::create([
            'title' => $request->title,
            'description' => $request->description,
            'content' => $request->content,
            'youtube_url' => $request->youtube_url,
            'category' => $request->category,
            'status' => $request->status,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('admin.questions.index')->with('success', 'Câu hỏi đã được tạo thành công!');
    }

    public function show(Question $question)
    {
        // Kiểm tra quyền admin
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Không có quyền truy cập.');
        }

        $question->load('creator');
        return view('admin.questions.show', compact('question'));
    }

    public function edit(Question $question)
    {
        // Kiểm tra quyền admin
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Không có quyền truy cập.');
        }

        return view('admin.questions.edit', compact('question'));
    }

    public function update(Request $request, Question $question)
    {
        // Kiểm tra quyền admin
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Không có quyền truy cập.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'content' => 'required|string',
            'youtube_url' => 'nullable|url',
            'category' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        // Validate YouTube URL if provided
        if ($request->youtube_url) {
            $pattern = '/(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/';
            if (!preg_match($pattern, $request->youtube_url)) {
                return back()->withErrors(['youtube_url' => 'URL YouTube không hợp lệ.'])->withInput();
            }
        }

        $question->update([
            'title' => $request->title,
            'description' => $request->description,
            'content' => $request->content,
            'youtube_url' => $request->youtube_url,
            'category' => $request->category,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.questions.index')->with('success', 'Câu hỏi đã được cập nhật thành công!');
    }

    public function destroy(Question $question)
    {
        // Kiểm tra quyền admin
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Không có quyền truy cập.');
        }

        $question->delete();

        return redirect()->route('admin.questions.index')->with('success', 'Câu hỏi đã được xóa thành công!');
    }
}
