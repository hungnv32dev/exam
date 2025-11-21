@extends('layouts.app')

@section('title', 'Import Users')

@section('breadcrumbs')
<li class="breadcrumb-item">
    <span class="bullet bg-gray-400 w-5px h-2px"></span>
</li>
<li class="breadcrumb-item text-muted">
    <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Admin</a>
</li>
<li class="breadcrumb-item text-muted">Import Users</li>
@endsection

@section('content')
<!--begin::Alert Messages-->
@if(session('success'))
    <div class="alert alert-success d-flex align-items-center p-5 mb-10">
        <i class="ki-duotone ki-shield-tick fs-2hx text-success me-4">
            <span class="path1"></span>
            <span class="path2"></span>
        </i>
        <div class="d-flex flex-column">
            <h4 class="mb-1 text-success">Thành công!</h4>
            <span>{{ session('success') }}</span>
        </div>
    </div>
@endif

@if(session('warning'))
    <div class="alert alert-warning d-flex align-items-center p-5 mb-10">
        <i class="ki-duotone ki-information-5 fs-2hx text-warning me-4">
            <span class="path1"></span>
            <span class="path2"></span>
            <span class="path3"></span>
        </i>
        <div class="d-flex flex-column">
            <h4 class="mb-1 text-warning">Cảnh báo!</h4>
            <span>{{ session('warning') }}</span>
        </div>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger d-flex align-items-center p-5 mb-10">
        <i class="ki-duotone ki-shield-cross fs-2hx text-danger me-4">
            <span class="path1"></span>
            <span class="path2"></span>
        </i>
        <div class="d-flex flex-column">
            <h4 class="mb-1 text-danger">Lỗi!</h4>
            <span>{{ session('error') }}</span>
        </div>
    </div>
@endif
<!--end::Alert Messages-->

<!--begin::Row-->
<div class="row g-5 g-xl-10">
    <!--begin::Col-->
    <div class="col-xl-12">
        <!--begin::Import Card-->
        <div class="card card-flush">
            <!--begin::Card header-->
            <div class="card-header pt-7">
                <!--begin::Title-->
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-dark">Import Danh sách Users</span>
                    <span class="text-gray-400 mt-1 fw-semibold fs-6">Tải lên file Excel để thêm nhiều users cùng lúc</span>
                </h3>
                <!--end::Title-->
                <!--begin::Toolbar-->
                <div class="card-toolbar">
                    <a href="{{ route('admin.import.users.template') }}" class="btn btn-success btn-sm">
                        <i class="ki-duotone ki-cloud-download fs-3">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        Tải Template Excel
                    </a>
                </div>
                <!--end::Toolbar-->
            </div>
            <!--end::Card header-->

            <!--begin::Card body-->
            <div class="card-body">
                <!--begin::Import Instructions-->
                <div class="alert alert-primary d-flex align-items-center p-5 mb-10">
                    <i class="ki-duotone ki-information-5 fs-2hx text-primary me-4">
                        <span class="path1"></span>
                        <span class="path2"></span>
                        <span class="path3"></span>
                    </i>
                    <div class="d-flex flex-column">
                        <h4 class="mb-1 text-primary">Hướng dẫn Import</h4>
                        <span>
                            <strong>Bước 1:</strong> Tải template Excel về bằng nút "Tải Template Excel"<br>
                            <strong>Bước 2:</strong> Điền thông tin users vào file Excel<br>
                            <strong>Bước 3:</strong> Upload file Excel đã điền để import<br><br>
                            <strong>Cột bắt buộc:</strong> email<br>
                            <strong>Cột tùy chọn:</strong> name, password (mặc định: password123), role (mặc định: student)
                        </span>
                    </div>
                </div>
                <!--end::Import Instructions-->

                <!--begin::Import Form-->
                <form action="{{ route('admin.import.users.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-10">
                                <label for="file" class="form-label required">Chọn file Excel/CSV</label>
                                <input type="file"
                                       class="form-control form-control-solid @error('file') is-invalid @enderror"
                                       id="file"
                                       name="file"
                                       accept=".xlsx,.xls,.csv">
                                @error('file')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Chấp nhận file Excel (.xlsx, .xls) và CSV. Tối đa 2MB.</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ki-duotone ki-cloud-add fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    Import Users
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
                <!--end::Import Form-->

                <!--begin::Import Errors-->
                @if(session('import_errors'))
                    <div class="mt-10">
                        <h4 class="text-danger mb-5">Chi tiết lỗi import:</h4>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Dòng</th>
                                        <th>Lỗi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(session('import_errors') as $error)
                                        <tr>
                                            <td>{{ $error['row'] }}</td>
                                            <td class="text-danger">{{ $error['error'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
                <!--end::Import Errors-->

                <!--begin::Sample Data Format-->
                <div class="mt-10">
                    <h4 class="mb-5">Định dạng dữ liệu mẫu:</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>name</th>
                                    <th>email</th>
                                    <th>password</th>
                                    <th>role</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Nguyễn Văn A</td>
                                    <td>student1@example.com</td>
                                    <td>password123</td>
                                    <td>student</td>
                                </tr>
                                <tr>
                                    <td>Trần Thị B</td>
                                    <td>student2@example.com</td>
                                    <td>password123</td>
                                    <td>student</td>
                                </tr>
                                <tr>
                                    <td>Lê Văn C</td>
                                    <td>admin1@example.com</td>
                                    <td>password123</td>
                                    <td>admin</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="alert alert-info mt-5">
                        <i class="ki-duotone ki-information-4 fs-2 text-info me-3">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                        </i>
                        <strong>Lưu ý:</strong>
                        <ul class="mb-0 mt-2">
                            <li>Email là trường bắt buộc và phải duy nhất</li>
                            <li>Nếu không điền password, hệ thống sẽ tự động gán password123</li>
                            <li>Nếu không điền role, mặc định là student</li>
                            <li>Role chỉ chấp nhận: admin hoặc student</li>
                        </ul>
                    </div>
                </div>
                <!--end::Sample Data Format-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Import Card-->
    </div>
    <!--end::Col-->
</div>
<!--end::Row-->
@endsection
