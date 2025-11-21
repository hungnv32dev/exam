@extends('layouts.app')

@section('title', 'Chi tiết Đợt thi')

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
<li class="breadcrumb-item text-muted">Chi tiết</li>
@endsection

@section('content')
<!--begin::Row-->
<div class="row g-5 g-xl-10">
    <!--begin::Col-->
    <div class="col-xl-4">
        <!--begin::Exam Overview-->
        <div class="card card-flush mb-6 mb-xl-9">
            <!--begin::Card header-->
            <div class="card-header">
                <!--begin::Card title-->
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0">Thông tin Đợt thi</h3>
                </div>
                <!--end::Card title-->
                <!--begin::Action-->
                @if($exam->canBeEdited())
                <a href="{{ route('admin.exams.edit', $exam) }}" class="btn btn-primary align-self-center">Chỉnh sửa</a>
                @endif
                <!--end::Action-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body p-9">
                <!--begin::Exam Info-->
                <div class="d-flex flex-wrap flex-sm-nowrap mb-3">
                    <!--begin::Image-->
                    <div class="me-7 mb-4">
                        <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
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
                            <div class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-{{ $exam->status_badge }} rounded-circle border border-4 border-body h-20px w-20px"></div>
                        </div>
                    </div>
                    <!--end::Image-->
                    <!--begin::Info-->
                    <div class="flex-grow-1">
                        <!--begin::Title-->
                        <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                            <div class="d-flex flex-column">
                                <div class="d-flex align-items-center mb-2">
                                    <a href="#" class="text-gray-900 text-hover-primary fs-2 fw-bold me-1">{{ $exam->name }}</a>
                                </div>
                                <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
                                    <span class="badge badge-{{ $exam->status_badge }} me-2">{{ $exam->status_text }}</span>
                                    <span class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                        <i class="ki-duotone ki-tag fs-4 me-1">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>
                                        {{ $exam->code }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <!--end::Title-->

                        <!--begin::Stats-->
                        <div class="d-flex flex-wrap flex-stack">
                            <div class="d-flex flex-column flex-grow-1 pe-8">
                                <div class="d-flex flex-wrap">
                                    <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                        <div class="d-flex align-items-center">
                                            <i class="ki-duotone ki-questionnaire-tablet fs-3 text-primary me-2">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                            <div class="fs-2 fw-bold">{{ $exam->total_questions }}</div>
                                        </div>
                                        <div class="fw-semibold fs-6 text-gray-400">Câu hỏi</div>
                                    </div>
                                    <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                        <div class="d-flex align-items-center">
                                            <i class="ki-duotone ki-people fs-3 text-success me-2">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                                <span class="path4"></span>
                                                <span class="path5"></span>
                                            </i>
                                            <div class="fs-2 fw-bold">{{ $exam->total_students }}</div>
                                        </div>
                                        <div class="fw-semibold fs-6 text-gray-400">Sinh viên</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Stats-->
                    </div>
                    <!--end::Info-->
                </div>
                <!--end::Exam Info-->

                <!--begin::Details-->
                <div class="d-flex flex-stack fs-4 py-3">
                    <div class="fw-bold rotate collapsible" data-bs-toggle="collapse" href="#kt_exam_view_details" role="button" aria-expanded="false" aria-controls="kt_exam_view_details">Chi tiết
                        <span class="ms-2 rotate-180">
                            <i class="ki-duotone ki-down fs-3"></i>
                        </span>
                    </div>
                </div>
                <div class="separator separator-dashed my-3"></div>
                <div id="kt_exam_view_details" class="collapse show">
                    <div class="pb-5 fs-6">
                        <div class="fw-bold mt-5">Mã đợt thi</div>
                        <div class="text-gray-600">{{ $exam->code }}</div>

                        <div class="fw-bold mt-5">Thời gian làm bài</div>
                        <div class="text-gray-600">{{ $exam->duration_formatted }}</div>

                        <div class="fw-bold mt-5">Thời gian bắt đầu</div>
                        <div class="text-gray-600">{{ $exam->start_time->format('d/m/Y H:i') }}</div>

                        <div class="fw-bold mt-5">Thời gian kết thúc</div>
                        <div class="text-gray-600">{{ $exam->end_time->format('d/m/Y H:i') }}</div>

                        <div class="fw-bold mt-5">Tạo bởi</div>
                        <div class="text-gray-600">
                            <div class="d-flex align-items-center">
                                <div class="symbol symbol-30px symbol-circle me-2">
                                    <span class="symbol-label bg-light-{{ $exam->creator->isAdmin() ? 'primary' : 'success' }}">
                                        <i class="ki-duotone ki-{{ $exam->creator->isAdmin() ? 'crown' : 'user' }} fs-4 text-{{ $exam->creator->isAdmin() ? 'primary' : 'success' }}">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </span>
                                </div>
                                {{ $exam->creator->name }}
                            </div>
                        </div>

                        <div class="fw-bold mt-5">Trạng thái</div>
                        <div class="text-gray-600">
                            <span class="badge badge-{{ $exam->status_badge }}">{{ $exam->status_text }}</span>
                        </div>

                        <div class="fw-bold mt-5">Ngày tạo</div>
                        <div class="text-gray-600">{{ $exam->created_at->format('d/m/Y H:i') }}</div>

                        <div class="fw-bold mt-5">Cập nhật lần cuối</div>
                        <div class="text-gray-600">{{ $exam->updated_at->format('d/m/Y H:i') }}</div>

                        @if($exam->description)
                        <div class="fw-bold mt-5">Mô tả</div>
                        <div class="text-gray-600">{{ $exam->description }}</div>
                        @endif
                    </div>
                </div>
                <!--end::Details-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Exam Overview-->
    </div>
    <!--end::Col-->

    <!--begin::Col-->
    <div class="col-xl-8">
        <!--begin::Questions List-->
        <div class="card card-flush mb-6 mb-xl-9">
            <!--begin::Card header-->
            <div class="card-header mt-6">
                <!--begin::Card title-->
                <div class="card-title flex-column">
                    <h2 class="mb-1">Danh sách câu hỏi ({{ $exam->examQuestions->count() }})</h2>
                    <div class="fs-6 fw-semibold text-muted">Câu hỏi được sắp xếp theo thứ tự làm bài</div>
                </div>
                <!--end::Card title-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body p-9">
                @forelse($exam->examQuestions as $examQuestion)
                <div class="d-flex align-items-center border rounded p-4 mb-4">
                    <!--begin::Order Number-->
                    <div class="me-4">
                        <span class="badge badge-primary badge-lg">{{ $examQuestion->order_number }}</span>
                    </div>
                    <!--end::Order Number-->

                    <!--begin::Question Info-->
                    <div class="flex-grow-1">
                        <div class="d-flex align-items-center mb-2">
                            <h4 class="fw-bold text-gray-800 me-3">{{ $examQuestion->question->title }}</h4>
                            @if($examQuestion->question->category)
                                <span class="badge badge-light-info">{{ $examQuestion->question->category }}</span>
                            @endif
                            @if($examQuestion->question->hasYoutubeVideo())
                                <span class="badge badge-light-danger ms-2">
                                    <i class="ki-duotone ki-youtube fs-4 text-danger me-1">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    Video
                                </span>
                            @endif
                        </div>
                        <div class="text-gray-600 mb-2">{{ Str::limit($examQuestion->question->description, 150) }}</div>
                        <div class="d-flex align-items-center">
                            <span class="badge badge-{{ $examQuestion->question->status_badge }}">{{ $examQuestion->question->status_text }}</span>
                            <span class="text-gray-400 ms-3 fs-7">
                                Tạo bởi: {{ $examQuestion->question->creator->name }}
                            </span>
                        </div>
                    </div>
                    <!--end::Question Info-->

                    <!--begin::Actions-->
                    <div class="ms-3">
                        <a href="{{ route('admin.questions.show', $examQuestion->question) }}"
                           class="btn btn-sm btn-light-primary" target="_blank">
                            <i class="ki-duotone ki-eye fs-4">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                            </i>
                            Xem
                        </a>
                    </div>
                    <!--end::Actions-->
                </div>
                @empty
                <div class="text-center py-10">
                    <div class="text-gray-600 fw-semibold fs-7 mb-2">Chưa có câu hỏi nào</div>
                    <div class="text-gray-400 fw-semibold fs-8">Thêm câu hỏi để sinh viên có thể làm bài</div>
                </div>
                @endforelse
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Questions List-->

        <!--begin::Students List-->
        <div class="card card-flush mb-6 mb-xl-9">
            <!--begin::Card header-->
            <div class="card-header mt-6">
                <!--begin::Card title-->
                <div class="card-title flex-column">
                    <h2 class="mb-1">Danh sách sinh viên ({{ $exam->examStudents->count() }})</h2>
                    <div class="fs-6 fw-semibold text-muted">Sinh viên đã đăng ký tham gia đợt thi</div>
                </div>
                <!--end::Card title-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body p-9">
                @forelse($exam->examStudents as $examStudent)
                <div class="d-flex align-items-center border rounded p-4 mb-4">
                    <!--begin::Student Avatar-->
                    <div class="me-4">
                        <div class="symbol symbol-50px symbol-circle">
                            <span class="symbol-label bg-light-success">
                                <i class="ki-duotone ki-user fs-2 text-success">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </span>
                        </div>
                    </div>
                    <!--end::Student Avatar-->

                    <!--begin::Student Info-->
                    <div class="flex-grow-1">
                        <div class="d-flex align-items-center mb-2">
                            <h4 class="fw-bold text-gray-800 me-3">{{ $examStudent->student->name }}</h4>
                            <span class="badge badge-{{ $examStudent->status_badge }}">{{ $examStudent->status_text }}</span>
                        </div>
                        <div class="text-gray-600 mb-1">{{ $examStudent->student->email }}</div>
                        <div class="text-gray-400 fs-7">
{{--                            Mã SV: SV{{ str_pad($examStudent->student->id, 6, '0', STR_PAD_LEFT) }}--}}
                            @if($examStudent->registered_at)
                             Đăng ký: {{ $examStudent->registered_at->format('d/m/Y H:i') }}
                            @endif
                        </div>

                        @if($examStudent->started_at || $examStudent->submitted_at)
                        <div class="mt-2">
                            @if($examStudent->started_at)
                            <span class="badge badge-light-warning me-2">
                                Bắt đầu: {{ $examStudent->started_at->format('d/m/Y H:i') }}
                            </span>
                            @endif
                            @if($examStudent->submitted_at)
                            <span class="badge badge-light-success">
                                Nộp bài: {{ $examStudent->submitted_at->format('d/m/Y H:i') }}
                            </span>
                            @endif
                        </div>
                        @endif
                    </div>
                    <!--end::Student Info-->
                </div>
                @empty
                <div class="text-center py-10">
                    <div class="text-gray-600 fw-semibold fs-7 mb-2">Chưa có sinh viên nào đăng ký</div>
                    <div class="text-gray-400 fw-semibold fs-8">Thêm sinh viên để họ có thể tham gia thi</div>
                </div>
                @endforelse
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Students List-->

        <!--begin::Actions-->
        <div class="card card-flush">
            <!--begin::Card header-->
            <div class="card-header mt-6">
                <!--begin::Card title-->
                <div class="card-title">
                    <h2>Thao tác</h2>
                </div>
                <!--end::Card title-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body p-9">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex">
                        @if($exam->canBeEdited())
                        <a href="{{ route('admin.exams.edit', $exam) }}" class="btn btn-primary me-3">
                            <i class="ki-duotone ki-pencil fs-4 me-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            Chỉnh sửa Đợt thi
                        </a>
                        @endif

                        <a href="{{ route('admin.exams.index') }}" class="btn btn-light">
                            <i class="ki-duotone ki-arrow-left fs-4 me-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            Quay lại danh sách
                        </a>
                    </div>

                    @if($exam->canBeDeleted())
                    <div>
                        <form action="{{ route('admin.exams.destroy', $exam) }}" method="POST"
                              onsubmit="return confirm('Bạn có chắc chắn muốn xóa đợt thi này? Hành động này không thể hoàn tác!');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="ki-duotone ki-trash fs-4 me-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                    <span class="path4"></span>
                                    <span class="path5"></span>
                                </i>
                                Xóa Đợt thi
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Actions-->
    </div>
    <!--end::Col-->
</div>
<!--end::Row-->
@endsection
