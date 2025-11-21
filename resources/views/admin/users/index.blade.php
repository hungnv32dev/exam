@extends('layouts.app')

@section('title', 'Quản lý Users')

@section('breadcrumbs')
<li class="breadcrumb-item">
    <span class="bullet bg-gray-400 w-5px h-2px"></span>
</li>
<li class="breadcrumb-item text-muted">
    <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Admin</a>
</li>
<li class="breadcrumb-item text-muted">Quản lý Users</li>
@endsection

@section('content')
<!--begin::Alert-->
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
<!--end::Alert-->

<!--begin::Row-->
<div class="row g-5 g-xl-10">
    <!--begin::Col-->
    <div class="col-xl-12">
        <!--begin::Users Table-->
        <div class="card card-flush">
            <!--begin::Card header-->
            <div class="card-header pt-7">
                <!--begin::Title-->
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-dark">Danh sách người dùng</span>
                    <span class="text-gray-400 mt-1 fw-semibold fs-6">Quản lý tất cả users trong hệ thống</span>
                </h3>
                <!--end::Title-->
                <!--begin::Toolbar-->
                <div class="card-toolbar">
                    <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">
                        <i class="ki-duotone ki-plus fs-3"></i>
                        Thêm User
                    </a>
                </div>
                <!--end::Toolbar-->
            </div>
            <!--end::Card header-->

            <!--begin::Card body-->
            <div class="card-body">
                <!--begin::Search and Filter-->
                <div class="d-flex align-items-center position-relative mb-7">
                    <form method="GET" action="{{ route('admin.users') }}" class="d-flex align-items-center w-100">
                        <!--begin::Search-->
                        <div class="position-relative me-3 flex-grow-1">
                            <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-6 top-50 translate-middle-y">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            <input type="text" name="search" value="{{ request('search') }}"
                                   class="form-control form-control-solid ps-15"
                                   placeholder="Tìm kiếm theo tên hoặc email...">
                        </div>
                        <!--end::Search-->

                        <!--begin::Role Filter-->
                        <select name="role" class="form-select form-select-solid me-3" style="min-width: 150px;">
                            <option value="all" {{ request('role') == 'all' ? 'selected' : '' }}>Tất cả role</option>
                            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="student" {{ request('role') == 'student' ? 'selected' : '' }}>Student</option>
                        </select>
                        <!--end::Role Filter-->

                        <!--begin::Search Button-->
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="ki-duotone ki-magnifier fs-4">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            Tìm kiếm
                        </button>
                        <!--end::Search Button-->

                        <!--begin::Reset Button-->
                        <a href="{{ route('admin.users') }}" class="btn btn-secondary">
                            <i class="ki-duotone ki-arrow-circle-left fs-4">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            Reset
                        </a>
                        <!--end::Reset Button-->
                    </form>
                </div>
                <!--end::Search and Filter-->

                <!--begin::Table-->
                <div class="table-responsive">
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_users_table">
                        <!--begin::Table head-->
                        <thead>
                            <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                <th class="min-w-125px">User</th>
                                <th class="min-w-125px">Email</th>
                                <th class="min-w-125px">Role</th>
                                <th class="min-w-125px">Ngày tạo</th>
                                <th class="text-end min-w-100px">Actions</th>
                            </tr>
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody class="text-gray-600 fw-semibold">
                            @forelse($users as $user)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="symbol symbol-50px symbol-circle me-3">
                                            @if($user->isAdmin())
                                                <span class="symbol-label bg-light-primary">
                                                    <i class="ki-duotone ki-crown fs-2 text-primary">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                </span>
                                            @else
                                                <span class="symbol-label bg-light-success">
                                                    <i class="ki-duotone ki-user fs-2 text-success">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="d-flex flex-column">
                                            <span class="text-gray-800 text-hover-primary mb-1">{{ $user->name }}</span>
{{--                                            @if($user->isStudent())--}}
{{--                                                <span class="text-gray-400">Mã SV: SV{{ str_pad($user->id, 6, '0', STR_PAD_LEFT) }}</span>--}}
{{--                                            @endif--}}
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-gray-600">{{ $user->email }}</span>
                                </td>
                                <td>
                                    @if($user->isAdmin())
                                        <span class="badge badge-primary">Admin</span>
                                    @else
                                        <span class="badge badge-success">Sinh viên</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="text-gray-600">{{ $user->created_at->format('d/m/Y H:i') }}</span>
                                </td>
                                <td class="text-end">
                                    <div class="d-flex justify-content-end flex-shrink-0">
                                        <a href="{{ route('admin.users.show', $user) }}"
                                           class="btn btn-sm btn-light-primary me-2">
                                            <i class="ki-duotone ki-eye fs-4">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                            </i>
                                            Xem
                                        </a>
                                        <a href="{{ route('admin.users.edit', $user) }}"
                                           class="btn btn-sm btn-light-warning me-2">
                                            <i class="ki-duotone ki-pencil fs-4">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                            Sửa
                                        </a>
                                        @if($user->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                              style="display: inline;" onsubmit="return confirm('Bạn có chắc chắn muốn xóa user này?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-light-danger">
                                                <i class="ki-duotone ki-trash fs-4">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                    <span class="path4"></span>
                                                    <span class="path5"></span>
                                                </i>
                                                Xóa
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-10">
                                    <div class="text-gray-600 fw-semibold fs-7 mb-2">Không tìm thấy user nào</div>
                                    <div class="text-gray-400 fw-semibold fs-8">Thử thay đổi bộ lọc hoặc tạo user mới</div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        <!--end::Table body-->
                    </table>
                </div>
                <!--end::Table-->

                <!--begin::Pagination-->
                <div class="d-flex justify-content-center">
                    {{ $users->withQueryString()->links() }}
                </div>
                <!--end::Pagination-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Users Table-->
    </div>
    <!--end::Col-->
</div>
<!--end::Row-->
@endsection
