@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('breadcrumbs')
<li class="breadcrumb-item">
    <span class="bullet bg-gray-400 w-5px h-2px"></span>
</li>
<li class="breadcrumb-item text-muted">Admin Dashboard</li>
@endsection

@section('content')
<!--begin::Row-->
<div class="row g-5 g-xl-10 mb-5 mb-xl-10">
    <!--begin::Col-->
    <div class="col-md-6 col-lg-6 col-xl-3">
        <!--begin::Card widget 20-->
        <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-50 mb-5 mb-xl-10" style="background-color: #F1416C;background-image:url('{{ asset('assets/media/patterns/vector-1.png') }}')">
            <!--begin::Header-->
            <div class="card-header pt-5">
                <!--begin::Title-->
                <div class="card-title d-flex flex-column">
                    <!--begin::Amount-->
                    <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">{{ $totalUsers }}</span>
                    <!--end::Amount-->
                    <!--begin::Subtitle-->
                    <span class="text-white opacity-75 pt-1 fw-semibold fs-6">Tổng số người dùng</span>
                    <!--end::Subtitle-->
                </div>
                <!--end::Title-->
            </div>
            <!--end::Header-->
        </div>
        <!--end::Card widget 20-->
    </div>
    <!--end::Col-->

    <!--begin::Col-->
    <div class="col-md-6 col-lg-6 col-xl-3">
        <!--begin::Card widget 20-->
        <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-50 mb-5 mb-xl-10" style="background-color: #7239EA;background-image:url('{{ asset('assets/media/patterns/vector-1.png') }}')">
            <!--begin::Header-->
            <div class="card-header pt-5">
                <!--begin::Title-->
                <div class="card-title d-flex flex-column">
                    <!--begin::Amount-->
                    <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">{{ $totalAdmins }}</span>
                    <!--end::Amount-->
                    <!--begin::Subtitle-->
                    <span class="text-white opacity-75 pt-1 fw-semibold fs-6">Admin</span>
                    <!--end::Subtitle-->
                </div>
                <!--end::Title-->
            </div>
            <!--end::Header-->
        </div>
        <!--end::Card widget 20-->
    </div>
    <!--end::Col-->

    <!--begin::Col-->
    <div class="col-md-6 col-lg-6 col-xl-3">
        <!--begin::Card widget 20-->
        <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-50 mb-5 mb-xl-10" style="background-color: #50CD89;background-image:url('{{ asset('assets/media/patterns/vector-1.png') }}')">
            <!--begin::Header-->
            <div class="card-header pt-5">
                <!--begin::Title-->
                <div class="card-title d-flex flex-column">
                    <!--begin::Amount-->
                    <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">{{ $totalStudents }}</span>
                    <!--end::Amount-->
                    <!--begin::Subtitle-->
                    <span class="text-white opacity-75 pt-1 fw-semibold fs-6">Sinh viên</span>
                    <!--end::Subtitle-->
                </div>
                <!--end::Title-->
            </div>
            <!--end::Header-->
        </div>
        <!--end::Card widget 20-->
    </div>
    <!--end::Col-->

    <!--begin::Col-->
    <div class="col-md-6 col-lg-6 col-xl-3">
        <!--begin::Card widget 20-->
        <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-50 mb-5 mb-xl-10" style="background-color: #F6C000;background-image:url('{{ asset('assets/media/patterns/vector-1.png') }}')">
            <!--begin::Header-->
            <div class="card-header pt-5">
                <!--begin::Title-->
                <div class="card-title d-flex flex-column">
                    <!--begin::Amount-->
                    <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">100%</span>
                    <!--end::Amount-->
                    <!--begin::Subtitle-->
                    <span class="text-white opacity-75 pt-1 fw-semibold fs-6">Hệ thống hoạt động</span>
                    <!--end::Subtitle-->
                </div>
                <!--end::Title-->
            </div>
            <!--end::Header-->
        </div>
        <!--end::Card widget 20-->
    </div>
    <!--end::Col-->
</div>
<!--end::Row-->

<!--begin::Row-->
<div class="row g-5 g-xl-10">
    <!--begin::Col-->
    <div class="col-xl-6">
        <!--begin::Thông tin admin-->
        <div class="card card-flush h-xl-100">
            <!--begin::Header-->
            <div class="card-header pt-7">
                <!--begin::Title-->
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-dark">Thông tin Admin</span>
                    <span class="text-gray-400 mt-1 fw-semibold fs-6">Chi tiết tài khoản quản trị</span>
                </h3>
                <!--end::Title-->
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body">
                <div class="d-flex align-items-center mb-5">
                    <div class="symbol symbol-50px me-5">
                        <span class="symbol-label bg-light-primary">
                            <i class="ki-duotone ki-crown fs-2x text-primary">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </span>
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between w-100 mb-2">
                            <span class="fw-bolder fs-6 text-dark">Tên:</span>
                            <span class="fw-bold fs-6 text-gray-800">{{ $user->name }}</span>
                        </div>
                        <div class="d-flex justify-content-between w-100 mb-2">
                            <span class="fw-bolder fs-6 text-dark">Email:</span>
                            <span class="fw-bold fs-6 text-gray-800">{{ $user->email }}</span>
                        </div>
                        <div class="d-flex justify-content-between w-100 mb-2">
                            <span class="fw-bolder fs-6 text-dark">Role:</span>
                            <span class="badge badge-light-primary">{{ ucfirst($user->role) }}</span>
                        </div>
                        <div class="d-flex justify-content-between w-100">
                            <span class="fw-bolder fs-6 text-dark">Ngày tạo:</span>
                            <span class="fw-bold fs-6 text-gray-800">{{ $user->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Body-->
        </div>
        <!--end::Thông tin admin-->
    </div>
    <!--end::Col-->

    <!--begin::Col-->
    <div class="col-xl-6">
        <!--begin::Users mới-->
        <div class="card card-flush h-xl-100">
            <!--begin::Header-->
            <div class="card-header pt-7">
                <!--begin::Title-->
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-dark">Người dùng mới</span>
                    <span class="text-gray-400 mt-1 fw-semibold fs-6">5 người dùng đăng ký gần đây</span>
                </h3>
                <!--end::Title-->
                <!--begin::Toolbar-->
                <div class="card-toolbar">
                    <a href="{{ route('admin.users') }}" class="btn btn-sm btn-light">Xem tất cả</a>
                </div>
                <!--end::Toolbar-->
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body pt-5">
                @foreach($recentUsers as $recentUser)
                <div class="d-flex align-items-center mb-5">
                    <div class="symbol symbol-40px me-4">
                        <span class="symbol-label bg-light-{{ $recentUser->isAdmin() ? 'primary' : 'success' }}">
                            <i class="ki-duotone ki-{{ $recentUser->isAdmin() ? 'crown' : 'user' }} fs-2 text-{{ $recentUser->isAdmin() ? 'primary' : 'success' }}">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </span>
                    </div>
                    <div class="flex-grow-1">
                        <a href="#" class="text-dark fw-bold text-hover-primary fs-6">{{ $recentUser->name }}</a>
                        <span class="text-muted fw-semibold d-block">{{ $recentUser->email }}</span>
                    </div>
                    <span class="badge badge-light-{{ $recentUser->isAdmin() ? 'primary' : 'success' }}">{{ ucfirst($recentUser->role) }}</span>
                </div>
                @endforeach
            </div>
            <!--end::Body-->
        </div>
        <!--end::Users mới-->
    </div>
    <!--end::Col-->
</div>
<!--end::Row-->
@endsection
