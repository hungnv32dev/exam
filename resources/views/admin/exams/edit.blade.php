@extends('layouts.app')

@section('title', 'Chỉnh sửa Đợt thi')

@section('breadcrumbs')
<li class="breadcrumb-item">
    <span class="bullet bg-gray-400 w-5px h-2px"></span>
</li>
<li class="breadcrumb-item text-muted">
    <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Admin</a>
</li>
<li class="breadcrumb-item text-muted">
    <a href="{{ route('admin.exams.index') }}" class="text-muted text-hover-primary">Đợt thi</a>
</li>
<li class="breadcrumb-item text-muted">Chỉnh sửa</li>
@endsection

@section('content')
<!--begin::Row-->
<div class="row g-5 g-xl-10">
    <!--begin::Col-->
    <div class="col-xl-12">
        <!--begin::Edit Exam Form-->
        <div class="card card-flush">
            <!--begin::Card header-->
            <div class="card-header">
                <!--begin::Card title-->
                <div class="card-title">
                    <h2>Chỉnh sửa Đợt thi: {{ Str::limit($exam->name, 50) }}</h2>
                </div>
                <!--end::Card title-->
            </div>
            <!--end::Card header-->

            <!--begin::Card body-->
            <div class="card-body pt-7">
                <form method="POST" action="{{ route('admin.exams.update', $exam) }}" class="form" id="exam-form">
                    @csrf
                    @method('PUT')

                    <!--begin::Basic Info Section-->
                    <div class="row mb-7">
                        <div class="col-12">
                            <h3 class="fw-bold mb-5">Thông tin cơ bản</h3>
                        </div>
                    </div>

                    <!--begin::Input group-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <div class="col-lg-4 d-flex align-items-center">
                            <label class="required fw-semibold fs-6 mb-2">Tên đợt thi</label>
                        </div>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <input type="text" name="name" value="{{ old('name', $exam->name) }}"
                                   class="form-control form-control-solid @error('name') is-invalid @enderror"
                                   placeholder="Nhập tên đợt thi..." required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <div class="col-lg-4 d-flex align-items-center">
                            <label class="required fw-semibold fs-6 mb-2">Thời gian làm bài (phút)</label>
                        </div>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <input type="number" name="duration_minutes" value="{{ old('duration_minutes', $exam->duration_minutes) }}"
                                   class="form-control form-control-solid @error('duration_minutes') is-invalid @enderror"
                                   placeholder="Nhập thời gian làm bài..." min="1" max="600" required>
                            @error('duration_minutes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Thời gian tính bằng phút (tối đa 600 phút = 10 giờ)</div>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <div class="col-lg-4 d-flex align-items-center">
                            <label class="required fw-semibold fs-6 mb-2">Thời gian bắt đầu</label>
                        </div>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <input type="datetime-local" name="start_time" value="{{ old('start_time', $exam->start_time->format('Y-m-d\TH:i')) }}"
                                   class="form-control form-control-solid @error('start_time') is-invalid @enderror" required>
                            @error('start_time')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <div class="col-lg-4 d-flex align-items-center">
                            <label class="required fw-semibold fs-6 mb-2">Thời gian kết thúc</label>
                        </div>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <input type="datetime-local" name="end_time" value="{{ old('end_time', $exam->end_time->format('Y-m-d\TH:i')) }}"
                                   class="form-control form-control-solid @error('end_time') is-invalid @enderror" required>
                            @error('end_time')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <div class="col-lg-4 d-flex align-items-center">
                            <label class="fw-semibold fs-6 mb-2">Mô tả</label>
                        </div>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <textarea name="description" rows="3"
                                      class="form-control form-control-solid @error('description') is-invalid @enderror"
                                      placeholder="Nhập mô tả về đợt thi...">{{ old('description', $exam->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <div class="col-lg-4 d-flex align-items-center">
                            <label class="required fw-semibold fs-6 mb-2">Trạng thái</label>
                        </div>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <select name="status" class="form-select form-select-solid @error('status') is-invalid @enderror" required>
                                <option value="draft" {{ old('status', $exam->status) == 'draft' ? 'selected' : '' }}>Bản nháp</option>
                                <option value="active" {{ old('status', $exam->status) == 'active' ? 'selected' : '' }}>Hoạt động</option>
                                <option value="completed" {{ old('status', $exam->status) == 'completed' ? 'selected' : '' }}>Đã hoàn thành</option>
                                <option value="cancelled" {{ old('status', $exam->status) == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Questions Section-->
                    <div class="separator my-10"></div>
                    <div class="row mb-7">
                        <div class="col-12">
                            <h3 class="fw-bold mb-5">Danh sách câu hỏi (theo thứ tự)</h3>
                        </div>
                    </div>

                    <div class="row mb-7">
                        <div class="col-lg-4 d-flex align-items-center">
                            <label class="required fw-semibold fs-6 mb-2">Chọn câu hỏi</label>
                        </div>
                        <div class="col-lg-8">
                            <div class="card card-flush border-primary">
                                <div class="card-header">
                                    <div class="card-title">
                                        <i class="ki-duotone ki-questionnaire-tablet fs-2 text-primary me-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                        Câu hỏi đã chọn
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div id="selected-questions" class="mb-5">
                                        @if($exam->examQuestions->count() > 0)
                                            @foreach($exam->examQuestions as $examQuestion)
                                            <div class="border rounded p-3 mb-3 d-flex align-items-center justify-content-between">
                                                <div class="d-flex align-items-center">
                                                    <span class="badge badge-primary me-3">{{ $examQuestion->order_number }}</span>
                                                    <div>
                                                        <div class="fw-bold text-gray-800">{{ $examQuestion->question->title }}</div>
                                                        <div class="text-gray-500 fs-7">{{ $examQuestion->question->category ?? 'Chưa phân loại' }}</div>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <button type="button" class="btn btn-sm btn-light-warning me-2 move-up-btn" {{ $examQuestion->order_number === 1 ? 'disabled' : '' }}>
                                                        <i class="ki-duotone ki-arrow-up fs-4"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-light-warning me-2 move-down-btn" {{ $examQuestion->order_number === $exam->examQuestions->count() ? 'disabled' : '' }}>
                                                        <i class="ki-duotone ki-arrow-down fs-4"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-light-danger remove-question-btn">
                                                        <i class="ki-duotone ki-trash fs-4"></i>
                                                    </button>
                                                    <input type="hidden" name="questions[]" value="{{ $examQuestion->question_id }}">
                                                </div>
                                            </div>
                                            @endforeach
                                        @else
                                            <div class="text-gray-600 text-center py-5" id="no-questions">
                                                Chưa có câu hỏi nào được chọn
                                            </div>
                                        @endif
                                    </div>

                                    <div class="d-flex align-items-center">
                                        <select id="question-select" class="form-select form-select-solid me-3">
                                            <option value="">Chọn câu hỏi...</option>
                                            @foreach($questions as $question)
                                                @if(!in_array($question->id, $selectedQuestions))
                                                <option value="{{ $question->id }}"
                                                        data-title="{{ $question->title }}"
                                                        data-category="{{ $question->category }}">
                                                    {{ $question->title }}
                                                    @if($question->category)
                                                        ({{ $question->category }})
                                                    @endif
                                                </option>
                                                @endif
                                            @endforeach
                                        </select>
                                        <button type="button" id="add-question-btn" class="btn btn-primary">
                                            <i class="ki-duotone ki-plus fs-4"></i>
                                            Thêm
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @error('questions')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <!--end::Questions Section-->

                    <!--begin::Students Section-->
                    <div class="separator my-10"></div>
                    <div class="row mb-7">
                        <div class="col-12">
                            <h3 class="fw-bold mb-5">Danh sách sinh viên tham gia</h3>
                        </div>
                    </div>

                    <div class="row mb-7">
                        <div class="col-lg-4 d-flex align-items-center">
                            <label class="required fw-semibold fs-6 mb-2">Chọn sinh viên</label>
                        </div>
                        <div class="col-lg-8">
                            <div class="card card-flush border-success">
                                <div class="card-header">
                                    <div class="card-title">
                                        <i class="ki-duotone ki-people fs-2 text-success me-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                            <span class="path4"></span>
                                            <span class="path5"></span>
                                        </i>
                                        Sinh viên đã chọn
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-5">
                                        @foreach($students as $student)
                                        <div class="col-md-6 col-lg-4 mb-3">
                                            <label class="form-check form-check-custom form-check-solid">
                                                <input class="form-check-input" type="checkbox" name="students[]" value="{{ $student->id }}"
                                                       {{ in_array($student->id, old('students', $selectedStudents)) ? 'checked' : '' }} />
                                                <span class="form-check-label fw-semibold text-gray-700">
                                                    {{ $student->name }}
                                                    <br><small class="text-muted">{{ $student->email }}</small>
                                                </span>
                                            </label>
                                        </div>
                                        @endforeach
                                    </div>

                                    <div class="d-flex align-items-center">
                                        <button type="button" id="select-all-students" class="btn btn-sm btn-light-success me-2">
                                            <i class="ki-duotone ki-check-circle fs-4"></i>
                                            Chọn tất cả
                                        </button>
                                        <button type="button" id="deselect-all-students" class="btn btn-sm btn-light-danger">
                                            <i class="ki-duotone ki-cross-circle fs-4"></i>
                                            Bỏ chọn tất cả
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @error('students')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <!--end::Students Section-->

                    <!--begin::Info card-->
                    <div class="notice d-flex bg-light-primary rounded border-primary border border-dashed p-6 mb-7">
                        <i class="ki-duotone ki-information-5 fs-2tx text-primary me-4">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                        </i>
                        <div class="d-flex flex-stack flex-grow-1">
                            <div class="fw-semibold">
                                <div class="fs-6 text-gray-700">
                                    <strong>Mã đợt thi:</strong> {{ $exam->code }}<br>
                                    <strong>Tạo bởi:</strong> {{ $exam->creator->name }}<br>
                                    <strong>Ngày tạo:</strong> {{ $exam->created_at->format('d/m/Y H:i') }}<br>
                                    <strong>Cập nhật lần cuối:</strong> {{ $exam->updated_at->format('d/m/Y H:i') }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Info card-->

                    <!--begin::Actions-->
                    <div class="text-center pt-15">
                        <a href="{{ route('admin.exams.index') }}" class="btn btn-light me-3">
                            <i class="ki-duotone ki-arrow-left fs-3">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            Quay lại
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <span class="indicator-label">
                                <i class="ki-duotone ki-check fs-3">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                Cập nhật
                            </span>
                            <span class="indicator-progress">Đang xử lý...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                    </div>
                    <!--end::Actions-->
                </form>
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Edit Exam Form-->
    </div>
    <!--end::Col-->
</div>
<!--end::Row-->
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let questionOrder = {{ $exam->examQuestions->count() + 1 }};
    const selectedQuestions = new Set(@json($selectedQuestions));

    // Add question functionality
    const addQuestionBtn = document.getElementById('add-question-btn');
    const questionSelect = document.getElementById('question-select');
    const selectedQuestionsDiv = document.getElementById('selected-questions');
    const noQuestionsDiv = document.getElementById('no-questions');

    // Hide no questions message if we have questions
    if (selectedQuestions.size > 0) {
        noQuestionsDiv.style.display = 'none';
    }

    addQuestionBtn.addEventListener('click', function() {
        const selectedOption = questionSelect.options[questionSelect.selectedIndex];
        const questionId = selectedOption.value;

        if (!questionId || selectedQuestions.has(questionId)) {
            return;
        }

        selectedQuestions.add(questionId);

        const questionTitle = selectedOption.dataset.title;
        const questionCategory = selectedOption.dataset.category || 'Chưa phân loại';

        // Hide no questions message
        noQuestionsDiv.style.display = 'none';

        // Create question item
        const questionItem = document.createElement('div');
        questionItem.className = 'border rounded p-3 mb-3 d-flex align-items-center justify-content-between';
        questionItem.innerHTML = `
            <div class="d-flex align-items-center">
                <span class="badge badge-primary me-3">${questionOrder}</span>
                <div>
                    <div class="fw-bold text-gray-800">${questionTitle}</div>
                    <div class="text-gray-500 fs-7">${questionCategory}</div>
                </div>
            </div>
            <div class="d-flex align-items-center">
                <button type="button" class="btn btn-sm btn-light-warning me-2 move-up-btn" ${questionOrder === 1 ? 'disabled' : ''}>
                    <i class="ki-duotone ki-arrow-up fs-4"></i>
                </button>
                <button type="button" class="btn btn-sm btn-light-warning me-2 move-down-btn">
                    <i class="ki-duotone ki-arrow-down fs-4"></i>
                </button>
                <button type="button" class="btn btn-sm btn-light-danger remove-question-btn">
                    <i class="ki-duotone ki-trash fs-4"></i>
                </button>
                <input type="hidden" name="questions[]" value="${questionId}">
            </div>
        `;

        selectedQuestionsDiv.appendChild(questionItem);
        questionOrder++;

        // Remove from select
        selectedOption.remove();
        questionSelect.selectedIndex = 0;

        updateQuestionNumbers();
    });

    // Remove question and move up/down functionality
    selectedQuestionsDiv.addEventListener('click', function(e) {
        const questionItem = e.target.closest('.border');

        if (e.target.closest('.remove-question-btn')) {
            const questionId = questionItem.querySelector('input[name="questions[]"]').value;
            selectedQuestions.delete(questionId);

            // Add back to select
            const option = document.createElement('option');
            option.value = questionId;
            option.textContent = questionItem.querySelector('.fw-bold').textContent;
            questionSelect.appendChild(option);

            questionItem.remove();
            questionOrder--;

            if (selectedQuestions.size === 0) {
                noQuestionsDiv.style.display = 'block';
            }

            updateQuestionNumbers();
        } else if (e.target.closest('.move-up-btn')) {
            const prevItem = questionItem.previousElementSibling;
            if (prevItem && !prevItem.id) {
                selectedQuestionsDiv.insertBefore(questionItem, prevItem);
                updateQuestionNumbers();
            }
        } else if (e.target.closest('.move-down-btn')) {
            const nextItem = questionItem.nextElementSibling;
            if (nextItem) {
                selectedQuestionsDiv.insertBefore(nextItem, questionItem);
                updateQuestionNumbers();
            }
        }
    });

    function updateQuestionNumbers() {
        const questionItems = selectedQuestionsDiv.querySelectorAll('.border');
        questionItems.forEach((item, index) => {
            if (!item.id) { // Skip the no-questions div
                const badge = item.querySelector('.badge');
                badge.textContent = index + 1;

                const moveUpBtn = item.querySelector('.move-up-btn');
                const moveDownBtn = item.querySelector('.move-down-btn');

                moveUpBtn.disabled = index === 0;
                moveDownBtn.disabled = index === questionItems.length - 1;
            }
        });
    }

    // Student selection functionality
    document.getElementById('select-all-students').addEventListener('click', function() {
        document.querySelectorAll('input[name="students[]"]').forEach(checkbox => {
            checkbox.checked = true;
        });
    });

    document.getElementById('deselect-all-students').addEventListener('click', function() {
        document.querySelectorAll('input[name="students[]"]').forEach(checkbox => {
            checkbox.checked = false;
        });
    });

    // Form submission
    document.getElementById('exam-form').addEventListener('submit', function(e) {
        const submitButton = this.querySelector('button[type="submit"]');
        submitButton.setAttribute('data-kt-indicator', 'on');
        submitButton.disabled = true;
    });

    // Initial question numbers update
    updateQuestionNumbers();
});
</script>
@endpush
