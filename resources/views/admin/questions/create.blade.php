@extends('layouts.app')

@section('title', 'Thêm Câu hỏi Mới')

@section('breadcrumbs')
<li class="breadcrumb-item">
    <span class="bullet bg-gray-400 w-5px h-2px"></span>
</li>
<li class="breadcrumb-item text-muted">
    <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Admin</a>
</li>
<li class="breadcrumb-item text-muted">
    <a href="{{ route('admin.questions.index') }}" class="text-muted text-hover-primary">Câu hỏi</a>
</li>
<li class="breadcrumb-item text-muted">Thêm mới</li>
@endsection

@section('content')
<!--begin::Row-->
<div class="row g-5 g-xl-10">
    <!--begin::Col-->
    <div class="col-xl-12">
        <!--begin::Create Question Form-->
        <div class="card card-flush">
            <!--begin::Card header-->
            <div class="card-header">
                <!--begin::Card title-->
                <div class="card-title">
                    <h2>Thêm Câu hỏi Mới</h2>
                </div>
                <!--end::Card title-->
            </div>
            <!--end::Card header-->

            <!--begin::Card body-->
            <div class="card-body pt-7">
                <form method="POST" action="{{ route('admin.questions.store') }}" class="form">
                    @csrf

                    <!--begin::Input group-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <div class="col-lg-4 d-flex align-items-center">
                            <label class="required fw-semibold fs-6 mb-2">Tiêu đề câu hỏi</label>
                        </div>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <input type="text" name="title" value="{{ old('title') }}"
                                   class="form-control form-control-solid @error('title') is-invalid @enderror"
                                   placeholder="Nhập tiêu đề câu hỏi..." required>
                            @error('title')
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
                            <label class="required fw-semibold fs-6 mb-2">Mô tả ngắn</label>
                        </div>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <textarea name="description" rows="3"
                                      class="form-control form-control-solid @error('description') is-invalid @enderror"
                                      placeholder="Nhập mô tả ngắn về câu hỏi..." required>{{ old('description') }}</textarea>
                            @error('description')
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
                            <label class="required fw-semibold fs-6 mb-2">Nội dung câu hỏi</label>
                        </div>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <textarea name="content" rows="10"
                                      class="form-control form-control-solid @error('content') is-invalid @enderror"
                                      placeholder="Nhập nội dung chi tiết của câu hỏi..." required>{{ old('content') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Hãy mô tả chi tiết câu hỏi, yêu cầu và hướng dẫn trả lời</div>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <div class="col-lg-4 d-flex align-items-center">
                            <label class="fw-semibold fs-6 mb-2">Link YouTube</label>
                        </div>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <input type="url" name="youtube_url" value="{{ old('youtube_url') }}"
                                   class="form-control form-control-solid @error('youtube_url') is-invalid @enderror"
                                   placeholder="https://www.youtube.com/watch?v=...">
                            @error('youtube_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Nhập link YouTube nếu câu hỏi có video minh họa (tùy chọn)</div>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <div class="col-lg-4 d-flex align-items-center">
                            <label class="fw-semibold fs-6 mb-2">Danh mục</label>
                        </div>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <input type="text" name="category" value="{{ old('category') }}"
                                   class="form-control form-control-solid @error('category') is-invalid @enderror"
                                   placeholder="Ví dụ: Lập trình, Toán học, Khoa học...">
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Phân loại câu hỏi theo chủ đề (tùy chọn)</div>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <div class="col-lg-4 d-flex align-items-center">
                            <label class="required fw-semibold fs-6 mb-2">Trạng thái</label>
                        </div>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <select name="status" class="form-select form-select-solid @error('status') is-invalid @enderror" required>
                                <option value="">Chọn trạng thái...</option>
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Hoạt động</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Không hoạt động</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::YouTube Preview-->
                    <div class="row mb-7" id="youtube-preview" style="display: none;">
                        <div class="col-lg-4"></div>
                        <div class="col-lg-8">
                            <div class="card card-flush bg-light-info">
                                <div class="card-header">
                                    <h3 class="card-title">Xem trước video YouTube</h3>
                                </div>
                                <div class="card-body">
                                    <div class="ratio ratio-16x9">
                                        <iframe id="youtube-iframe" src="" frameborder="0" allowfullscreen></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::YouTube Preview-->

                    <!--begin::Actions-->
                    <div class="text-center pt-15">
                        <a href="{{ route('admin.questions.index') }}" class="btn btn-light me-3">
                            <i class="ki-duotone ki-arrow-left fs-3">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            Quay lại
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <span class="indicator-label">
                                <i class="ki-duotone ki-check fs-3">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                Tạo Câu hỏi
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
        <!--end::Create Question Form-->
    </div>
    <!--end::Col-->
</div>
<!--end::Row-->
@endsection

@push('scripts')
<script>
// YouTube URL validation and preview
function getYouTubeVideoId(url) {
    const regex = /(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/;
    const match = url.match(regex);
    return match ? match[1] : null;
}

document.addEventListener('DOMContentLoaded', function() {
    const youtubeInput = document.querySelector('input[name="youtube_url"]');
    const previewDiv = document.getElementById('youtube-preview');
    const iframe = document.getElementById('youtube-iframe');

    youtubeInput.addEventListener('input', function() {
        const url = this.value.trim();

        if (url) {
            const videoId = getYouTubeVideoId(url);
            if (videoId) {
                iframe.src = `https://www.youtube.com/embed/${videoId}`;
                previewDiv.style.display = 'flex';
            } else {
                previewDiv.style.display = 'none';
            }
        } else {
            previewDiv.style.display = 'none';
        }
    });

    document.querySelector('form').addEventListener('submit', function(e) {
        const submitButton = this.querySelector('button[type="submit"]');
        submitButton.setAttribute('data-kt-indicator', 'on');
        submitButton.disabled = true;
    });
});
</script>
@endpush
