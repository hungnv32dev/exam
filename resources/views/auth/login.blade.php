@extends('layouts.auth')

@section('title', 'Đăng Nhập')

@section('body-class', 'bgi-no-repeat bgi-size-cover bgi-position-center')

@section('content')
<!--begin::Authentication - Sign-in -->
<div class="d-flex flex-column flex-lg-row flex-column-fluid">
    <!--begin::Body-->
    <div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12">
        <!--begin::Wrapper-->
        <div class="bg-body d-flex flex-column flex-center rounded-4 w-md-600px p-10">
            <!--begin::Content-->
            <div class="d-flex flex-center flex-column align-items-stretch h-lg-100 w-md-400px">
                <!--begin::Wrapper-->
                <div class="d-flex flex-center flex-column flex-column-fluid pb-15 pb-lg-20">
                    <!--begin::Form-->
                    <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" method="POST" action="{{ route('login') }}">
                        @csrf
                        <!--begin::Heading-->
                        <div class="text-center mb-11">
                            <!--begin::Title-->
                            <h1 class="text-dark fw-bolder mb-3">Đăng Nhập</h1>
                            <!--end::Title-->
                            <!--begin::Subtitle-->
                            <div class="text-gray-500 fw-semibold fs-6">Chào mừng bạn quay trở lại</div>
                            <!--end::Subtitle-->
                        </div>
                        <!--end::Heading-->

                        <!--begin::Google Login-->
                        <div class="row g-3 mb-9">
                            <div class="col-md-12">
                                <a href="{{ route('auth.google') }}" class="btn btn-flex btn-outline btn-text-gray-700 btn-active-color-primary bg-state-light flex-center text-nowrap w-100">
                                    <img alt="Logo" src="https://developers.google.com/identity/images/g-logo.png" class="h-15px me-3" />
                                    Đăng nhập với Google
                                </a>
                            </div>
                        </div>
                        <!--end::Google Login-->

                        <!--begin::Separator-->
                        <div class="separator separator-content my-14">
                            <span class="w-125px text-gray-500 fw-semibold fs-7">Hoặc đăng nhập bằng email</span>
                        </div>
                        <!--end::Separator-->

                        <!--begin::Input group--->
                        <div class="fv-row mb-8">
                            <!--begin::Email-->
                            <input type="text" placeholder="Email" name="email" autocomplete="off"
                                   class="form-control bg-transparent @error('email') is-invalid @enderror"
                                   value="{{ old('email') }}" required autofocus />
                            <!--end::Email-->
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!--end::Input group--->
                        <div class="fv-row mb-3">
                            <!--begin::Password-->
                            <input type="password" placeholder="Mật khẩu" name="password" autocomplete="off"
                                   class="form-control bg-transparent @error('password') is-invalid @enderror" required />
                            <!--end::Password-->
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <!--end::Input group--->

                        <!--begin::Wrapper-->
                        <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
                            <div>
                                <!--begin::Remember-->
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" />
                                    <label class="form-check-label" for="remember">
                                        Ghi nhớ đăng nhập
                                    </label>
                                </div>
                                <!--end::Remember-->
                            </div>
                            <!--begin::Link-->
                            <a href="#" class="link-primary">Quên mật khẩu?</a>
                            <!--end::Link-->
                        </div>
                        <!--end::Wrapper-->

                        <!--begin::Submit button-->
                        <div class="d-grid mb-10">
                            <button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
                                <!--begin::Indicator label-->
                                <span class="indicator-label">Đăng Nhập</span>
                                <!--end::Indicator label-->
                                <!--begin::Indicator progress-->
                                <span class="indicator-progress">Đang xử lý...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                <!--end::Indicator progress-->
                            </button>
                        </div>
                        <!--end::Submit button-->

                        <!--begin::Sign up-->
                        {{-- <div class="text-gray-500 text-center fw-semibold fs-6">
                            <div class="alert alert-info">
                                <strong>Tài khoản Admin:</strong><br>
                                Email: admin@example.com | Password: password<br>
                                Email: admin2@example.com | Password: admin123<br><br>
                                <strong>Tài khoản Sinh viên:</strong><br>
                                Email: student1@example.com | Password: student123<br>
                                Email: student2@example.com | Password: student123<br>
                                Email: test@example.com | Password: test123
                            </div>
                        </div> --}}
                        <!--end::Sign up-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::Body-->

    <!--begin::Aside-->
    <div class="d-flex flex-lg-row-fluid">
        <!--begin::Content-->
        <div class="d-flex flex-column flex-center pb-0 pb-lg-10 p-10 w-100">
            <!--begin::Image-->
            <img class="theme-light-show mx-auto mw-100 w-150px w-lg-300px mb-10 mb-lg-20"
                 src="{{ asset('assets/media/auth/agency.png') }}" alt="" />
            <img class="theme-dark-show mx-auto mw-100 w-150px w-lg-300px mb-10 mb-lg-20"
                 src="{{ asset('assets/media/auth/agency-dark.png') }}" alt="" />
            <!--end::Image-->
            <!--begin::Title-->
            <h1 class="text-gray-800 fs-2qx fw-bold text-center mb-7">
                Hệ thống quản lý thi trực tuyến
            </h1>
            <!--end::Title-->
            <!--begin::Text-->
            {{-- <div class="text-gray-600 fs-base text-center fw-semibold">
                Sử dụng Metronic Theme với Laravel<br>
                Đăng nhập để truy cập hệ thống
            </div> --}}
            <!--end::Text-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Aside-->
</div>
<!--end::Authentication - Sign-in-->
@endsection

@push('scripts')
<script>
document.getElementById('kt_sign_in_form').addEventListener('submit', function(e) {
    const submitButton = document.getElementById('kt_sign_in_submit');
    submitButton.setAttribute('data-kt-indicator', 'on');
    submitButton.disabled = true;
});
</script>
@endpush
