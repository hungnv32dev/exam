@extends('layouts.app')

@section('title', 'Chi tiết Đợt thi')

@section('breadcrumbs')
<li class="breadcrumb-item">
    <span class="bullet bg-gray-400 w-5px h-2px"></span>
</li>
<li class="breadcrumb-item text-muted">
    <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Admin</a>
</li>
<li class="breadcrumb-item text-muted">
    <a href="{{ route('admin.exams.index') }}" class="text-muted text-hover-primary">Đợt thi</a>
</li>
<li class="breadcrumb-item text-muted">Chi tiết</li>
@endsection

@section('content')
<!--begin::Row-->
<div class="row g-5 g-xl-10">
    <!--begin::Col-->
    <div class="col-xl-4">
        <!--begin::Exam Overview-->
        <div class="card card-flush mb-6 mb-xl-9">
            <!--begin::Card header-->
            <div class="card-header">
                <!--begin::Card title-->
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0">Thông tin Đợt thi</h3>
                </div>
                <!--end::Card title-->
                <!--begin::Action-->
                @if($exam->canBeEdited())
                <a href="{{ route('admin.exams.edit', $exam) }}" class="btn btn-primary align-self-center">Chỉnh sửa</a>
                @endif
                <!--end::Action-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body p-9">
                <!--begin::Exam Info-->
                <div class="d-flex flex-wrap flex-sm-nowrap mb-3">
                    <!--begin::Image-->
                    <div class="me-7 mb-4">
                        <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                            <span class="symbol-label bg-light-primary">
                                <i class="ki-duotone ki-calendar-8 fs-2x text-primary">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                    <span class="path4"></span>
                                    <span class="path5"></span>
                                    <span class="path6"></span>
                                </i>
                            </span>
                            <div class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-{{ $exam->status_badge }} rounded-circle border border-4 border-body h-20px w-20px"></div>
                        </div>
                    </div>
                    <!--end::Image-->
                    <!--begin::Info-->
                    <div class="flex-grow-1">
                        <!--begin::Title-->
                        <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                            <div class="d-flex flex-column">
                                <div class="d-flex align-items-center mb-2">
                                    <a href="#" class="text-gray-900 text-hover-primary fs-2 fw-bold me-1">{{ $exam->name }}</a>
                                </div>
                                <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
                                    <span class="badge badge-{{ $exam->status_badge }} me-2">{{ $exam->status_text }}</span>
                                    <span class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                        <i class="ki-duotone ki-tag fs-4 me-1">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>
                                        {{ $exam->code }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <!--end::Title-->

                        <!--begin::Stats-->
                        <div class="d-flex flex-wrap flex-stack">
                            <div class="d-flex flex-column flex-grow-1 pe-8">
                                <div class="d-flex flex-wrap">
                                    <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                        <div class="d-flex align-items-center">
                                            <i class="ki-duotone ki-questionnaire-tablet fs-3 text-primary me-2">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                            <div class="fs-2 fw-bold">{{ $exam->total_questions }}</div>
                                        </div>
                                        <div class="fw-semibold fs-6 text-gray-400">Câu hỏi</div>
                                    </div>
                                    <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                        <div class="d-flex align-items-center">
                                            <i class="ki-duotone ki-people fs-3 text-success me-2">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                                <span class="path4"></span>
                                                <span class="path5"></span>
                                            </i>
                                            <div class="fs-2 fw-bold">{{ $exam->total_students }}</div>
                                        </div>
                                        <div class="fw-semibold fs-6 text-gray-400">Sinh viên</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Stats-->
                    </div>
                    <!--end::Info-->
                </div>
                <!--end::Exam Info-->

                <!--begin::Details-->
                <div class="d-flex flex-stack fs-4 py-3">
                    <div class="fw-bold rotate collapsible" data-bs-toggle="collapse" href="#kt_exam_view_details" role="button" aria-expanded="false" aria-controls="kt_exam_view_details">Chi tiết
                        <span class="ms-2 rotate-180">
                            <i class="ki-duotone ki-down fs-3"></i>
                        </span>
                    </div>
                </div>
                <div class="separator separator-dashed my-3"></div>
                <div id="kt_exam_view_details" class="collapse show">
                    <div class="pb-5 fs-6">
                        <div class="fw-bold mt-5">Mã đợt thi</div>
                        <div class="text-gray-600">{{ $exam->code }}</div>

                        <div class="fw-bold mt-5">Thời gian làm bài</div>
                        <div class="text-gray-600">{{ $exam->duration_formatted }}</div>

                        <div class="fw-bold mt-5">Thời gian bắt đầu</div>
                        <div class="text-gray-600">{{ $exam->start_time->format('d/m/Y H:i') }}</div>

                        <div class="fw-bold mt-5">Thời gian kết thúc</div>
                        <div class="text-gray-600">{{ $exam->end_time->format('d/m/Y H:i') }}</div>

                        <div class="fw-bold mt-5">Tạo bởi</div>
                        <div class="text-gray-600">
                            <div class="d-flex align-items-center">
                                <div class="symbol symbol-30px symbol-circle me-2">
                                    <span class="symbol-label bg-light-{{ $exam->creator->isAdmin() ? 'primary' : 'success' }}">
                                        <i class="ki-duotone ki-{{ $exam->creator->isAdmin() ? 'crown' : 'user' }} fs-4 text-{{ $exam->creator->isAdmin() ? 'primary' : 'success' }}">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </span>
                                </div>
                                {{ $exam->creator->name }}
                            </div>
                        </div>

                        <div class="fw-bold mt-5">Trạng thái</div>
                        <div class="text-gray-600">
                            <span class="badge badge-{{ $exam->status_badge }}">{{ $exam->status_text }}</span>
                        </div>

                        <div class="fw-bold mt-5">Ngày tạo</div>
                        <div class="text-gray-600">{{ $exam->created_at->format('d/m/Y H:i') }}</div>

                        <div class="fw-bold mt-5">Cập nhật lần cuối</div>
                        <div class="text-gray-600">{{ $exam->updated_at->format('d/m/Y H:i') }}</div>

                        @if($exam->description)
                        <div class="fw-bold mt-5">Mô tả</div>
                        <div class="text-gray-600">{{ $exam->description }}</div>
                        @endif
                    </div>
                </div>
                <!--end::Details-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Exam Overview-->
    </div>
    <!--end::Col-->

    <!--begin::Col-->
    <div class="col-xl-8">
        <!--begin::Questions List-->
        <div class="card card-flush mb-6 mb-xl-9">
            <!--begin::Card header-->
            <div class="card-header mt-6">
                <!--begin::Card title-->
                <div class="card-title flex-column">
                    <h2 class="mb-1">Danh sách câu hỏi ({{ $exam->examQuestions->count() }})</h2>
                    <div class="fs-6 fw-semibold text-muted">Câu hỏi được sắp xếp theo thứ tự làm bài</div>
                </div>
                <!--end::Card title-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body p-9">
                @forelse($exam->examQuestions as $examQuestion)
                <div class="d-flex align-items-center border rounded p-4 mb-4">
                    <!--begin::Order Number-->
                    <div class="me-4">
                        <span class="badge badge-primary badge-lg">{{ $examQuestion->order_number }}</span>
                    </div>
                    <!--end::Order Number-->

                    <!--begin::Question Info-->
                    <div class="flex-grow-1">
                        <div class="d-flex align-items-center mb-2">
                            <h4 class="fw-bold text-gray-800 me-3">{{ $examQuestion->question->title }}</h4>
                            @if($examQuestion->question->category)
                                <span class="badge badge-light-info">{{ $examQuestion->question->category }}</span>
                            @endif
                            @if($examQuestion->question->hasYoutubeVideo())
                                <span class="badge badge-light-danger ms-2">
                                    <i class="ki-duotone ki-youtube fs-4 text-danger me-1">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    Video
                                </span>
                            @endif
                        </div>
                        <div class="text-gray-600 mb-2">{{ Str::limit($examQuestion->question->description, 150) }}</div>
                        <div class="d-flex align-items-center">
                            <span class="badge badge-{{ $examQuestion->question->status_badge }}">{{ $examQuestion->question->status_text }}</span>
                            <span class="text-gray-400 ms-3 fs-7">
                                Tạo bởi: {{ $examQuestion->question->creator->name }}
                            </span>
                        </div>
                    </div>
                    <!--end::Question Info-->

                    <!--begin::Actions-->
                    <div class="ms-3">
                        <a href="{{ route('admin.questions.show', $examQuestion->question) }}"
                           class="btn btn-sm btn-light-primary" target="_blank">
                            <i class="ki-duotone ki-eye fs-4">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                            </i>
                            Xem
                        </a>
                    </div>
                    <!--end::Actions-->
                </div>
                @empty
                <div class="text-center py-10">
                    <div class="text-gray-600 fw-semibold fs-7 mb-2">Chưa có câu hỏi nào</div>
                    <div class="text-gray-400 fw-semibold fs-8">Thêm câu hỏi để sinh viên có thể làm bài</div>
                </div>
                @endforelse
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Questions List-->

        <!--begin::Students List-->
        <div class="card card-flush mb-6 mb-xl-9">
            <!--begin::Card header-->
            <div class="card-header mt-6">
                <!--begin::Card title-->
                <div class="card-title flex-column">
                    <h2 class="mb-1">Danh sách sinh viên ({{ $exam->examStudents->count() }})</h2>
                    <div class="fs-6 fw-semibold text-muted">Sinh viên đã đăng ký tham gia đợt thi</div>
                </div>
                <!--end::Card title-->
                <!--begin::Card toolbar-->
                @if($exam->canAddStudents())
                <div class="card-toolbar">
                    @if($availableStudents->count() > 0)
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_student_modal">
                        <i class="ki-duotone ki-plus fs-4 me-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        Thêm sinh viên
                    </button>
                    @else
                    <button type="button" class="btn btn-secondary" disabled title="Không còn sinh viên nào có thể thêm">
                        <i class="ki-duotone ki-information fs-4 me-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                        </i>
                        Không có sinh viên khả dụng
                    </button>
                    @endif
                </div>
                @endif
                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body p-9">
                @forelse($exam->examStudents as $examStudent)
                <div class="d-flex align-items-center border rounded p-4 mb-4">
                    <!--begin::Student Avatar-->
                    <div class="me-4">
                        <div class="symbol symbol-50px symbol-circle">
                            <span class="symbol-label bg-light-success">
                                <i class="ki-duotone ki-user fs-2 text-success">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </span>
                        </div>
                    </div>
                    <!--end::Student Avatar-->

                    <!--begin::Student Info-->
                    <div class="flex-grow-1">
                        <div class="d-flex align-items-center mb-2">
                            <h4 class="fw-bold text-gray-800 me-3">{{ $examStudent->student->name }}</h4>
                            <span class="badge badge-{{ $examStudent->status_badge }}">{{ $examStudent->status_text }}</span>
                        </div>
                        <div class="text-gray-600 mb-1">{{ $examStudent->student->email }}</div>
                        <div class="text-gray-400 fs-7">
{{--                            Mã SV: SV{{ str_pad($examStudent->student->id, 6, '0', STR_PAD_LEFT) }}--}}
                            @if($examStudent->registered_at)
                             Đăng ký: {{ $examStudent->registered_at->format('d/m/Y H:i') }}
                            @endif
                        </div>

                        @if($examStudent->started_at || $examStudent->submitted_at)
                        <div class="mt-2">
                            @if($examStudent->started_at)
                            <span class="badge badge-light-warning me-2">
                                Bắt đầu: {{ $examStudent->started_at->format('d/m/Y H:i') }}
                            </span>
                            @endif
                            @if($examStudent->submitted_at)
                            <span class="badge badge-light-success">
                                Nộp bài: {{ $examStudent->submitted_at->format('d/m/Y H:i') }}
                            </span>
                            @endif
                        </div>
                        @endif
                    </div>
                    <!--end::Student Info-->
                </div>
                @empty
                <div class="text-center py-10">
                    <div class="text-gray-600 fw-semibold fs-7 mb-2">Chưa có sinh viên nào đăng ký</div>
                    <div class="text-gray-400 fw-semibold fs-8">Thêm sinh viên để họ có thể tham gia thi</div>
                </div>
                @endforelse
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Students List-->

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
                        @if($exam->canBeEdited())
                        <a href="{{ route('admin.exams.edit', $exam) }}" class="btn btn-primary me-3">
                            <i class="ki-duotone ki-pencil fs-4 me-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            Chỉnh sửa Đợt thi
                        </a>
                        @endif

                        <a href="{{ route('admin.exams.index') }}" class="btn btn-light">
                            <i class="ki-duotone ki-arrow-left fs-4 me-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            Quay lại danh sách
                        </a>
                    </div>

                    @if($exam->canBeDeleted())
                    <div>
                        <form action="{{ route('admin.exams.destroy', $exam) }}" method="POST"
                              onsubmit="return confirm('Bạn có chắc chắn muốn xóa đợt thi này? Hành động này không thể hoàn tác!');">
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
                                Xóa Đợt thi
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

<!--begin::Add Student Modal-->
@if($exam->canAddStudents() && $availableStudents->count() > 0)
<div class="modal fade" id="add_student_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bold">Thêm sinh viên vào đợt thi</h2>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                    <i class="ki-duotone ki-cross fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
            </div>

            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                <form id="add_student_form" action="{{ route('admin.exams.add-students', $exam) }}" method="POST">
                    @csrf
                    
                    <div class="d-flex flex-column scroll-y me-n7 pe-7">
                        <div class="fv-row mb-7">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="required fw-semibold fs-6">Chọn sinh viên</label>
                                <div class="d-flex gap-2 select-all-buttons">
                                    <button type="button" class="btn btn-sm btn-light-primary" id="select_all_students">
                                        <i class="ki-duotone ki-check-square fs-4 me-1">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>
                                        Chọn tất cả
                                    </button>
                                    <button type="button" class="btn btn-sm btn-light-danger" id="deselect_all_students">
                                        <i class="ki-duotone ki-cross-square fs-4 me-1">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                        Bỏ chọn
                                    </button>
                                </div>
                            </div>
                            <select class="form-select form-select-solid" name="student_ids[]" multiple data-control="select2" data-close-on-select="false" data-placeholder="Tìm kiếm và chọn sinh viên..." data-allow-clear="true">
                                @foreach($availableStudents as $student)
                                <option value="{{ $student->id }}">{{ $student->name }} ({{ $student->email }})</option>
                                @endforeach
                            </select>
                            <div class="text-muted fs-7 mt-2">
                                Chỉ hiển thị sinh viên chưa tham gia bất kỳ đợt thi nào. 
                                @if($availableStudents->count() == 0)
                                    <span class="text-warning">Không còn sinh viên nào có thể thêm.</span>
                                @else
                                    <strong>Có {{ $availableStudents->count() }} sinh viên khả dụng.</strong> Sử dụng các nút bên trên để chọn nhanh.
                                @endif
                            </div>
                        </div>

                        <div class="alert alert-info d-flex align-items-center p-5">
                            <i class="ki-duotone ki-information-5 fs-2hx text-info me-4">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                            </i>
                            <div class="d-flex flex-column">
                                <h5 class="mb-1">Lưu ý quan trọng</h5>
                                <span>
                                    <strong>Chính sách hệ thống:</strong> Mỗi sinh viên chỉ được tham gia 1 đợt thi duy nhất.<br>
                                    @if($exam->isOngoing())
                                    Đợt thi đang diễn ra. Sinh viên được thêm sẽ có thể vào làm bài ngay lập tức với thời gian làm bài đầy đủ.
                                    @else
                                    Đợt thi sẽ bắt đầu lúc <strong>{{ $exam->start_time->format('d/m/Y H:i') }}</strong>. Sinh viên được thêm sẽ nhận được thông báo.
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Hủy</button>
                <button type="submit" form="add_student_form" class="btn btn-primary" id="submit_student_btn">
                    <span class="indicator-label">Thêm sinh viên</span>
                    <span class="indicator-progress">Đang xử lý...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
            </div>
        </div>
    </div>
</div>
@endif
<!--end::Add Student Modal-->

@push('scripts')
@if($exam->canAddStudents() && $availableStudents->count() > 0)
<style>
.select-all-buttons .btn {
    transition: all 0.2s ease-in-out;
    font-size: 12px;
}
.select-all-buttons .btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 6px rgba(0,0,0,0.15);
}
.select-all-buttons .btn:disabled {
    opacity: 0.6;
    transform: none;
    box-shadow: none;
}
</style>
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, initializing add student modal');
    
    // Khởi tạo Select2 nếu có jQuery
    let select2Instance = null;
    if (typeof $ !== 'undefined') {
        const selectElement = $('[name="student_ids[]"]');
        if (selectElement.length) {
            select2Instance = selectElement.select2({
                placeholder: 'Tìm kiếm và chọn sinh viên...',
                allowClear: true,
                closeOnSelect: false,
                width: '100%'
            });
            console.log('Select2 initialized');
        }
    }
    
    // Xử lý nút chọn tất cả
    const selectAllBtn = document.getElementById('select_all_students');
    const deselectAllBtn = document.getElementById('deselect_all_students');
    const selectElement = document.querySelector('[name="student_ids[]"]');
    
    if (selectAllBtn && selectElement) {
        selectAllBtn.addEventListener('click', function() {
            console.log('Select all clicked');
            
            // Nếu dùng Select2
            if (select2Instance) {
                const allValues = [];
                selectElement.querySelectorAll('option').forEach(option => {
                    if (option.value) {
                        allValues.push(option.value);
                    }
                });
                select2Instance.val(allValues).trigger('change');
                console.log('Selected all via Select2:', allValues.length, 'items');
            } else {
                // Fallback cho native select
                selectElement.querySelectorAll('option').forEach(option => {
                    option.selected = true;
                });
                console.log('Selected all via native select');
            }
            
            // Cập nhật text của nút
            updateButtonStates();
        });
    }
    
    if (deselectAllBtn && selectElement) {
        deselectAllBtn.addEventListener('click', function() {
            console.log('Deselect all clicked');
            
            // Nếu dùng Select2
            if (select2Instance) {
                select2Instance.val([]).trigger('change');
                console.log('Deselected all via Select2');
            } else {
                // Fallback cho native select
                selectElement.querySelectorAll('option').forEach(option => {
                    option.selected = false;
                });
                console.log('Deselected all via native select');
            }
            
            // Cập nhật text của nút
            updateButtonStates();
        });
    }
    
    // Cập nhật trạng thái nút dựa trên số lượng đã chọn
    function updateButtonStates() {
        if (!selectElement) return;
        
        const selectedCount = selectElement.selectedOptions ? selectElement.selectedOptions.length : 0;
        const totalOptions = selectElement.options.length;
        
        if (selectAllBtn) {
            if (selectedCount === 0) {
                selectAllBtn.innerHTML = `
                    <i class="ki-duotone ki-check-square fs-4 me-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                        <span class="path3"></span>
                    </i>
                    Chọn tất cả (${totalOptions})
                `;
                selectAllBtn.disabled = false;
            } else if (selectedCount === totalOptions) {
                selectAllBtn.innerHTML = `
                    <i class="ki-duotone ki-check fs-4 me-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    Đã chọn hết
                `;
                selectAllBtn.disabled = true;
            } else {
                selectAllBtn.innerHTML = `
                    <i class="ki-duotone ki-check-square fs-4 me-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                        <span class="path3"></span>
                    </i>
                    Chọn tất cả (còn ${totalOptions - selectedCount})
                `;
                selectAllBtn.disabled = false;
            }
        }
        
        if (deselectAllBtn) {
            deselectAllBtn.disabled = selectedCount === 0;
            deselectAllBtn.innerHTML = `
                <i class="ki-duotone ki-cross-square fs-4 me-1">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
                Bỏ chọn${selectedCount > 0 ? ' (' + selectedCount + ')' : ''}
            `;
        }
    }
    
    // Lắng nghe thay đổi từ Select2 hoặc native select
    if (select2Instance) {
        select2Instance.on('change', function() {
            updateButtonStates();
        });
    } else if (selectElement) {
        selectElement.addEventListener('change', function() {
            updateButtonStates();
        });
    }
    
    // Cập nhật trạng thái ban đầu
    setTimeout(updateButtonStates, 100);
    
    const form = document.getElementById('add_student_form');
    const submitBtn = document.getElementById('submit_student_btn');
    
    console.log('Form:', form);
    console.log('Submit button:', submitBtn);
    
    if (!form) {
        console.error('Form not found!');
        return;
    }
    
    if (!submitBtn) {
        console.error('Submit button not found!');
        return;
    }
    
    // Thêm event listener cho submit button
    submitBtn.addEventListener('click', function(e) {
        console.log('Submit button clicked');
        e.preventDefault();
        submitForm();
    });
    
    // Thêm event listener cho form submit
    form.addEventListener('submit', function(e) {
        console.log('Form submit event');
        e.preventDefault();
        submitForm();
    });
    
    function submitForm() {
        console.log('submitForm called');
        
        const formData = new FormData(form);
        const selectedStudents = formData.getAll('student_ids[]');
        
        console.log('Form action:', form.action);
        console.log('Selected students:', selectedStudents);
        console.log('Form data entries:', [...formData.entries()]);
        
        if (selectedStudents.length === 0) {
            alert('Vui lòng chọn ít nhất một sinh viên.');
            return;
        }
        
        // Confirm action với số lượng sinh viên
        const confirmMessage = `Bạn có chắc chắn muốn thêm ${selectedStudents.length} sinh viên vào đợt thi này không?\n\nSau khi thêm, các sinh viên này sẽ có thể tham gia làm bài.`;
        if (!confirm(confirmMessage)) {
            return;
        }
        
        // Show loading state
        submitBtn.setAttribute('data-kt-indicator', 'on');
        submitBtn.disabled = true;
        
        // Submit form using standard form submission (fallback)
        if (false) { // Set to true to test standard form submission
            form.submit();
            return;
        }
        
        // Submit form via AJAX
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            console.log('Response status:', response.status);
            console.log('Response headers:', [...response.headers.entries()]);
            
            if (response.ok) {
                return response.json().catch(() => {
                    // If not JSON, treat as success
                    return { success: true };
                });
            } else {
                return response.text().then(text => {
                    console.log('Error response:', text);
                    throw new Error('Server error (' + response.status + '): ' + text);
                });
            }
        })
        .then(data => {
            console.log('Success response:', data);
            window.location.reload();
        })
        .catch(error => {
            console.error('Fetch error:', error);
            alert('Có lỗi xảy ra: ' + error.message);
            
            // Reset loading state
            submitBtn.removeAttribute('data-kt-indicator');
            submitBtn.disabled = false;
        });
    }
});
</script>
@endif
@endpush
@endsection
