@extends('layouts.app')

@section('title', 'Quản lý Đợt thi')

@section('breadcrumbs')
<li class="breadcrumb-item">
    <span class="bullet bg-gray-400 w-5px h-2px"></span>
</li>
<li class="breadcrumb-item text-muted">
    <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Admin</a>
</li>
<li class="breadcrumb-item text-muted">Quản lý Đợt thi</li>
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
        <!--begin::Exams Table-->
        <div class="card card-flush">
            <!--begin::Card header-->
            <div class="card-header pt-7">
                <!--begin::Title-->
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-dark">Danh sách đợt thi</span>
                    <span class="text-gray-400 mt-1 fw-semibold fs-6">Quản lý tất cả đợt thi trong hệ thống</span>
                </h3>
                <!--end::Title-->
                <!--begin::Toolbar-->
                <div class="card-toolbar">
                    <a href="{{ route('admin.exams.create') }}" class="btn btn-primary btn-sm">
                        <i class="ki-duotone ki-plus fs-3"></i>
                        Thêm Đợt thi
                    </a>
                </div>
                <!--end::Toolbar-->
            </div>
            <!--end::Card header-->

            <!--begin::Card body-->
            <div class="card-body">
                <!--begin::Search and Filter-->
                <div class="d-flex align-items-center position-relative mb-7">
                    <form method="GET" action="{{ route('admin.exams.index') }}" class="d-flex align-items-center w-100">
                        <!--begin::Search-->
                        <div class="position-relative me-3 flex-grow-1">
                            <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-6 top-50 translate-middle-y">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            <input type="text" name="search" value="{{ request('search') }}"
                                   class="form-control form-control-solid ps-15"
                                   placeholder="Tìm kiếm theo tên, mã đợt thi...">
                        </div>
                        <!--end::Search-->

                        <!--begin::Status Filter-->
                        <select name="status" class="form-select form-select-solid me-3" style="min-width: 150px;">
                            <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Tất cả trạng thái</option>
                            <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Bản nháp</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Đang hoạt động</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Đã hoàn thành</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                        </select>
                        <!--end::Status Filter-->

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
                        <a href="{{ route('admin.exams.index') }}" class="btn btn-secondary">
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
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_exams_table">
                        <!--begin::Table head-->
                        <thead>
                            <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                <th class="min-w-200px">Đợt thi</th>
                                <th class="min-w-100px">Thời gian</th>
                                <th class="min-w-100px">Trạng thái</th>
                                <th class="min-w-100px">Câu hỏi</th>
                                <th class="min-w-100px">Sinh viên</th>
                                <th class="min-w-125px">Tạo bởi</th>
                                <th class="min-w-125px">Ngày tạo</th>
                                <th class="text-end min-w-100px">Actions</th>
                            </tr>
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody class="text-gray-600 fw-semibold">
                            @forelse($exams as $exam)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="symbol symbol-50px symbol-circle me-3">
                                            <span class="symbol-label bg-light-primary">
                                                <i class="ki-duotone ki-calendar-8 fs-2 text-primary">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                    <span class="path4"></span>
                                                    <span class="path5"></span>
                                                    <span class="path6"></span>
                                                </i>
                                            </span>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <a href="{{ route('admin.exams.show', $exam) }}" class="text-gray-800 text-hover-primary mb-1 fw-bold">{{ Str::limit($exam->name, 30) }}</a>
                                            <span class="text-gray-400 fs-7">Mã: {{ $exam->code }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="text-gray-600 fw-bold">{{ $exam->duration_formatted }}</span>
                                        <span class="text-gray-400 fs-7">{{ $exam->start_time->format('d/m/Y H:i') }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-{{ $exam->status_badge }}">{{ $exam->status_text }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="ki-duotone ki-questionnaire-tablet fs-4 text-info me-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                        <span class="fw-bold text-gray-600">{{ $exam->total_questions }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="ki-duotone ki-user fs-4 text-success me-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                        <span class="fw-bold text-gray-600">{{ $exam->total_students }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="symbol symbol-30px symbol-circle me-2">
                                            <span class="symbol-label bg-light-{{ $exam->creator->isAdmin() ? 'primary' : 'success' }}">
                                                <i class="ki-duotone ki-{{ $exam->creator->isAdmin() ? 'crown' : 'user' }} fs-4 text-{{ $exam->creator->isAdmin() ? 'primary' : 'success' }}">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                            </span>
                                        </div>
                                        <span class="text-gray-600">{{ $exam->creator->name }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-gray-600">{{ $exam->created_at->format('d/m/Y H:i') }}</span>
                                </td>
                                <td class="text-end">
                                    <div class="d-flex justify-content-end flex-shrink-0">
                                        <a href="{{ route('admin.exams.show', $exam) }}"
                                           class="btn btn-sm btn-light-primary me-2">
                                            <i class="ki-duotone ki-eye fs-4">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                            </i>
                                            Xem
                                        </a>
                                        @if($exam->canBeEdited())
                                        <a href="{{ route('admin.exams.edit', $exam) }}"
                                           class="btn btn-sm btn-light-warning me-2">
                                            <i class="ki-duotone ki-pencil fs-4">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                            Sửa
                                        </a>
                                        @endif
                                        <a href="{{ route('admin.exams.clone', $exam) }}"
                                           class="btn btn-sm btn-light-info me-2"
                                           title="Nhân bản đợt thi">
                                            <i class="ki-duotone ki-copy fs-4">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                            Nhân bản
                                        </a>
                                        @if($exam->canBeDeleted())
                                        <form action="{{ route('admin.exams.destroy', $exam) }}" method="POST"
                                              style="display: inline;" onsubmit="return confirm('Bạn có chắc chắn muốn xóa đợt thi này?');">
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
                                <td colspan="8" class="text-center py-10">
                                    <div class="text-gray-600 fw-semibold fs-7 mb-2">Không tìm thấy đợt thi nào</div>
                                    <div class="text-gray-400 fw-semibold fs-8">Thử thay đổi bộ lọc hoặc tạo đợt thi mới</div>
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
                    {{ $exams->withQueryString()->links() }}
                </div>
                <!--end::Pagination-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Exams Table-->
    </div>
    <!--end::Col-->
</div>
<!--end::Row-->
@endsection
