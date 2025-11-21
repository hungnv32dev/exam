@extends('layouts.app')

@section('title', 'Dashboard')

@section('breadcrumbs')
<li class="breadcrumb-item">
    <span class="bullet bg-gray-400 w-5px h-2px"></span>
</li>
<li class="breadcrumb-item text-muted">Dashboard</li>
@endsection

@section('content')
<!--begin::Row-->
<div class="row g-5 g-xl-10 mb-5 mb-xl-10">
    <!--begin::Col-->
    <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10">
        <!--begin::Card widget 20-->
        <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-50 mb-5 mb-xl-10" style="background-color: #F1416C;background-image:url('{{ asset('assets/media/patterns/vector-1.png') }}')">
            <!--begin::Header-->
            <div class="card-header pt-5">
                <!--begin::Title-->
                <div class="card-title d-flex flex-column">
                    <!--begin::Amount-->
                    <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">{{ \App\Models\User::count() }}</span>
                    <!--end::Amount-->
                    <!--begin::Subtitle-->
                    <span class="text-white opacity-75 pt-1 fw-semibold fs-6">Tổng số người dùng</span>
                    <!--end::Subtitle-->
                </div>
                <!--end::Title-->
            </div>
            <!--end::Header-->
            <!--begin::Card body-->
            <div class="card-body d-flex align-items-end pt-0">
                <!--begin::Progress-->
                <div class="d-flex align-items-center flex-column mt-3 w-100">
                    <div class="d-flex justify-content-between w-100 mt-auto mb-2">
                        <span class="fw-bolder fs-6 text-white opacity-75">Hoạt động</span>
                        <span class="fw-bold fs-6 text-white">100%</span>
                    </div>
                    <div class="h-8px mx-3 w-100 bg-white bg-opacity-50 rounded">
                        <div class="bg-white rounded h-8px" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                <!--end::Progress-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card widget 20-->
    </div>
    <!--end::Col-->

    <!--begin::Col-->
    <div class="col-xxl-9">
        <!--begin::Engage widget 10-->
        <div class="card card-flush h-md-100">
            <!--begin::Header-->
            <div class="card-header pt-7">
                <!--begin::Title-->
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-dark">Thông tin tài khoản</span>
                    <span class="text-gray-400 mt-1 fw-semibold fs-6">Thông tin chi tiết về tài khoản đang đăng nhập</span>
                </h3>
                <!--end::Title-->
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body d-flex align-items-end">
                <!--begin::Wrapper-->
                <div class="d-flex align-items-center flex-column mt-3 w-100">
                    <!--begin::Info-->
                    <div class="d-flex justify-content-between w-100 mt-auto mb-2">
                        <span class="fw-bolder fs-6 text-dark">Tên:</span>
                        <span class="fw-bold fs-6 text-gray-800">{{ $user->name }}</span>
                    </div>
                    <!--end::Info-->
                    <!--begin::Info-->
                    <div class="d-flex justify-content-between w-100 mt-auto mb-2">
                        <span class="fw-bolder fs-6 text-dark">Email:</span>
                        <span class="fw-bold fs-6 text-gray-800">{{ $user->email }}</span>
                    </div>
                    <!--end::Info-->
                    <!--begin::Info-->
                    <div class="d-flex justify-content-between w-100 mt-auto mb-2">
                        <span class="fw-bolder fs-6 text-dark">Ngày tạo:</span>
                        <span class="fw-bold fs-6 text-gray-800">{{ $user->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <!--end::Info-->
                    <!--begin::Info-->
                    <div class="d-flex justify-content-between w-100 mt-auto mb-2">
                        <span class="fw-bolder fs-6 text-dark">Lần đăng nhập cuối:</span>
                        <span class="fw-bold fs-6 text-gray-800">{{ now()->format('d/m/Y H:i') }}</span>
                    </div>
                    <!--end::Info-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Body-->
        </div>
        <!--end::Engage widget 10-->
    </div>
    <!--end::Col-->
</div>
<!--end::Row-->

<!--begin::Row-->
<div class="row g-5 g-xl-10">
    <!--begin::Col-->
    <div class="col-xl-12">
        <!--begin::Table Widget 5-->
        <div class="card card-flush h-xl-100">
            <!--begin::Card header-->
            <div class="card-header pt-7">
                <!--begin::Title-->
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-dark">Hoạt động gần đây</span>
                    <span class="text-gray-400 mt-1 fw-semibold fs-6">Nhật ký các hoạt động trong hệ thống</span>
                </h3>
                <!--end::Title-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body">
                <!--begin::Table-->
                <div class="table-responsive">
                    <table class="table align-middle gs-0 gy-3">
                        <!--begin::Table head-->
                        <thead>
                            <tr>
                                <th class="p-0 w-50px"></th>
                                <th class="p-0 min-w-150px"></th>
                                <th class="p-0 min-w-140px"></th>
                                <th class="p-0 min-w-120px"></th>
                            </tr>
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody>
                            <tr>
                                <td>
                                    <div class="symbol symbol-50px me-2">
                                        <span class="symbol-label bg-light-success">
                                            <i class="ki-duotone ki-abstract-26 fs-2x text-success">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    <a href="#" class="text-dark fw-bold text-hover-primary mb-1 fs-6">Đăng nhập thành công</a>
                                    <span class="text-muted fw-semibold d-block">Đăng nhập vào hệ thống</span>
                                </td>
                                <td class="text-end">
                                    <span class="text-muted fw-semibold">{{ now()->format('d/m/Y') }}</span>
                                </td>
                                <td class="text-end">
                                    <span class="badge badge-light-success">Thành công</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="symbol symbol-50px me-2">
                                        <span class="symbol-label bg-light-primary">
                                            <i class="ki-duotone ki-abstract-44 fs-2x text-primary">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    <a href="#" class="text-dark fw-bold text-hover-primary mb-1 fs-6">Truy cập Dashboard</a>
                                    <span class="text-muted fw-semibold d-block">Xem trang chính</span>
                                </td>
                                <td class="text-end">
                                    <span class="text-muted fw-semibold">{{ now()->format('d/m/Y') }}</span>
                                </td>
                                <td class="text-end">
                                    <span class="badge badge-light-primary">Hoạt động</span>
                                </td>
                            </tr>
                        </tbody>
                        <!--end::Table body-->
                    </table>
                </div>
                <!--end::Table-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Table Widget 5-->
    </div>
    <!--end::Col-->
</div>
<!--end::Row-->
@endsection

@push('scripts')
<script>
// Dashboard specific scripts can go here
console.log('Dashboard loaded successfully');
</script>
@endpush
