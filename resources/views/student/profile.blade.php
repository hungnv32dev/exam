@extends('layouts.app')

@section('title', 'Thông tin cá nhân')

@section('breadcrumbs')
<li class="breadcrumb-item">
    <span class="bullet bg-gray-400 w-5px h-2px"></span>
</li>
<li class="breadcrumb-item text-muted">
    <a href="{{ route('student.dashboard') }}" class="text-muted text-hover-primary">Dashboard</a>
</li>
<li class="breadcrumb-item text-muted">Thông tin cá nhân</li>
@endsection

@section('content')
<!--begin::Row-->
<div class="row g-5 g-xl-10">
    <!--begin::Col-->
    <div class="col-xl-4">
        <!--begin::Profile Overview-->
        <div class="card card-flush mb-6 mb-xl-9">
            <!--begin::Card header-->
            <div class="card-header">
                <!--begin::Card title-->
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0">Thông tin cá nhân</h3>
                </div>
                <!--end::Card title-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body p-9">
                <!--begin::Row-->
                <div class="row">
                    <!--begin::Avatar-->
                    <div class="col-12 text-center mb-7">
                        <div class="symbol symbol-100px symbol-circle mx-auto mb-5">
                            @if($user->avatar)
                                <img alt="Avatar" src="{{ $user->avatar }}" class="rounded-circle w-100 h-100" />
                            @else
                                <span class="symbol-label bg-light-primary text-primary fs-1 fw-bold">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </span>
                            @endif
                        </div>
                        <h4 class="fw-bold text-gray-800 mb-1">{{ $user->name }}</h4>
                        @if($user->google_id)
                            <div class="badge badge-light-info">
                                <i class="fab fa-google me-1"></i>
                                Đăng nhập bằng Google
                            </div>
                        @endif
                    </div>
                    <!--end::Avatar-->
                </div>
                <!--end::Row-->
                <!--begin::Row-->
                <div class="row">
                    <!--begin::Label-->
                    <label class="col-lg-4 fw-semibold text-muted">Tên đầy đủ</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8">
                        <span class="fw-bold fs-6 text-gray-800">{{ $user->name }}</span>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Row-->
                <!--begin::Input group-->
                <div class="row my-5">
                    <!--begin::Label-->
                    <label class="col-lg-4 fw-semibold text-muted">Mã sinh viên</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <span class="fw-bold fs-6 text-gray-800">SV{{ str_pad($user->id, 6, '0', STR_PAD_LEFT) }}</span>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="row my-5">
                    <!--begin::Label-->
                    <label class="col-lg-4 fw-semibold text-muted">Email</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 d-flex align-items-center">
                        <span class="fw-bold fs-6 text-gray-800 me-2">{{ $user->email }}</span>
                        <span class="badge badge-success">Đã xác minh</span>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="row my-5">
                    <!--begin::Label-->
                    <label class="col-lg-4 fw-semibold text-muted">Role</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8">
                        <span class="fw-bold fs-6 text-gray-800">{{ ucfirst($user->role) }}</span>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="row my-5">
                    <!--begin::Label-->
                    <label class="col-lg-4 fw-semibold text-muted">Ngày đăng ký</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8">
                        <span class="fw-bold fs-6 text-gray-800">{{ $user->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="row my-5">
                    <!--begin::Label-->
                    <label class="col-lg-4 fw-semibold text-muted">Trạng thái</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8">
                        <span class="badge badge-light-success">Hoạt động</span>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->

                @if($user->google_id)
                <!--begin::Input group-->
                <div class="row my-5">
                    <!--begin::Label-->
                    <label class="col-lg-4 fw-semibold text-muted">Google ID</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 d-flex align-items-center">
                        <span class="fw-bold fs-6 text-gray-800 me-2">{{ $user->google_id }}</span>
                        <span class="badge badge-light-info">
                            <i class="fab fa-google me-1"></i>
                            Liên kết
                        </span>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
                @endif
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Profile Overview-->
    </div>
    <!--end::Col-->

    <!--begin::Col-->
    <div class="col-xl-8">
        <!--begin::Academic Info-->
        <div class="card card-flush mb-6 mb-xl-9">
            <!--begin::Card header-->
            <div class="card-header">
                <!--begin::Card title-->
                <div class="card-title">
                    <h3 class="fw-bold m-0">Thông tin học tập</h3>
                </div>
                <!--end::Card title-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body p-9">
                <!--begin::Row-->
                <div class="row g-5 mb-7">
                    <!--begin::Col-->
                    <div class="col-sm-6">
                        <!--begin::Stat-->
                        <div class="d-flex align-items-center">
                            <i class="ki-duotone ki-book fs-1 text-primary me-3">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                                <span class="path4"></span>
                            </i>
                            <div class="flex-grow-1">
                                <div class="fs-5 fw-bold text-gray-800">0</div>
                                <div class="fs-7 text-muted">Khóa học đã đăng ký</div>
                            </div>
                        </div>
                        <!--end::Stat-->
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-sm-6">
                        <!--begin::Stat-->
                        <div class="d-flex align-items-center">
                            <i class="ki-duotone ki-medal-star fs-1 text-success me-3">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                                <span class="path4"></span>
                            </i>
                            <div class="flex-grow-1">
                                <div class="fs-5 fw-bold text-gray-800">0.00</div>
                                <div class="fs-7 text-muted">Điểm trung bình</div>
                            </div>
                        </div>
                        <!--end::Stat-->
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Row-->

                <!--begin::Separator-->
                <div class="separator my-6"></div>
                <!--end::Separator-->

                <!--begin::Recent Activity-->
                <div class="mb-0">
                    <h5 class="mb-5">Hoạt động gần đây</h5>
                    <div class="d-flex align-items-center mb-5">
                        <span class="bullet bullet-vertical h-30px bg-success"></span>
                        <div class="flex-grow-1 ms-3">
                            <div class="text-gray-800 fw-bold fs-6">Đăng nhập lần đầu</div>
                            <div class="text-muted fs-7">{{ $user->created_at->format('d/m/Y H:i') }}</div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center mb-5">
                        <span class="bullet bullet-vertical h-30px bg-primary"></span>
                        <div class="flex-grow-1 ms-3">
                            <div class="text-gray-800 fw-bold fs-6">Tài khoản được kích hoạt</div>
                            <div class="text-muted fs-7">{{ $user->created_at->format('d/m/Y H:i') }}</div>
                        </div>
                    </div>
                </div>
                <!--end::Recent Activity-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Academic Info-->

        <!--begin::Settings-->
        <div class="card card-flush">
            <!--begin::Card header-->
            <div class="card-header">
                <!--begin::Card title-->
                <div class="card-title">
                    <h3 class="fw-bold m-0">Cài đặt tài khoản</h3>
                </div>
                <!--end::Card title-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body p-9">
                <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed p-6">
                    <i class="ki-duotone ki-information-5 fs-2tx text-warning me-4">
                        <span class="path1"></span>
                        <span class="path2"></span>
                        <span class="path3"></span>
                    </i>
                    <div class="d-flex flex-stack flex-grow-1">
                        <div class="fw-semibold">
                            <h4 class="text-gray-900 fw-bold">Thông báo!</h4>
                            <div class="fs-6 text-gray-700">Để thay đổi thông tin cá nhân, vui lòng liên hệ với quản trị viên hệ thống.</div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Settings-->
    </div>
    <!--end::Col-->
</div>
<!--end::Row-->
@endsection
