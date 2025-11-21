@extends('layouts.app')

@section('title', 'Kết quả bài thi - ' . $exam->name)

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
<li class="breadcrumb-item text-muted">Kết quả bài thi</li>
@endsection

@section('content')
<!--begin::Row-->
<div class="row g-5 g-xl-10">
    <!--begin::Col-->
    <div class="col-xl-4">
        <!--begin::Exam Result Info-->
        <div class="card card-flush mb-6">
            <!--begin::Card header-->
            <div class="card-header">
                <!--begin::Card title-->
                <div class="card-title">
                    <h3 class="fw-bold">Kết quả bài thi</h3>
                </div>
                <!--end::Card title-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body">
                <!--begin::Exam Info-->
                <div class="text-center mb-7">
                    <div class="symbol symbol-100px symbol-circle mx-auto mb-5">
                        <span class="symbol-label bg-light-success">
                            <i class="ki-duotone ki-check fs-2x text-success">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </span>
                    </div>
                    <h4 class="fw-bold text-gray-800 mb-2">Đã nộp bài thành công!</h4>
                    <div class="text-gray-600">{{ $exam->name }}</div>
                    <div class="text-gray-500 fs-7">{{ $exam->code }}</div>
                </div>
                <!--end::Exam Info-->

                <div class="separator my-7"></div>

                <!--begin::Details-->
                <div class="mb-7">
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-600">Thời gian bắt đầu:</span>
                        <span class="fw-bold">{{ $examStudent->started_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-600">Thời gian nộp bài:</span>
                        <span class="fw-bold">{{ $examStudent->submitted_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-600">Thời gian làm bài:</span>
                        <span class="fw-bold">
                            @php
                                $duration = $examStudent->started_at->diffInMinutes($examStudent->submitted_at);
                                $hours = floor($duration / 60);
                                $minutes = $duration % 60;
                                echo $hours > 0 ? "{$hours}h {$minutes}m" : "{$minutes} phút";
                            @endphp
                        </span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-600">Tổng số câu hỏi:</span>
                        <span class="fw-bold">{{ $exam->examQuestions->count() }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-gray-600">Trạng thái:</span>
                        <span class="badge badge-{{ $examStudent->status_badge }}">{{ $examStudent->status_text }}</span>
                    </div>
                </div>
                <!--end::Details-->

                <div class="separator my-7"></div>

                <!--begin::Notice-->
                <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed p-6">
                    <i class="ki-duotone ki-information-5 fs-2tx text-warning me-4">
                        <span class="path1"></span>
                        <span class="path2"></span>
                        <span class="path3"></span>
                    </i>
                    <div class="d-flex flex-stack flex-grow-1">
                        <div class="fw-semibold">
                            <h4 class="text-gray-900 fw-bold">Notice</h4>
                            <div class="fs-6 text-gray-700">
                                Bài thi của bạn đã được gửi đến hội đồng.
                                Kết quả sẽ được thông báo sau.
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Notice-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Exam Result Info-->
    </div>
    <!--end::Col-->

    <!--begin::Col-->
    <div class="col-xl-8">
        <!--begin::Answers Review-->
        <div class="card card-flush">
            <!--begin::Card header-->
            <div class="card-header">
                <!--begin::Card title-->
                <div class="card-title">
                    <h3 class="fw-bold">Xem lại bài làm</h3>
                </div>
                <!--end::Card title-->
            </div>
            <!--end::Card header-->

            <!--begin::Card body-->
            <div class="card-body">
                @foreach($exam->examQuestions as $index => $examQuestion)
                    @php
                        $question = $examQuestion->question;
                        $answer = $answers[$question->id] ?? '';
                        $examAnswer = $examAnswers[$question->id] ?? null;
                    @endphp

                    <!--begin::Question Review-->
                    <div class="question-review border rounded p-6 mb-6">
                        <!--begin::Question Header-->
                        <div class="d-flex align-items-center mb-5">
                            <span class="badge badge-primary badge-lg me-4">Câu {{ $examQuestion->order_number }}</span>
                            {{-- <h4 class="fw-bold text-gray-800 mb-0">{{ $question->title }}</h4> --}}
                            @if($question->category)
                                <span class="badge badge-light-info ms-3">{{ $question->category }}</span>
                            @endif
                        </div>
                        <!--end::Question Header-->

                        <!--begin::Question Content-->
                        <div class="bg-light-info rounded p-5 mb-5">
                            <div class="text-gray-800 fw-semibold">
                                {!! nl2br(e($question->content)) !!}
                            </div>
                        </div>
                        <!--end::Question Content-->

                        <!--begin::Your Answer-->
                        <div class="mt-5">
                            <div class="d-flex align-items-center mb-3">
                                <i class="ki-duotone ki-pencil fs-4 text-primary me-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                <h5 class="fw-bold text-gray-800 mb-0">Câu trả lời của bạn:</h5>
                            </div>

                            @if($answer)
                                <div class="bg-light-success rounded p-5">
                                    <div class="text-gray-800">
                                        {!! nl2br(e($answer)) !!}
                                    </div>
                                </div>
                            @else
                                <div class="bg-light-danger rounded p-5">
                                    <div class="text-gray-600 text-center">
                                        <i class="ki-duotone ki-information-4 fs-2 text-danger me-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>
                                        Bạn chưa trả lời câu hỏi này
                                    </div>
                                </div>
                            @endif
                        </div>
                        <!--end::Your Answer-->

                        <!--begin::Grade Section-->
                        {{-- <div class="mt-5">
                            @if($examAnswer && $examAnswer->isGraded())
                                <div class="alert alert-success d-flex align-items-center">
                                    <i class="ki-duotone ki-medal-star fs-2 text-success me-3">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                    </i>
                                    <div>
                                        <strong>Điểm:</strong> {{ $examAnswer->score_text }}<br>
                                        @if($examAnswer->feedback)
                                            <strong>Nhận xét:</strong> {{ $examAnswer->feedback }}
                                        @else
                                            <strong>Nhận xét:</strong> Chưa có nhận xét
                                        @endif
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-info d-flex align-items-center">
                                    <i class="ki-duotone ki-information-5 fs-2 text-info me-3">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i>
                                    <div>
                                        <strong>Điểm:</strong> Chưa chấm<br>
                                        <strong>Nhận xét:</strong> Giáo viên sẽ chấm điểm và nhận xét sau
                                    </div>
                                </div>
                            @endif
                        </div> --}}
                        <!--end::Grade Section-->
                    </div>
                    <!--end::Question Review-->
                @endforeach

                <!--begin::Actions-->
                <div class="text-center pt-10">
                    <a href="{{ route('student.exams') }}" class="btn btn-primary">
                        <i class="ki-duotone ki-arrow-left fs-4 me-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        Quay lại danh sách thi
                    </a>
                </div>
                <!--end::Actions-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Answers Review-->
    </div>
    <!--end::Col-->
</div>
<!--end::Row-->
@endsection
