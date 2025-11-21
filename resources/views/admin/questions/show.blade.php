@extends('layouts.app')

@section('title', 'Chi tiết Câu hỏi')

@section('breadcrumbs')
<li class="breadcrumb-item">
    <span class="bullet bg-gray-400 w-5px h-2px"></span>
</li>
<li class="breadcrumb-item text-muted">
    <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Admin</a>
</li>
<li class="breadcrumb-item text-muted">
    <a href="{{ route('admin.questions.index') }}" class="text-muted text-hover-primary">Câu hỏi</a>
</li>
<li class="breadcrumb-item text-muted">Chi tiết</li>
@endsection

@section('content')
<!--begin::Row-->
<div class="row g-5 g-xl-10">
    <!--begin::Col-->
    <div class="col-xl-4">
        <!--begin::Question Overview-->
        <div class="card card-flush mb-6 mb-xl-9">
            <!--begin::Card header-->
            <div class="card-header">
                <!--begin::Card title-->
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0">Thông tin Câu hỏi</h3>
                </div>
                <!--end::Card title-->
                <!--begin::Action-->
                <a href="{{ route('admin.questions.edit', $question) }}" class="btn btn-primary align-self-center">Chỉnh sửa</a>
                <!--end::Action-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body p-9">
                <!--begin::Question Info-->
                <div class="d-flex flex-wrap flex-sm-nowrap mb-3">
                    <!--begin::Image-->
                    <div class="me-7 mb-4">
                        <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                            <span class="symbol-label bg-light-primary">
                                <i class="ki-duotone ki-questionnaire-tablet fs-2x text-primary">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </span>
                            <div class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-{{ $question->status_badge }} rounded-circle border border-4 border-body h-20px w-20px"></div>
                        </div>
                    </div>
                    <!--end::Image-->
                    <!--begin::Info-->
                    <div class="flex-grow-1">
                        <!--begin::Title-->
                        <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                            <div class="d-flex flex-column">
                                <div class="d-flex align-items-center mb-2">
                                    <a href="#" class="text-gray-900 text-hover-primary fs-2 fw-bold me-1">{{ $question->title }}</a>
                                </div>
                                <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
                                    <span class="badge badge-{{ $question->status_badge }} me-2">{{ $question->status_text }}</span>
                                    @if($question->category)
                                        <span class="badge badge-light-info me-2">{{ $question->category }}</span>
                                    @endif
                                    @if($question->hasYoutubeVideo())
                                        <span class="badge badge-light-danger">
                                            <i class="ki-duotone ki-youtube fs-4 text-danger me-1">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                            Video
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!--end::Title-->
                    </div>
                    <!--end::Info-->
                </div>
                <!--end::Question Info-->

                <!--begin::Details-->
                <div class="d-flex flex-stack fs-4 py-3">
                    <div class="fw-bold rotate collapsible" data-bs-toggle="collapse" href="#kt_question_view_details" role="button" aria-expanded="false" aria-controls="kt_question_view_details">Chi tiết
                        <span class="ms-2 rotate-180">
                            <i class="ki-duotone ki-down fs-3"></i>
                        </span>
                    </div>
                </div>
                <div class="separator separator-dashed my-3"></div>
                <div id="kt_question_view_details" class="collapse show">
                    <div class="pb-5 fs-6">
                        <div class="fw-bold mt-5">ID Câu hỏi</div>
                        <div class="text-gray-600">#{{ $question->id }}</div>

                        <div class="fw-bold mt-5">Tạo bởi</div>
                        <div class="text-gray-600">
                            <div class="d-flex align-items-center">
                                <div class="symbol symbol-30px symbol-circle me-2">
                                    <span class="symbol-label bg-light-{{ $question->creator->isAdmin() ? 'primary' : 'success' }}">
                                        <i class="ki-duotone ki-{{ $question->creator->isAdmin() ? 'crown' : 'user' }} fs-4 text-{{ $question->creator->isAdmin() ? 'primary' : 'success' }}">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </span>
                                </div>
                                {{ $question->creator->name }}
                            </div>
                        </div>

                        <div class="fw-bold mt-5">Danh mục</div>
                        <div class="text-gray-600">{{ $question->category ?? 'Chưa phân loại' }}</div>

                        <div class="fw-bold mt-5">Trạng thái</div>
                        <div class="text-gray-600">
                            <span class="badge badge-{{ $question->status_badge }}">{{ $question->status_text }}</span>
                        </div>

                        <div class="fw-bold mt-5">Ngày tạo</div>
                        <div class="text-gray-600">{{ $question->created_at->format('d/m/Y H:i') }}</div>

                        <div class="fw-bold mt-5">Cập nhật lần cuối</div>
                        <div class="text-gray-600">{{ $question->updated_at->format('d/m/Y H:i') }}</div>
                    </div>
                </div>
                <!--end::Details-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Question Overview-->
    </div>
    <!--end::Col-->

    <!--begin::Col-->
    <div class="col-xl-8">
        <!--begin::Question Content-->
        <div class="card card-flush mb-6 mb-xl-9">
            <!--begin::Card header-->
            <div class="card-header mt-6">
                <!--begin::Card title-->
                <div class="card-title flex-column">
                    <h2 class="mb-1">{{ $question->title }}</h2>
                    <div class="fs-6 fw-semibold text-muted">{{ $question->description }}</div>
                </div>
                <!--end::Card title-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body p-9">
                <!--begin::Question Content-->
                <div class="fs-6 fw-normal text-gray-700 mb-7">
                    <div class="fw-bold mb-3">Nội dung câu hỏi:</div>
                    <div class="bg-light-info rounded p-5">
                        {!! nl2br(e($question->content)) !!}
                    </div>
                </div>
                <!--end::Question Content-->

                <!--begin::YouTube Video-->
                @if($question->hasYoutubeVideo())
                <div class="mb-7">
                    <div class="fw-bold mb-3">Video hướng dẫn:</div>
                    <div class="card card-flush bg-light-danger">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="ki-duotone ki-youtube fs-2 text-danger me-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                Video YouTube
                            </h3>
                            <div class="card-toolbar">
                                <a href="{{ $question->youtube_url }}" target="_blank" class="btn btn-sm btn-light-danger">
                                    <i class="ki-duotone ki-external-link fs-4">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    Xem trên YouTube
                                </a>
                            </div>
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
                <div class="mb-7">
                    <div class="fw-bold mb-3">Hướng dẫn trả lời:</div>
                    <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed p-6">
                        <i class="ki-duotone ki-information-5 fs-2tx text-warning me-4">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                        </i>
                        <div class="d-flex flex-stack flex-grow-1">
                            <div class="fw-semibold">
                                <h4 class="text-gray-900 fw-bold">Câu hỏi tự luận</h4>
                                <div class="fs-6 text-gray-700">
                                    Sinh viên sẽ trả lời câu hỏi này dưới dạng văn bản tự do.
                                    Không có thời gian giới hạn và không tính điểm tự động.
                                    Giảng viên sẽ chấm điểm và nhận xét sau khi sinh viên nộp bài.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Answer Section-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Question Content-->

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
                        <a href="{{ route('admin.questions.edit', $question) }}" class="btn btn-primary me-3">
                            <i class="ki-duotone ki-pencil fs-4 me-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            Chỉnh sửa Câu hỏi
                        </a>

                        <a href="{{ route('admin.questions.index') }}" class="btn btn-light">
                            <i class="ki-duotone ki-arrow-left fs-4 me-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            Quay lại danh sách
                        </a>
                    </div>

                    <div>
                        <form action="{{ route('admin.questions.destroy', $question) }}" method="POST"
                              onsubmit="return confirm('Bạn có chắc chắn muốn xóa câu hỏi này? Hành động này không thể hoàn tác!');">
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
                                Xóa Câu hỏi
                            </button>
                        </form>
                    </div>
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
