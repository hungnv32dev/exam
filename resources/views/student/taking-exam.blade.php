@extends('layouts.app')

@section('title', 'Làm bài thi - ' . $exam->name)

@section('breadcrumbs')
<li class="breadcrumb-item">
    <span class="bullet bg-gray-400 w-5px h-2px"></span>
</li>
<li class="breadcrumb-item text-muted">
    <a href="{{ route('student.dashboard') }}" class="text-muted text-hover-primary">Dashboard</a>
</li>
<li class="breadcrumb-item text-muted">
    <a href="{{ route('student.exams') }}" class="text-muted text-hover-primary">Thi Tuyển</a>
</li>
<li class="breadcrumb-item text-muted">Làm bài thi</li>
@endsection

@section('content')
<!--begin::Row-->
<div class="row g-5 g-xl-10">
    <!--begin::Col-->
    <div class="col-xl-3">
        <!--begin::Exam Info-->
        <div class="card card-flush mb-6 position-sticky" style="top: 100px;">
            <!--begin::Card header-->
            <div class="card-header">
                <!--begin::Card title-->
                <div class="card-title">
                    <h3 class="fw-bold">Thông tin bài thi</h3>
                </div>
                <!--end::Card title-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body">
                <div class="mb-5">
                    <div class="fw-bold text-gray-800 mb-2">{{ $exam->name }}</div>
                    <div class="text-gray-600 fs-7">{{ $exam->code }}</div>
                </div>

                <div class="separator my-5"></div>

                <!--begin::Timer-->
                <div class="text-center mb-5">
                    <div class="fw-bold text-gray-800 fs-6 mb-2">Thời gian còn lại:</div>
                    <div id="countdown" class="fs-1 fw-bold text-danger">--:--:--</div>
                </div>
                <!--end::Timer-->

                <div class="separator my-5"></div>

                <!--begin::Stats-->
                <div class="mb-5">
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-600">Tổng câu hỏi:</span>
                        <span class="fw-bold">{{ $exam->examQuestions->count() }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-600">Đã trả lời:</span>
                        <span class="fw-bold" id="answered-count">0</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-gray-600">Chưa trả lời:</span>
                        <span class="fw-bold" id="unanswered-count">{{ $exam->examQuestions->count() }}</span>
                    </div>
                </div>
                <!--end::Stats-->

                <div class="separator my-5"></div>

                <!--begin::Submit-->
                <button type="button" id="submit-exam" class="btn btn-primary w-100">
                    <i class="ki-duotone ki-check fs-4 me-2">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    Nộp bài
                </button>
                <!--end::Submit-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Exam Info-->
    </div>
    <!--end::Col-->

    <!--begin::Col-->
    <div class="col-xl-9">
        <!--begin::Exam Questions-->
        <div class="card card-flush">
            <!--begin::Card header-->
            <div class="card-header">
                <!--begin::Card title-->
                <div class="card-title">
                    <h3 class="fw-bold">{{ $exam->name }}</h3>
                </div>
                <!--end::Card title-->
            </div>
            <!--end::Card header-->

            <!--begin::Card body-->
            <div class="card-body">
                <form id="exam-form" method="POST" action="{{ route('student.exam.submit', $exam) }}">
                    @csrf

                    @foreach($exam->examQuestions as $index => $examQuestion)
                        @php $question = $examQuestion->question; @endphp

                        <!--begin::Question-->
                        <div class="question-item border rounded p-6 mb-6" data-question="{{ $index + 1 }}">
                            <!--begin::Question Header-->
                            <div class="d-flex align-items-center mb-5">
                                <span class="badge badge-primary badge-lg me-4">Câu {{ $examQuestion->order_number }}</span>
                                {{-- <h4 class="fw-bold text-gray-800 mb-0">{{ $question->title }}</h4> --}}
                                @if($question->category)
                                    <span class="badge badge-light-info ms-3">{{ $question->category }}</span>
                                @endif
                            </div>
                            <!--end::Question Header-->

                            <!--begin::Question Description-->
                            {{-- @if($question->description)
                            <div class="text-gray-700 mb-4">
                                <strong>Mô tả:</strong> {{ $question->description }}
                            </div>
                            @endif --}}
                            <!--end::Question Description-->

                            <!--begin::Question Content-->
                            <div class="bg-light-info rounded p-5 mb-5">
                                <div class="text-gray-800 fw-semibold">
                                    {!! nl2br(e($question->content)) !!}
                                </div>
                            </div>
                            <!--end::Question Content-->

                            <!--begin::YouTube Video-->
                            @if($question->hasYoutubeVideo())
                            <div class="mb-5">
                                <div class="card card-flush bg-light-danger">
                                    <div class="card-header">
                                        <h5 class="card-title">
                                            <i class="ki-duotone ki-youtube fs-2 text-danger me-2">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                            Video hướng dẫn
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="ratio ratio-16x9">
                                            <iframe src="{{ $question->getYoutubeEmbedUrl() }}"
                                                    frameborder="0"
                                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                    allowfullscreen></iframe>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            <!--end::YouTube Video-->

                            <!--begin::Answer Section-->
                            <div class="mt-5">
                                <label class="form-label fw-bold text-gray-800 fs-6 required">
                                    Câu trả lời của bạn:
                                </label>
                                <textarea name="answers[{{ $question->id }}]"
                                          class="form-control form-control-solid answer-textarea"
                                          rows="8"
                                          placeholder="Nhập câu trả lời chi tiết của bạn..."
                                          required>{{ $existingAnswers[$question->id] ?? '' }}</textarea>
                                <div class="form-text">
                                    Hãy trả lời chi tiết và đầy đủ. Bài thi này sẽ được gửi đến hội đồng.
                                </div>
                            </div>
                            <!--end::Answer Section-->
                        </div>
                        <!--end::Question-->
                    @endforeach

                    <!--begin::Submit Section-->
                    <div class="text-center pt-10">
                        <button type="button" class="btn btn-light me-3" onclick="window.history.back()">
                            <i class="ki-duotone ki-arrow-left fs-4 me-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            Quay lại
                        </button>
                        <button type="submit" class="btn btn-primary btn-lg" id="final-submit">
                            <span class="indicator-label">
                                <i class="ki-duotone ki-check fs-4 me-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                Nộp bài thi
                            </span>
                            <span class="indicator-progress">Đang nộp bài...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                    </div>
                    <!--end::Submit Section-->
                </form>
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Exam Questions-->
    </div>
    <!--end::Col-->
</div>
<!--end::Row-->

<!--begin::Submit Confirmation Modal-->
<div class="modal fade" id="submit-modal" tabindex="-1" aria-labelledby="submitModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="submitModalLabel">Xác nhận nộp bài</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <i class="ki-duotone ki-information-5 fs-3x text-warning mb-5">
                        <span class="path1"></span>
                        <span class="path2"></span>
                        <span class="path3"></span>
                    </i>
                    <h4 class="fw-bold text-gray-800 mb-3">Bạn có chắc chắn muốn nộp bài?</h4>
                    <p class="text-gray-600 mb-5">
                        Sau khi nộp bài, bạn không thể chỉnh sửa câu trả lời.
                        Hãy kiểm tra lại các câu trả lời trước khi nộp.
                    </p>

                    <div class="alert alert-info d-flex align-items-center">
                        <i class="ki-duotone ki-information-4 fs-2 text-info me-3">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                        </i>
                        <div>
                            <strong>Thời gian còn lại:</strong> <span id="modal-countdown">--:--:--</span><br>
                            <strong>Đã trả lời:</strong> <span id="modal-answered">0</span> / {{ $exam->examQuestions->count() }} câu
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tiếp tục làm bài</button>
                <button type="button" class="btn btn-primary" id="confirm-submit">
                    <i class="ki-duotone ki-check fs-4 me-2">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    Xác nhận nộp bài
                </button>
            </div>
        </div>
    </div>
</div>
<!--end::Submit Confirmation Modal-->
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // End time from server
    const endTime = new Date('{{ $endTime->toISOString() }}').getTime();
    const countdownElement = document.getElementById('countdown');
    const modalCountdownElement = document.getElementById('modal-countdown');

    // Update countdown every second
    const countdownInterval = setInterval(function() {
        const now = new Date().getTime();
        const timeLeft = endTime - now;

        if (timeLeft > 0) {
            const hours = Math.floor(timeLeft / (1000 * 60 * 60));
            const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

            const timeString = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            countdownElement.textContent = timeString;
            modalCountdownElement.textContent = timeString;

            // Warning when less than 5 minutes
            if (timeLeft < 5 * 60 * 1000) {
                countdownElement.classList.add('text-danger', 'fw-bold');
                countdownElement.style.animation = 'blink 1s infinite';
            }
        } else {
            countdownElement.textContent = '00:00:00';
            modalCountdownElement.textContent = '00:00:00';
            clearInterval(countdownInterval);

            // Auto submit when time is up
            alert('Hết thời gian! Bài thi sẽ được nộp tự động.');
            document.getElementById('exam-form').submit();
        }
    }, 1000);

    // Track answered questions
    const answerTextareas = document.querySelectorAll('.answer-textarea');
    const answeredCountElement = document.getElementById('answered-count');
    const unansweredCountElement = document.getElementById('unanswered-count');
    const modalAnsweredElement = document.getElementById('modal-answered');

    function updateAnswerCount() {
        let answeredCount = 0;
        answerTextareas.forEach(textarea => {
            if (textarea.value.trim().length > 0) {
                answeredCount++;
            }
        });

        const totalQuestions = answerTextareas.length;
        answeredCountElement.textContent = answeredCount;
        unansweredCountElement.textContent = totalQuestions - answeredCount;
        modalAnsweredElement.textContent = answeredCount;
    }

    // Listen for input changes
    answerTextareas.forEach(textarea => {
        textarea.addEventListener('input', updateAnswerCount);
    });

    // Submit buttons
    const submitExamBtn = document.getElementById('submit-exam');
    const finalSubmitBtn = document.getElementById('final-submit');
    const confirmSubmitBtn = document.getElementById('confirm-submit');
    const submitModal = new bootstrap.Modal(document.getElementById('submit-modal'));

    // Show modal on submit button click
    [submitExamBtn, finalSubmitBtn].forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            updateAnswerCount();
            submitModal.show();
        });
    });

    // Confirm submit
    confirmSubmitBtn.addEventListener('click', function() {
        const form = document.getElementById('exam-form');
        finalSubmitBtn.setAttribute('data-kt-indicator', 'on');
        finalSubmitBtn.disabled = true;
        form.submit();
    });

    // Prevent accidental page leave
    window.addEventListener('beforeunload', function(e) {
        e.preventDefault();
        e.returnValue = '';
        return 'Bạn có chắc chắn muốn rời khỏi trang? Dữ liệu chưa lưu sẽ bị mất.';
    });

    // Auto-save every 30 seconds (to localStorage)
    setInterval(function() {
        const formData = {};
        answerTextareas.forEach(textarea => {
            formData[textarea.name] = textarea.value;
        });
        localStorage.setItem('exam_{{ $exam->id }}_answers', JSON.stringify(formData));
    }, 30000);

    // Restore answers from localStorage
    const savedAnswers = localStorage.getItem('exam_{{ $exam->id }}_answers');
    if (savedAnswers) {
        try {
            const answers = JSON.parse(savedAnswers);
            answerTextareas.forEach(textarea => {
                if (answers[textarea.name]) {
                    textarea.value = answers[textarea.name];
                }
            });
            updateAnswerCount();
        } catch (e) {
            console.log('Could not restore saved answers');
        }
    }
});

// CSS for blinking animation
const style = document.createElement('style');
style.textContent = `
@keyframes blink {
    0% { opacity: 1; }
    50% { opacity: 0.5; }
    100% { opacity: 1; }
}
`;
document.head.appendChild(style);
</script>
@endpush
