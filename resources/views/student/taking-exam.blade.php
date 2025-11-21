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
                        <button type="button" class="btn btn-light me-3" id="cancel-btn" onclick="confirmCancel()">
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
                <button type="button" class="btn btn-light" data-bs-dismiss="modal" id="cancel-submit-btn">Tiếp tục làm bài</button>
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

<!--begin::Time Up Modal-->
<div class="modal fade" id="time-up-modal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white">
                    <i class="ki-duotone ki-time fs-2 text-white me-2">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    Hết thời gian làm bài
                </h5>
            </div>
            <div class="modal-body text-center">
                <i class="ki-duotone ki-time fs-5x text-danger mb-5">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
                <h4 class="fw-bold text-danger mb-3">Thời gian làm bài đã kết thúc!</h4>
                <p class="text-gray-600 mb-3">
                    Bài thi của bạn đã được tự động lưu và sẽ được nộp ngay bây giờ.
                    Bạn không thể chỉnh sửa thêm.
                </p>
                <div class="d-flex align-items-center justify-content-center">
                    <div class="spinner-border text-primary me-3" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <span class="fw-bold">Đang nộp bài tự động...</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end::Time Up Modal-->
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // End time from server
    const endTime = new Date('{{ $endTime->toISOString() }}').getTime();
    const countdownElement = document.getElementById('countdown');
    const modalCountdownElement = document.getElementById('modal-countdown');
    
    // Track answered questions - KHỞI TẠO SỚM
    const answerTextareas = document.querySelectorAll('.answer-textarea');
    console.log('Initialized answerTextareas:', answerTextareas.length);
    answerTextareas.forEach((textarea, index) => {
        console.log(`Textarea ${index}:`, {
            name: textarea.name,
            className: textarea.className,
            id: textarea.id
        });
    });
    
    const answeredCountElement = document.getElementById('answered-count');
    const unansweredCountElement = document.getElementById('unanswered-count');
    const modalAnsweredElement = document.getElementById('modal-answered');

    // Auto-save to server function
    function autoSaveToServer() {
        const formData = new FormData();
        const csrfToken = document.querySelector('[name="_token"]').value;
        formData.append('_token', csrfToken);
        
        console.log('CSRF Token:', csrfToken);
        console.log('Found textareas:', answerTextareas.length);
        
        // Gửi tất cả câu trả lời, kể cả rỗng để track tiến độ
        answerTextareas.forEach((textarea, index) => {
            console.log(`Textarea ${index}:`, {
                name: textarea.name,
                value: textarea.value,
                length: textarea.value.length
            });
            formData.append(textarea.name, textarea.value || '');
        });

        // Debug: log what we're sending
        console.log('FormData entries:');
        for (let [key, value] of formData.entries()) {
            console.log(`${key}: "${value}"`);
        }
        
        // Alternative: convert to plain object để dễ debug
        const dataObject = Object.fromEntries(formData);
        console.log('Data as object:', dataObject);
        console.log('Object keys:', Object.keys(dataObject));
        console.log('Total keys:', Object.keys(dataObject).length);
        
        return fetch('{{ route("student.exam.autosave", $exam) }}?t=' + Date.now(), {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Cache-Control': 'no-cache'
            }
        })
        .then(response => {
            console.log('Auto-save response status:', response.status);
            return response.json();
        })
        .then(data => {
            console.log('Auto-save response data:', data);
            if (data.success) {
                console.log('Auto-saved to server at:', new Date().toLocaleTimeString(), 'Saved answers:', data.saved_answers);
                showAutoSaveIndicator();
                return true;
            } else {
                console.error('Auto-save failed:', data.message);
                return false;
            }
        })
        .catch(error => {
            console.error('Auto-save error:', error);
            return false;
        });
    }

    function showAutoSaveIndicator() {
        // Remove existing indicator
        const existingIndicator = document.querySelector('.auto-save-indicator');
        if (existingIndicator) {
            existingIndicator.remove();
        }

        const indicator = document.createElement('div');
        indicator.className = 'auto-save-indicator alert alert-success position-fixed';
        indicator.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 250px; opacity: 0; transition: opacity 0.3s;';
        indicator.innerHTML = `
            <div class="d-flex align-items-center">
                <i class="ki-duotone ki-check-circle fs-4 text-success me-2">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
                <span>Đã tự động lưu bài làm</span>
            </div>
        `;
        document.body.appendChild(indicator);
        
        // Fade in
        setTimeout(() => {
            indicator.style.opacity = '1';
        }, 10);
        
        // Fade out and remove
        setTimeout(() => {
            indicator.style.opacity = '0';
            setTimeout(() => {
                if (indicator.parentNode) {
                    indicator.remove();
                }
            }, 300);
        }, 3000);
    }

    // Function to disable exam interface when time is up
    function disableExamInterface() {
        // Disable all textareas
        answerTextareas.forEach(textarea => {
            textarea.disabled = true;
            textarea.style.backgroundColor = '#f5f5f5';
            textarea.style.cursor = 'not-allowed';
        });

        // Disable all buttons
        const allButtons = document.querySelectorAll('button, .btn');
        allButtons.forEach(button => {
            button.disabled = true;
            button.classList.add('disabled');
        });

        // Remove beforeunload handler to prevent popup when submitting
        window.removeEventListener('beforeunload', beforeUnloadHandler);
        
        // Hide submit modal if open
        const submitModal = bootstrap.Modal.getInstance(document.getElementById('submit-modal'));
        if (submitModal) {
            submitModal.hide();
        }
    }

    // Function to show time up modal
    function showTimeUpModal() {
        const timeUpModal = new bootstrap.Modal(document.getElementById('time-up-modal'), {
            backdrop: 'static',
            keyboard: false
        });
        timeUpModal.show();
    }

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

            // Auto-save when 30 seconds left
            if (timeLeft < 30 * 1000 && timeLeft > 25 * 1000) {
                console.log('Final auto-save before time up...');
                autoSaveToServer();
            }
        } else {
            countdownElement.textContent = '00:00:00';
            modalCountdownElement.textContent = '00:00:00';
            clearInterval(countdownInterval);
            clearInterval(autoSaveInterval);
            
            // Set time up flag
            isTimeUp = true;

            // Show time up modal and disable interface immediately
            showTimeUpModal();
            disableExamInterface();

            // Final save before auto-submit
            console.log('Time up! Final save before submit...');
            autoSaveToServer().finally(() => {
                setTimeout(() => {
                    document.getElementById('exam-form').submit();
                }, 3000); // Give user 3 seconds to read the message
            });
        }
    }, 1000);

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

    // Debounced auto-save when user types
    let saveTimeout;
    function debouncedAutoSave() {
        clearTimeout(saveTimeout);
        saveTimeout = setTimeout(() => {
            console.log('Debounced auto-save triggered by user input');
            autoSaveToServer();
        }, 5000); // Save 5 seconds after user stops typing
    }

    // Listen for input changes
    answerTextareas.forEach(textarea => {
        textarea.addEventListener('input', function() {
            updateAnswerCount();
            debouncedAutoSave();
        });
    });

    // Submit buttons
    const submitExamBtn = document.getElementById('submit-exam');
    const finalSubmitBtn = document.getElementById('final-submit');
    const confirmSubmitBtn = document.getElementById('confirm-submit');
    const submitModal = new bootstrap.Modal(document.getElementById('submit-modal'));
    
    let isTimeUp = false; // Flag to track if time is up

    // Show modal on submit button click
    [submitExamBtn, finalSubmitBtn].forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Prevent submit if time is up
            if (isTimeUp) {
                return false;
            }
            
            updateAnswerCount();
            // Save before showing modal
            autoSaveToServer().then(() => {
                submitModal.show();
            });
        });
    });

    // Confirm submit
    confirmSubmitBtn.addEventListener('click', function() {
        const form = document.getElementById('exam-form');
        finalSubmitBtn.setAttribute('data-kt-indicator', 'on');
        finalSubmitBtn.disabled = true;
        
        // Final save before submit
        autoSaveToServer().finally(() => {
            form.submit();
        });
    });

    // Prevent accidental page leave
    const beforeUnloadHandler = function(e) {
        // Quick save attempt
        navigator.sendBeacon('{{ route("student.exam.autosave", $exam) }}', new FormData(document.getElementById('exam-form')));
        
        e.preventDefault();
        e.returnValue = '';
        return 'Bạn có chắc chắn muốn rời khỏi trang? Dữ liệu chưa lưu sẽ bị mất.';
    };
    
    window.addEventListener('beforeunload', beforeUnloadHandler);

    // Auto-save to server every 30 seconds
    const autoSaveInterval = setInterval(function() {
        console.log('Periodic auto-save triggered (every 30s)');
        autoSaveToServer();
    }, 30000);

    // Auto-save to localStorage every 10 seconds (backup)
    setInterval(function() {
        const formData = {};
        answerTextareas.forEach(textarea => {
            formData[textarea.name] = textarea.value;
        });
        localStorage.setItem('exam_{{ $exam->id }}_answers', JSON.stringify(formData));
    }, 10000);

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

    // Initial update
    updateAnswerCount();

    // Function to confirm cancel/exit
    window.confirmCancel = function() {
        // Prevent cancel if time is up
        if (isTimeUp) {
            alert('Thời gian đã hết. Không thể thoát ra ngoài.');
            return false;
        }
        
        if (confirm('Bạn có chắc chắn muốn thoát? Dữ liệu đã nhập sẽ được tự động lưu.')) {
            autoSaveToServer().finally(() => {
                window.history.back();
            });
        }
    };
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
