@extends('layouts.app')

@section('title', 'Chi tiết User')

@section('breadcrumbs')
<li class="breadcrumb-item">
    <span class="bullet bg-gray-400 w-5px h-2px"></span>
</li>
<li class="breadcrumb-item text-muted">
    <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Admin</a>
</li>
<li class="breadcrumb-item text-muted">
    <a href="{{ route('admin.users') }}" class="text-muted text-hover-primary">Users</a>
</li>
<li class="breadcrumb-item text-muted">Chi tiết</li>
@endsection

@section('content')
<!--begin::Row-->
<div class="row g-5 g-xl-10">
    <!--begin::Col-->
    <div class="col-xl-4">
        <!--begin::User Overview-->
        <div class="card card-flush mb-6 mb-xl-9">
            <!--begin::Card header-->
            <div class="card-header">
                <!--begin::Card title-->
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0">Thông tin User</h3>
                </div>
                <!--end::Card title-->
                <!--begin::Action-->
                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary align-self-center">Chỉnh sửa</a>
                <!--end::Action-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body p-9">
                <!--begin::User Info-->
                <div class="d-flex flex-wrap flex-sm-nowrap mb-3">
                    <!--begin::Image-->
                    <div class="me-7 mb-4">
                        <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                            @if($user->isAdmin())
                                <span class="symbol-label bg-light-primary">
                                    <i class="ki-duotone ki-crown fs-2x text-primary">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </span>
                            @else
                                <span class="symbol-label bg-light-success">
                                    <i class="ki-duotone ki-user fs-2x text-success">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </span>
                            @endif
                            <div class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle border border-4 border-body h-20px w-20px"></div>
                        </div>
                    </div>
                    <!--end::Image-->
                    <!--begin::Info-->
                    <div class="flex-grow-1">
                        <!--begin::Title-->
                        <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                            <div class="d-flex flex-column">
                                <div class="d-flex align-items-center mb-2">
                                    <a href="#" class="text-gray-900 text-hover-primary fs-2 fw-bold me-1">{{ $user->name }}</a>
                                    @if($user->isAdmin())
                                        <i class="ki-duotone ki-verify fs-1 text-primary">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    @endif
                                </div>
                                <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
                                    @if($user->isAdmin())
                                        <span class="badge badge-primary me-2">Administrator</span>
                                    @else
                                        <span class="badge badge-success me-2">Student</span>
                                    @endif
                                    <span class="d-flex align-items-center text-gray-400 text-hover-primary">
                                        <i class="ki-duotone ki-sms fs-4 me-1">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                        {{ $user->email }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <!--end::Title-->

                        @if($user->isStudent())
                        <!--begin::Stats-->
                        <div class="d-flex flex-wrap flex-stack">
                            <div class="d-flex flex-column flex-grow-1 pe-8">
                                <div class="d-flex flex-wrap">
                                    <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                        <div class="d-flex align-items-center">
                                            <i class="ki-duotone ki-arrow-up fs-3 text-success me-2">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                            <div class="fs-2 fw-bold" data-kt-countup="true" data-kt-countup-value="0">0</div>
                                        </div>
                                        <div class="fw-semibold fs-6 text-gray-400">Khóa học</div>
                                    </div>
                                    <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                        <div class="d-flex align-items-center">
                                            <i class="ki-duotone ki-medal-star fs-3 text-warning me-2">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                                <span class="path4"></span>
                                            </i>
                                            <div class="fs-2 fw-bold">0.0</div>
                                        </div>
                                        <div class="fw-semibold fs-6 text-gray-400">Điểm TB</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Stats-->
                        @endif
                    </div>
                    <!--end::Info-->
                </div>
                <!--end::User Info-->

                <!--begin::Details-->
                <div class="d-flex flex-stack fs-4 py-3">
                    <div class="fw-bold rotate collapsible" data-bs-toggle="collapse" href="#kt_user_view_details" role="button" aria-expanded="false" aria-controls="kt_user_view_details">Chi tiết
                        <span class="ms-2 rotate-180">
                            <i class="ki-duotone ki-down fs-3"></i>
                        </span>
                    </div>
                </div>
                <div class="separator separator-dashed my-3"></div>
                <div id="kt_user_view_details" class="collapse show">
                    <div class="pb-5 fs-6">
                        @if($user->isStudent())
                        <div class="fw-bold mt-5">Mã sinh viên</div>
                        <div class="text-gray-600">SV{{ str_pad($user->id, 6, '0', STR_PAD_LEFT) }}</div>
                        @endif

                        <div class="fw-bold mt-5">User ID</div>
                        <div class="text-gray-600">#{{ $user->id }}</div>

                        <div class="fw-bold mt-5">Email</div>
                        <div class="text-gray-600">
                            <a href="mailto:{{ $user->email }}" class="text-gray-600 text-hover-primary">{{ $user->email }}</a>
                        </div>

                        <div class="fw-bold mt-5">Role</div>
                        <div class="text-gray-600">{{ ucfirst($user->role) }}</div>

                        <div class="fw-bold mt-5">Ngày đăng ký</div>
                        <div class="text-gray-600">{{ $user->created_at->format('d/m/Y H:i') }}</div>

                        <div class="fw-bold mt-5">Cập nhật lần cuối</div>
                        <div class="text-gray-600">{{ $user->updated_at->format('d/m/Y H:i') }}</div>

                        <div class="fw-bold mt-5">Trạng thái tài khoản</div>
                        <div class="text-gray-600">
                            <span class="badge badge-light-success">Hoạt động</span>
                        </div>
                    </div>
                </div>
                <!--end::Details-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::User Overview-->
    </div>
    <!--end::Col-->

    <!--begin::Col-->
    <div class="col-xl-8">
        <!--begin::Activities-->
        <div class="card card-flush mb-6 mb-xl-9">
            <!--begin::Card header-->
            <div class="card-header mt-6">
                <!--begin::Card title-->
                <div class="card-title flex-column">
                    <h2 class="mb-1">Hoạt động của User</h2>
                    <div class="fs-6 fw-semibold text-muted">Lịch sử hoạt động trong hệ thống</div>
                </div>
                <!--end::Card title-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body p-9">
                <!--begin::Timeline-->
                <div class="timeline-label">
                    <!--begin::Item-->
                    <div class="timeline-item">
                        <!--begin::Label-->
                        <div class="timeline-label fw-bold text-gray-800 fs-6">{{ $user->created_at->format('d/m') }}</div>
                        <!--end::Label-->
                        <!--begin::Badge-->
                        <div class="timeline-badge">
                            <i class="ki-duotone ki-abstract-8 text-gray-600 fs-3">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </div>
                        <!--end::Badge-->
                        <!--begin::Text-->
                        <div class="fw-semibold text-gray-700 ps-3">Tài khoản được tạo</div>
                        <!--end::Text-->
                    </div>
                    <!--end::Item-->

                    <!--begin::Item-->
                    <div class="timeline-item">
                        <!--begin::Label-->
                        <div class="timeline-label fw-bold text-gray-800 fs-6">{{ $user->created_at->format('d/m') }}</div>
                        <!--end::Label-->
                        <!--begin::Badge-->
                        <div class="timeline-badge">
                            <i class="ki-duotone ki-verify text-success fs-3">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </div>
                        <!--end::Badge-->
                        <!--begin::Content-->
                        <div class="timeline-content d-flex">
                            <span class="fw-semibold text-gray-700 ps-3">Tài khoản được kích hoạt với role: {{ ucfirst($user->role) }}</span>
                        </div>
                        <!--end::Content-->
                    </div>
                    <!--end::Item-->

                    @if($user->updated_at->ne($user->created_at))
                    <!--begin::Item-->
                    <div class="timeline-item">
                        <!--begin::Label-->
                        <div class="timeline-label fw-bold text-gray-800 fs-6">{{ $user->updated_at->format('d/m') }}</div>
                        <!--end::Label-->
                        <!--begin::Badge-->
                        <div class="timeline-badge">
                            <i class="ki-duotone ki-pencil text-primary fs-3">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </div>
                        <!--end::Badge-->
                        <!--begin::Content-->
                        <div class="timeline-content d-flex">
                            <span class="fw-semibold text-gray-700 ps-3">Thông tin tài khoản được cập nhật</span>
                        </div>
                        <!--end::Content-->
                    </div>
                    <!--end::Item-->
                    @endif
                </div>
                <!--end::Timeline-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Activities-->

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
                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary me-3">
                            <i class="ki-duotone ki-pencil fs-4 me-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            Chỉnh sửa User
                        </a>

                        <a href="{{ route('admin.users') }}" class="btn btn-light">
                            <i class="ki-duotone ki-arrow-left fs-4 me-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            Quay lại danh sách
                        </a>
                    </div>

                    @if($user->id !== auth()->id())
                    <div>
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                              onsubmit="return confirm('Bạn có chắc chắn muốn xóa user này? Hành động này không thể hoàn tác!');">
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
                                Xóa User
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
