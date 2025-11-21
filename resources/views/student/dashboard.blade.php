@extends('layouts.app')

@section('title', 'Student Dashboard')

@section('breadcrumbs')
<li class="breadcrumb-item">
    <span class="bullet bg-gray-400 w-5px h-2px"></span>
</li>
<li class="breadcrumb-item text-muted">Student Dashboard</li>
@endsection

@section('content')
<!--begin::Row-->
<div class="row g-5 g-xl-10 mb-5 mb-xl-10">
    <!--begin::Col-->
    <div class="col-xl-4">
        <!--begin::Thông tin sinh viên-->
        <div class="card card-flush h-xl-100">
            <!--begin::Header-->
            <div class="card-header pt-7">
                <!--begin::Title-->
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-dark">Thông tin cá nhân</span>
                    <span class="text-gray-400 mt-1 fw-semibold fs-6">Chi tiết tài khoản sinh viên</span>
                </h3>
                <!--end::Title-->
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body">
                <div class="d-flex flex-center flex-column mb-5">
                    <div class="symbol symbol-100px symbol-circle mb-7">

                        @if(Auth::user()->avatar)
                            <img alt="Avatar" src="{{ Auth::user()->avatar }}" class="rounded-circle" />
                        @else
                            <img alt="Default Avatar" src="{{ asset('assets/media/avatars/300-3.jpg') }}" />
                        @endif
                    </div>
                    <a href="#" class="fs-3 text-gray-800 text-hover-primary fw-bold mb-1">{{ $user->name }}</a>
                    <div class="fs-5 fw-semibold text-muted mb-6">{{ $user->email }}</div>
                    <span class="badge badge-light-success d-inline">{{ ucfirst($user->role) }}</span>
                </div>

                <div class="d-flex flex-stack fs-4 py-3">
                    <div class="fw-bold rotate collapsible" data-bs-toggle="collapse" href="#kt_user_view_details" role="button" aria-expanded="false" aria-controls="kt_user_view_details">Chi tiết</div>
                    <span data-bs-toggle="tooltip" data-bs-trigger="hover" title="Chi tiết thông tin tài khoản">
                        <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                        </i>
                    </span>
                </div>

                <div class="separator separator-dashed my-3"></div>

                <div id="kt_user_view_details" class="collapse show">
                    <div class="pb-5 fs-6">
{{--                        <div class="fw-bold mt-5">Mã sinh viên</div>--}}
{{--                        <div class="text-gray-600">SV{{ str_pad($user->id, 6, '0', STR_PAD_LEFT) }}</div>--}}

                        <div class="fw-bold mt-5">Email</div>
                        <div class="text-gray-600">{{ $user->email }}</div>

                        <div class="fw-bold mt-5">Ngày đăng ký</div>
                        <div class="text-gray-600">{{ $user->created_at->format('d/m/Y H:i') }}</div>

                        <div class="fw-bold mt-5">Trạng thái tài khoản</div>
                        <div class="text-gray-600">
                            <span class="badge badge-light-success">Hoạt động</span>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Body-->
        </div>
        <!--end::Thông tin sinh viên-->
    </div>
    <!--end::Col-->

    <!--begin::Col-->
    <div class="col-xl-8">
        <!--begin::Exam Schedule Card-->
        <div class="card card-flush h-xl-100 mb-5 mb-xl-10">
            <!--begin::Header-->
            <div class="card-header pt-7">
                <!--begin::Title-->
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-dark">Lịch thi sắp tới</span>
                    <span class="text-gray-400 mt-1 fw-semibold fs-6">Các kỳ thi sắp diễn ra</span>
                </h3>
                <!--end::Title-->
                <!--begin::Toolbar-->
                <div class="card-toolbar">
                    <a href="{{ route('student.exams') }}" class="btn btn-sm btn-light-primary">
                        <i class="ki-duotone ki-eye fs-3">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                        </i>
                        Xem tất cả
                    </a>
                </div>
                <!--end::Toolbar-->
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body pt-5">
                @if(isset($upcomingExams) && $upcomingExams->count() > 0)
                    @foreach($upcomingExams as $exam)
                    <div class="d-flex align-items-center mb-7">
                        <div class="symbol symbol-50px me-4">
                            <span class="symbol-label bg-light-primary">
                                <i class="ki-duotone ki-document fs-2 text-primary">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </span>
                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-bold text-gray-800 fs-6 mb-1">{{ $exam->title }}</div>
                            <div class="text-gray-600 fw-semibold fs-7 mb-1">
                                <i class="ki-duotone ki-calendar fs-7 me-1">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                {{ \Carbon\Carbon::parse($exam->start_time)->format('d/m/Y H:i') }}
                            </div>
                            <div class="text-gray-400 fw-semibold fs-8">
                                <i class="ki-duotone ki-time fs-8 me-1">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                Thời gian: {{ $exam->duration }} phút
                            </div>
                        </div>
                        @php
                            $examStudent = $exam->examStudents->first();
                            $status = $examStudent ? $examStudent->status : 'registered';
                        @endphp
                        @if($status === 'submitted')
                            <span class="badge badge-light-success">Đã nộp</span>
                        @elseif(\Carbon\Carbon::parse($exam->start_time) <= now())
                            <span class="badge badge-light-warning">Đang thi</span>
                        @else
                            <span class="badge badge-light-info">Sắp thi</span>
                        @endif
                    </div>
                    @if(!$loop->last)
                        <div class="separator separator-dashed"></div>
                    @endif
                    @endforeach
                @else
                    <div class="text-center py-10">
                        <div class="symbol symbol-100px symbol-circle mb-7">
                            <i class="ki-duotone ki-calendar-8 fs-4x text-muted">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                                <span class="path4"></span>
                                <span class="path5"></span>
                                <span class="path6"></span>
                            </i>
                        </div>
                        <div class="text-gray-600 fw-semibold fs-7 mb-2">Chưa có lịch thi</div>
                        <div class="text-gray-400 fw-semibold fs-8">Hiện tại bạn chưa có kỳ thi nào sắp diễn ra</div>
                    </div>
                @endif

                @if(isset($examStats))
                <div class="separator my-6"></div>
                <!--begin::Quick Stats-->
                <div class="row g-5">
                    <div class="col-6">
                        <div class="d-flex align-items-center">
                            <div class="symbol symbol-40px me-3">
                                <span class="symbol-label bg-light-success">
                                    <i class="ki-duotone ki-notebook fs-2 text-success">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </span>
                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-bold text-gray-800 fs-4">{{ $examStats['total_exams'] }}</div>
                                <div class="fw-semibold text-gray-400 fs-7">Đợt thi đã tham gia</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="d-flex align-items-center">
                            <div class="symbol symbol-40px me-3">
                                <span class="symbol-label bg-light-primary">
                                    <i class="ki-duotone ki-medal-star fs-2 text-primary">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                    </i>
                                </span>
                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-bold text-gray-800 fs-4">{{ number_format($examStats['average_score'], 1) }}</div>
                                <div class="fw-semibold text-gray-400 fs-7">Điểm trung bình</div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Quick Stats-->
                @endif
            </div>
            <!--end::Body-->
        </div>
        <!--end::Exam Schedule Card-->
    </div>
    <!--end::Col-->
