@extends('layouts.app')

@section('title', 'Thi Tuyển')

@section('breadcrumbs')
<li class="breadcrumb-item">
    <span class="bullet bg-gray-400 w-5px h-2px"></span>
</li>
<li class="breadcrumb-item text-muted">
    <a href="{{ route('student.dashboard') }}" class="text-muted text-hover-primary">Dashboard</a>
</li>
<li class="breadcrumb-item text-muted">Thi Tuyển</li>
@endsection

@section('content')
<!--begin::Alert-->
@if(session('success'))
    <div class="alert alert-success d-flex align-items-center p-5 mb-10">
        <i class="ki-duotone ki-shield-tick fs-2hx text-success me-4">
            <span class="path1"></span>
            <span class="path2"></span>
        </i>
        <div class="d-flex flex-column">
            <h4 class="mb-1 text-success">Thành công!</h4>
            <span>{{ session('success') }}</span>
        </div>
    </div>
@endif

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

@if(session('info'))
    <div class="alert alert-info d-flex align-items-center p-5 mb-10">
        <i class="ki-duotone ki-information-5 fs-2hx text-info me-4">
            <span class="path1"></span>
            <span class="path2"></span>
            <span class="path3"></span>
        </i>
        <div class="d-flex flex-column">
            <h4 class="mb-1 text-info">Thông báo!</h4>
            <span>{{ session('info') }}</span>
        </div>
    </div>
@endif
<!--end::Alert-->

