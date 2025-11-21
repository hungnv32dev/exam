@extends('layouts.app')

@section('title', 'Nhân bản Đợt thi')

@section('breadcrumbs')
<li class="breadcrumb-item">
    <span class="bullet bg-gray-400 w-5px h-2px"></span>
</li>
<li class="breadcrumb-item text-muted">
    <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Admin</a>
</li>
<li class="breadcrumb-item text-muted">
    <a href="{{ route('admin.exams.index') }}" class="text-muted text-hover-primary">Quản lý Đợt thi</a>
</li>
<li class="breadcrumb-item text-muted">Nhân bản Đợt thi</li>
@endsection

@section('content')
<!--begin::Alert-->
@if(session('error'))
    <div class="alert alert-danger d-flex align-items-center p-5 mb-10">
        <i class="ki-duotone ki-shield-cross fs-2hx text-danger me-4">
            <span class="path1"></span>
            <span class="path2"></span>
        </i>
        <div class="d-flex flex-column">
            <h4 class="mb-1 text-danger">Lỗi!</h4>
            <span>{{ session('error') }}</span>
        </div>
    </div>
@endif
<!--end::Alert-->

<!--begin::Row-->
<div class="row g-5 g-xl-10">
    <!--begin::Col-->
    <div class="col-xl-12">
        <!--begin::Form-->
        <div class="card card-flush">
            <!--begin::Card header-->
            <div class="card-header pt-7">
                <!--begin::Card title-->
                <div class="card-title">
                    <h2 class="fw-bold">Nhân bản Đợt thi</h2>
                </div>
                <!--end::Card title-->
            </div>
            <!--end::Card header-->

            <!--begin::Card body-->
            <div class="card-body">
                <!--begin::Original Exam Info-->
                <div class="alert alert-info d-flex align-items-center mb-10">
                    <i class="ki-duotone ki-information-4 fs-2 text-info me-3">
                        <span class="path1"></span>
                        <span class="path2"></span>
                        <span class="path3"></span>
                    </i>
                    <div class="flex-grow-1">
                        <h5 class="mb-1">Đang nhân bản từ đợt thi: {{ $exam->name }}</h5>
                        <div class="fw-semibold">
                            <span class="text-gray-600">Mã: {{ $exam->code }}</span> • 
                            <span class="text-gray-600">{{ $exam->examQuestions->count() }} câu hỏi</span> • 
                            <span class="text-gray-600">{{ $exam->examStudents->count() }} sinh viên</span>
                        </div>
                    </div>
                </div>
                <!--end::Original Exam Info-->

                <form method="POST" action="{{ route('admin.exams.clone.store', $exam) }}" id="clone-exam-form">
                    @csrf

                    <!--begin::Basic Information-->
                    <div class="mb-10">
                        <h3 class="fw-bold mb-5">Thông tin cơ bản</h3>
                        
                        <div class="row mb-6">
                            <div class="col-md-6">
                                <label class="form-label required">Tên đợt thi</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name', $exam->name . ' (Nhân bản)') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label required">Mã đợt thi</label>
                                <input type="text" name="code" class="form-control @error('code') is-invalid @enderror"
                                       value="{{ old('code', $exam->code . '_COPY') }}" required>
                                @error('code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-6">
                            <label class="form-label">Mô tả</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                                      rows="3">{{ old('description', $exam->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-6">
                            <div class="col-md-4">
                                <label class="form-label required">Thời gian bắt đầu</label>
                                <input type="datetime-local" name="start_time" class="form-control @error('start_time') is-invalid @enderror"
                                       value="{{ old('start_time', now()->addDays(1)->format('Y-m-d\TH:i')) }}" required>
                                @error('start_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label required">Thời gian làm bài (phút)</label>
                                <input type="number" name="duration_minutes" class="form-control @error('duration_minutes') is-invalid @enderror"
                                       value="{{ old('duration_minutes', $exam->duration_minutes) }}" min="5" max="300" required>
                                @error('duration_minutes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label required">Trạng thái</label>
                                <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                    <option value="draft" {{ old('status', 'draft') === 'draft' ? 'selected' : '' }}>Nháp</option>
                                    <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Đang hoạt động</option>
                                    <option value="completed" {{ old('status') === 'completed' ? 'selected' : '' }}>Đã hoàn thành</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <!--end::Basic Information-->

                    <div class="separator my-10"></div>

                    <!--begin::Questions Selection-->
                    <div class="mb-10">
                        <div class="d-flex justify-content-between align-items-center mb-5">
                            <h3 class="fw-bold">Câu hỏi</h3>
                            <div>
                                <button type="button" class="btn btn-sm btn-light-primary" id="select-all-questions">
                                    Chọn tất cả
                                </button>
                                <button type="button" class="btn btn-sm btn-light-warning ms-2" id="clear-questions">
                                    Bỏ chọn tất cả
                                </button>
                            </div>
                        </div>
                        
                        @php
                            $selectedQuestions = old('questions', $exam->examQuestions->pluck('question_id')->toArray());
                        @endphp

                        <div class="row">
                            @foreach($questions as $question)
                            <div class="col-md-6 mb-3">
                                <div class="form-check form-check-custom form-check-solid border rounded p-4 h-100">
                                    <input type="checkbox" name="questions[]" value="{{ $question->id }}"
                                           class="form-check-input question-checkbox"
                                           {{ in_array($question->id, $selectedQuestions) ? 'checked' : '' }}>
                                    <div class="form-check-label w-100">
                                        <div class="fw-bold text-gray-800">{{ $question->title }}</div>
                                        @if($question->category)
                                            <span class="badge badge-light-info mt-1">{{ $question->category }}</span>
                                        @endif
                                        @if($question->description)
                                            <div class="text-gray-600 fs-7 mt-2">{{ Str::limit($question->description, 100) }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @error('questions')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            <span id="selected-questions-count">{{ count($selectedQuestions) }}</span> câu hỏi được chọn
                        </div>
                    </div>
                    <!--end::Questions Selection-->

                    <div class="separator my-10"></div>

                    <!--begin::Students Selection-->
                    <div class="mb-10">
                        <div class="d-flex justify-content-between align-items-center mb-5">
                            <h3 class="fw-bold">Sinh viên tham gia</h3>
                            <div>
                                <button type="button" class="btn btn-sm btn-light-primary" id="select-all-students">
                                    Chọn tất cả
                                </button>
                                <button type="button" class="btn btn-sm btn-light-warning ms-2" id="clear-students">
                                    Bỏ chọn tất cả
                                </button>
                            </div>
                        </div>

                        @php
                            $selectedStudents = old('students', $exam->examStudents->pluck('student_id')->toArray());
                        @endphp

                        <div class="row">
                            @foreach($students as $student)
                            <div class="col-md-4 mb-3">
                                <div class="form-check form-check-custom form-check-solid border rounded p-3">
                                    <input type="checkbox" name="students[]" value="{{ $student->id }}"
                                           class="form-check-input student-checkbox"
                                           {{ in_array($student->id, $selectedStudents) ? 'checked' : '' }}>
                                    <div class="form-check-label w-100">
                                        <div class="d-flex align-items-center">
                                            <div class="symbol symbol-30px symbol-circle me-3">
                                                <span class="symbol-label bg-light-success">
                                                    <i class="ki-duotone ki-user fs-4 text-success">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                </span>
                                            </div>
                                            <div>
                                                <div class="fw-bold text-gray-800 fs-7">{{ $student->name }}</div>
                                                <div class="text-gray-600 fs-8">{{ $student->email }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @error('students')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            <span id="selected-students-count">{{ count($selectedStudents) }}</span> sinh viên được chọn
                        </div>
                    </div>
                    <!--end::Students Selection-->

                    <div class="separator my-10"></div>

                    <!--begin::Form Actions-->
                    <div class="text-center">
                        <a href="{{ route('admin.exams.index') }}" class="btn btn-light me-3">Hủy</a>
                        <button type="submit" class="btn btn-primary" id="submit-btn">
                            <span class="indicator-label">
                                <i class="ki-duotone ki-copy fs-4 me-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                Nhân bản Đợt thi
                            </span>
                            <span class="indicator-progress">Đang xử lý...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                    </div>
                    <!--end::Form Actions-->
                </form>
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Form-->
    </div>
    <!--end::Col-->
</div>
<!--end::Row-->
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Question selection handlers
    const questionCheckboxes = document.querySelectorAll('.question-checkbox');
    const questionCount = document.getElementById('selected-questions-count');
    const selectAllQuestions = document.getElementById('select-all-questions');
    const clearQuestions = document.getElementById('clear-questions');

    // Student selection handlers
    const studentCheckboxes = document.querySelectorAll('.student-checkbox');
    const studentCount = document.getElementById('selected-students-count');
    const selectAllStudents = document.getElementById('select-all-students');
    const clearStudents = document.getElementById('clear-students');

    // Form submission
    const form = document.getElementById('clone-exam-form');
    const submitBtn = document.getElementById('submit-btn');

    // Update question count
    function updateQuestionCount() {
        const checked = document.querySelectorAll('.question-checkbox:checked').length;
        questionCount.textContent = checked;
    }

    // Update student count
    function updateStudentCount() {
        const checked = document.querySelectorAll('.student-checkbox:checked').length;
        studentCount.textContent = checked;
    }

    // Question selection events
    questionCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateQuestionCount);
    });

    selectAllQuestions.addEventListener('click', function() {
        questionCheckboxes.forEach(checkbox => {
            checkbox.checked = true;
        });
        updateQuestionCount();
    });

    clearQuestions.addEventListener('click', function() {
        questionCheckboxes.forEach(checkbox => {
            checkbox.checked = false;
        });
        updateQuestionCount();
    });

    // Student selection events
    studentCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateStudentCount);
    });

    selectAllStudents.addEventListener('click', function() {
        studentCheckboxes.forEach(checkbox => {
            checkbox.checked = true;
        });
        updateStudentCount();
    });

    clearStudents.addEventListener('click', function() {
        studentCheckboxes.forEach(checkbox => {
            checkbox.checked = false;
        });
        updateStudentCount();
    });

    // Form submission with loading state
    form.addEventListener('submit', function(e) {
        // Validate at least one question is selected
        const selectedQuestions = document.querySelectorAll('.question-checkbox:checked').length;
        if (selectedQuestions === 0) {
            e.preventDefault();
            alert('Vui lòng chọn ít nhất 1 câu hỏi cho đợt thi.');
            return;
        }

        // Validate at least one student is selected
        const selectedStudents = document.querySelectorAll('.student-checkbox:checked').length;
        if (selectedStudents === 0) {
            e.preventDefault();
            alert('Vui lòng chọn ít nhất 1 sinh viên tham gia đợt thi.');
            return;
        }

        // Show loading state
        submitBtn.setAttribute('data-kt-indicator', 'on');
        submitBtn.disabled = true;
    });

    // Initialize counts
    updateQuestionCount();
    updateStudentCount();
});
</script>
@endpush