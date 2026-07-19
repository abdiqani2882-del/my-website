@extends('layouts.app')

@section('title', 'Add Certificate - Portfolio Manager')

@section('content')
<div class="row">
    <div class="col-12 col-lg-8 mx-auto">
        <div class="card-custom p-4">
            <div class="d-flex align-items-center justify-content-between mb-4 pb-2 border-bottom">
                <h4 class="fw-bold mb-0 text-main"><i class="fa-solid fa-award text-warning me-2"></i> Add Certificate</h4>
                <a href="{{ route('certificates.index') }}" class="btn btn-outline-secondary btn-sm">Cancel</a>
            </div>

            <form action="{{ route('certificates.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold">Certificate Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" placeholder="e.g. AWS Certified Solutions Architect" value="{{ old('title') }}" required>
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold">Issuing Institution <span class="text-danger">*</span></label>
                        <input type="text" name="institution" class="form-control" placeholder="e.g. Amazon Web Services" value="{{ old('institution') }}" required>
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold">Certificate Number / ID</label>
                        <input type="text" name="certificate_number" class="form-control" placeholder="e.g. AWS-123456" value="{{ old('certificate_number') }}">
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold">Upload Certificate <span class="text-danger">*</span></label>
                        <input type="file" name="file" class="form-control" accept="image/*,application/pdf" required>
                        <small class="text-muted">Accepted formats: JPG, PNG, PDF. Max size: 4MB.</small>
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold">Issue Date <span class="text-danger">*</span></label>
                        <input type="date" name="issue_date" class="form-control" value="{{ old('issue_date') }}" required>
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold">Expiry Date (Optional)</label>
                        <input type="date" name="expiry_date" class="form-control" value="{{ old('expiry_date') }}">
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Description</label>
                        <textarea name="description" class="form-control" rows="4" placeholder="Briefly describe what you studied or the scope of this certification...">{{ old('description') }}</textarea>
                    </div>
                </div>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-primary px-4"><i class="fa-solid fa-floppy-disk me-2"></i> Save Certificate</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