<!--begin::Row-->
<div class="row g-5 g-xl-10">
    <!--begin::Col-->
    <div class="col-xl-12">
        <!--begin::Exams List-->
        <div class="card card-flush">
            <!--begin::Card header-->
            <div class="card-header pt-7">
                <!--begin::Title-->
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-dark">Đợt thi của tôi</span>
                    <span class="text-gray-400 mt-1 fw-semibold fs-6">Danh sách các đợt thi bạn được tham gia</span>
                </h3>
                <!--end::Title-->
            </div>
            <!--end::Card header-->

            <!--begin::Card body-->
            <div class="card-body">
                @forelse($exams as $exam)
                    @php
                        $examStudent = $exam->examStudents->first();
                        $now = \Carbon\Carbon::now();
                        $canTakeExam = $examStudent &&
                                      $examStudent->status !== 'submitted' &&
                                      $now >= $exam->start_time &&
                                      $now <= $exam->end_time;
                        $hasStarted = $examStudent && $examStudent->started_at;
                        $hasSubmitted = $examStudent && $examStudent->status === 'submitted';
                        $isPastDue = $now > $exam->end_time;
                        $isUpcoming = $now < $exam->start_time;
                    @endphp

                    <!--begin::Exam Item-->
                    <div class="card card-flush border mb-6">
                        <div class="card-body p-6">
                            <div class="d-flex align-items-center">
                                <!--begin::Icon-->
                                <div class="me-6">
                                    <div class="symbol symbol-70px symbol-circle">
                                        <span class="symbol-label bg-light-primary">
                                            <i class="ki-duotone ki-calendar-8 fs-2x text-primary">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                                <span class="path4"></span>
                                                <span class="path5"></span>
                                                <span class="path6"></span>
                                            </i>
                                        </span>
                                    </div>
                                </div>
                                <!--end::Icon-->

                                <!--begin::Content-->
                                <div class="flex-grow-1">
                                    <!--begin::Title-->
                                    <div class="d-flex align-items-center mb-2">
                                        <h3 class="fw-bold text-gray-800 me-3">{{ $exam->name }}</h3>
                                        <span class="badge badge-{{ $exam->status_badge }}">{{ $exam->status_text }}</span>

                                        @if($hasSubmitted)
                                            <span class="badge badge-success ms-2">Đã nộp bài</span>
                                        @elseif($hasStarted)
                                            <span class="badge badge-warning ms-2">Đang làm bài</span>
                                        @elseif($isUpcoming)
                                            <span class="badge badge-info ms-2">Sắp diễn ra</span>
                                        @elseif($isPastDue)
                                            <span class="badge badge-danger ms-2">Đã hết hạn</span>
                                        @endif
                                    </div>
                                    <!--end::Title-->

                                    <!--begin::Description-->
                                    @if($exam->description)
                                    <div class="text-gray-600 mb-3">{{ $exam->description }}</div>
                                    @endif
                                    <!--end::Description-->

                                    <!--begin::Details-->
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="ki-duotone ki-tag fs-4 text-gray-500 me-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                </i>
                                                <span class="text-gray-600">{{ $exam->code }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="ki-duotone ki-time fs-4 text-gray-500 me-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                                <span class="text-gray-600">{{ $exam->duration_formatted }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="ki-duotone ki-questionnaire-tablet fs-4 text-gray-500 me-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                                <span class="text-gray-600">{{ $exam->examQuestions->count() }} câu hỏi</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="ki-duotone ki-calendar fs-4 text-gray-500 me-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                                <span class="text-gray-600">{{ $exam->start_time->format('d/m/Y H:i') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Details-->

                                    <!--begin::Progress-->
                                    @if($examStudent)
                                    <div class="mt-3">
                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                            <span class="fw-bold fs-7 text-gray-600">Trạng thái:</span>
                                            <span class="badge badge-{{ $examStudent->status_badge }}">{{ $examStudent->status_text }}</span>
                                        </div>

                                        @if($examStudent->registered_at)
                                        <div class="d-flex align-items-center justify-content-between mb-1">
                                            <span class="fs-8 text-gray-500">Đăng ký:</span>
                                            <span class="fs-8 text-gray-600">{{ $examStudent->registered_at->format('d/m/Y H:i') }}</span>
                                        </div>
                                        @endif

                                        @if($examStudent->started_at)
                                        <div class="d-flex align-items-center justify-content-between mb-1">
                                            <span class="fs-8 text-gray-500">Bắt đầu:</span>
                                            <span class="fs-8 text-gray-600">{{ $examStudent->started_at->format('d/m/Y H:i') }}</span>
                                        </div>
                                        @endif

                                        @if($examStudent->submitted_at)
                                        <div class="d-flex align-items-center justify-content-between">
                                            <span class="fs-8 text-gray-500">Nộp bài:</span>
                                            <span class="fs-8 text-gray-600">{{ $examStudent->submitted_at->format('d/m/Y H:i') }}</span>
                                        </div>
                                        @endif
                                    </div>
                                    @endif
                                    <!--end::Progress-->
                                </div>
                                <!--end::Content-->

                                <!--begin::Actions-->
                                <div class="ms-6">
                                    @if($hasSubmitted)
                                        <!--Đã nộp bài - hiển thị nút xem kết quả-->
                                        <a href="{{ route('student.exam.result', $exam) }}" class="btn btn-success">
                                            <i class="ki-duotone ki-eye fs-4 me-2">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                            </i>
                                            Xem kết quả
                                        </a>
                                    @elseif($canTakeExam)
                                        <!--Có thể vào thi-->
                                        <a href="{{ route('student.exam.start', $exam) }}" class="btn btn-primary">
                                            <i class="ki-duotone ki-questionnaire-tablet fs-4 me-2">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                            @if($hasStarted)
                                                Tiếp tục làm bài
                                            @else
                                                Vào thi
                                            @endif
                                        </a>
                                    @elseif($isUpcoming)
                                        <!--Chưa đến giờ thi-->
                                        <button class="btn btn-secondary" disabled>
                                            <i class="ki-duotone ki-time fs-4 me-2">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                            Chưa bắt đầu
                                        </button>
                                    @elseif($isPastDue)
                                        <!--Đã hết hạn-->
                                        <button class="btn btn-danger" disabled>
                                            <i class="ki-duotone ki-cross fs-4 me-2">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                            Đã hết hạn
                                        </button>
                                    @else
                                        <!--Không xác định-->
                                        <button class="btn btn-light" disabled>
                                            <i class="ki-duotone ki-information fs-4 me-2">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                            </i>
                                            Không khả dụng
                                        </button>
                                    @endif
                                </div>
                                <!--end::Actions-->
                            </div>
                        </div>
                    </div>
                    <!--end::Exam Item-->
                @empty
                    <!--begin::Empty State-->
                    <div class="text-center py-20">
                        <div class="symbol symbol-100px symbol-circle mx-auto mb-7">
                            <span class="symbol-label bg-light-primary">
                                <i class="ki-duotone ki-calendar-8 fs-2x text-primary">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                    <span class="path4"></span>
                                    <span class="path5"></span>
                                    <span class="path6"></span>
                                </i>
                            </span>
                        </div>
                        <h3 class="text-gray-800 fw-bold mb-3">Chưa có đợt thi nào</h3>
                        <div class="text-gray-600 fw-semibold fs-6 mb-8">
                            Bạn chưa được thêm vào bất kỳ đợt thi nào.<br>
                            Hãy liên hệ với giáo viên để được tham gia.
                        </div>
                    </div>
                    <!--end::Empty State-->
                @endforelse
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Exams List-->
    </div>
    <!--end::Col-->
</div>
<!--end::Row-->
@endsection