</div>
<!--end::Row-->

<!--begin::Row-->
<div class="row g-5 g-xl-10">
    <!--begin::Col-->
    <div class="col-xl-6">
        <!--begin::Thông báo-->
        <div class="card card-flush h-xl-100">
            <!--begin::Header-->
            <div class="card-header pt-7">
                <!--begin::Title-->
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-dark">Thông báo</span>
                    <span class="text-gray-400 mt-1 fw-semibold fs-6">Thông báo mới từ hệ thống</span>
                </h3>
                <!--end::Title-->
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body pt-5">
                <div class="d-flex align-items-center mb-5">
                    <div class="symbol symbol-40px me-4">
                        <span class="symbol-label bg-light-primary">
                            <i class="ki-duotone ki-notification-bing fs-2 text-primary">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                            </i>
                        </span>
                    </div>
                    <div class="flex-grow-1">
                        <a href="#" class="text-dark fw-bold text-hover-primary fs-6">Chào mừng bạn đến với hệ thống</a>
                        <span class="text-muted fw-semibold d-block">{{ now()->format('d/m/Y H:i') }}</span>
                    </div>
                    <span class="badge badge-light-primary">Mới</span>
                </div>

                <div class="d-flex align-items-center mb-5">
                    <div class="symbol symbol-40px me-4">
                        <span class="symbol-label bg-light-info">
                            <i class="ki-duotone ki-information-4 fs-2 text-info">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                            </i>
                        </span>
                    </div>
                    <div class="flex-grow-1">
                        <a href="#" class="text-dark fw-bold text-hover-primary fs-6">Hệ thống đã được cập nhật</a>
                        <span class="text-muted fw-semibold d-block">{{ now()->subDays(1)->format('d/m/Y H:i') }}</span>
                    </div>
                    <span class="badge badge-light-info">Thông tin</span>
                </div>
            </div>
            <!--end::Body-->
        </div>
        <!--end::Thông báo-->
    </div>
    <!--end::Col-->

    <!--begin::Col-->
    <div class="col-xl-6">
        <!--begin::Lịch thi hôm nay-->
        <div class="card card-flush h-xl-100">
            <!--begin::Header-->
            <div class="card-header pt-7">
                <!--begin::Title-->
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-dark">Lịch thi hôm nay</span>
                    <span class="text-gray-400 mt-1 fw-semibold fs-6">{{ now()->format('d/m/Y') }}</span>
                </h3>
                <!--end::Title-->
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body pt-5">
                @if(isset($todayExams) && $todayExams->count() > 0)
                    @foreach($todayExams as $exam)
                    <div class="d-flex align-items-center mb-5">
                        <div class="symbol symbol-40px me-4">
                            <span class="symbol-label bg-light-warning">
                                <i class="ki-duotone ki-timer fs-2 text-warning">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                </i>
                            </span>
                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-bold text-gray-800 fs-6 mb-1">{{ $exam->title }}</div>
                            <div class="text-gray-600 fw-semibold fs-7 mb-1">
                                <i class="ki-duotone ki-time fs-7 me-1">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                {{ \Carbon\Carbon::parse($exam->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($exam->start_time)->addMinutes($exam->duration)->format('H:i') }}
                            </div>
                            <div class="text-gray-400 fw-semibold fs-8">
                                Thời gian: {{ $exam->duration }} phút
                            </div>
                        </div>
                        @php
                            $examStudent = $exam->examStudents->first();
                            $status = $examStudent ? $examStudent->status : 'registered';
                            $now = now();
                            $examStart = \Carbon\Carbon::parse($exam->start_time);
                            $examEnd = $examStart->copy()->addMinutes($exam->duration);
                        @endphp
                        @if($status === 'submitted')
                            <span class="badge badge-success">Đã nộp</span>
                        @elseif($now >= $examStart && $now <= $examEnd)
                            <a href="{{ route('student.exam.start', $exam) }}" class="btn btn-sm btn-warning">Vào thi</a>
                        @elseif($now > $examEnd)
                            <span class="badge badge-secondary">Đã kết thúc</span>
                        @else
                            <span class="badge badge-info">Chưa bắt đầu</span>
                        @endif
                    </div>
                    @if(!$loop->last)
                        <div class="separator separator-dashed"></div>
                    @endif
                    @endforeach
                @else
                    <div class="text-center py-10">
                        <div class="symbol symbol-100px symbol-circle mb-7">
                            <i class="ki-duotone ki-calendar-8 fs-4x text-muted">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                                <span class="path4"></span>
                                <span class="path5"></span>
                                <span class="path6"></span>
                            </i>
                        </div>
                        <div class="text-gray-600 fw-semibold fs-7 mb-2">Chưa có lịch thi</div>
                        <div class="text-gray-400 fw-semibold fs-8">Hôm nay bạn không có kỳ thi nào</div>
                    </div>
                @endif
            </div>
            <!--end::Body-->
        </div>
        <!--end::Lịch thi hôm nay-->
    </div>
    <!--end::Col-->
</div>
<!--end::Row-->
@endsection
