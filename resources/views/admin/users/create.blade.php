@extends('layouts.app')

@section('title', 'Thêm User Mới')

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
<li class="breadcrumb-item text-muted">Thêm mới</li>
@endsection

@section('content')
<!--begin::Row-->
<div class="row g-5 g-xl-10">
    <!--begin::Col-->
    <div class="col-xl-12">
        <!--begin::Create User Form-->
        <div class="card card-flush">
            <!--begin::Card header-->
            <div class="card-header">
                <!--begin::Card title-->
                <div class="card-title">
                    <h2>Thêm User Mới</h2>
                </div>
                <!--end::Card title-->
            </div>
            <!--end::Card header-->

            <!--begin::Card body-->
            <div class="card-body pt-7">
                <form method="POST" action="{{ route('admin.users.store') }}" class="form">
                    @csrf

                    <!--begin::Input group-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <div class="col-lg-4 d-flex align-items-center">
                            <label class="required fw-semibold fs-6 mb-2">Họ và tên</label>
                        </div>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <input type="text" name="name" value="{{ old('name') }}"
                                   class="form-control form-control-solid @error('name') is-invalid @enderror"
                                   placeholder="Nhập họ và tên..." required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <div class="col-lg-4 d-flex align-items-center">
                            <label class="required fw-semibold fs-6 mb-2">Email</label>
                        </div>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <input type="email" name="email" value="{{ old('email') }}"
                                   class="form-control form-control-solid @error('email') is-invalid @enderror"
                                   placeholder="Nhập địa chỉ email..." required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <div class="col-lg-4 d-flex align-items-center">
                            <label class="required fw-semibold fs-6 mb-2">Role</label>
                        </div>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <select name="role" class="form-select form-select-solid @error('role') is-invalid @enderror" required>
                                <option value="">Chọn role...</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>Student</option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <div class="col-lg-4 d-flex align-items-center">
                            <label class="required fw-semibold fs-6 mb-2">Mật khẩu</label>
                        </div>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <input type="password" name="password"
                                   class="form-control form-control-solid @error('password') is-invalid @enderror"
                                   placeholder="Nhập mật khẩu..." required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <div class="col-lg-4 d-flex align-items-center">
                            <label class="required fw-semibold fs-6 mb-2">Xác nhận mật khẩu</label>
                        </div>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <input type="password" name="password_confirmation"
                                   class="form-control form-control-solid"
                                   placeholder="Nhập lại mật khẩu..." required>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Actions-->
                    <div class="text-center pt-15">
                        <button type="reset" class="btn btn-light me-3">
                            <i class="ki-duotone ki-arrow-left fs-3">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            Hủy bỏ
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <span class="indicator-label">
                                <i class="ki-duotone ki-check fs-3">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                Tạo User
                            </span>
                            <span class="indicator-progress">Đang xử lý...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                    </div>
                    <!--end::Actions-->
                </form>
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Create User Form-->
    </div>
    <!--end::Col-->
</div>
<!--end::Row-->
@endsection

@push('scripts')
<script>
document.querySelector('form').addEventListener('submit', function(e) {
    const submitButton = this.querySelector('button[type="submit"]');
    submitButton.setAttribute('data-kt-indicator', 'on');
    submitButton.disabled = true;
});
</script>
@endpush
