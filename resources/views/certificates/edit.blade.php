@extends('layouts.app')

@section('title', 'Edit Certificate - Portfolio Manager')

@section('content')
<div class="row">
    <div class="col-12 col-lg-8 mx-auto">
        <div class="card-custom p-4">
            <div class="d-flex align-items-center justify-content-between mb-4 pb-2 border-bottom">
                <h4 class="fw-bold mb-0 text-main"><i class="fa-solid fa-pen text-warning me-2"></i> Edit Certificate</h4>
                <a href="{{ route('certificates.index') }}" class="btn btn-outline-secondary btn-sm">Cancel</a>
            </div>

            <form action="{{ route('certificates.update', $certificate->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold">Certificate Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" value="{{ $certificate->title }}" required>
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold">Issuing Institution <span class="text-danger">*</span></label>
                        <input type="text" name="institution" class="form-control" value="{{ $certificate->institution }}" required>
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold">Certificate Number / ID</label>
                        <input type="text" name="certificate_number" class="form-control" value="{{ $certificate->certificate_number }}">
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold">Replace File (Optional)</label>
                        <input type="file" name="file" class="form-control" accept="image/*,application/pdf">
                        <small class="text-muted">Leave empty to keep current file. Accepted formats: JPG, PNG, PDF. Max: 4MB.</small>
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold">Issue Date <span class="text-danger">*</span></label>
                        <input type="date" name="issue_date" class="form-control" value="{{ $certificate->issue_date }}" required>
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold">Expiry Date (Optional)</label>
                        <input type="date" name="expiry_date" class="form-control" value="{{ $certificate->expiry_date }}">
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Description</label>
                        <textarea name="description" class="form-control" rows="4">{{ $certificate->description }}</textarea>
                    </div>
                </div>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-primary px-4"><i class="fa-solid fa-floppy-disk me-2"></i> Update Certificate</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
