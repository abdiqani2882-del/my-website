@extends('layouts.app')

@section('title', 'Upload Document - Portfolio Manager')

@section('content')
<div class="row">
    <div class="col-12 col-lg-8 mx-auto">
        <div class="card-custom p-4">
            <div class="d-flex align-items-center justify-content-between mb-4 pb-2 border-bottom">
                <h4 class="fw-bold mb-0 text-main"><i class="fa-solid fa-file-arrow-up text-primary me-2"></i> Upload Document</h4>
                <a href="{{ route('documents.index') }}" class="btn btn-outline-secondary btn-sm">Cancel</a>
            </div>

            <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold">Document Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" placeholder="e.g. My Updated CV 2024" value="{{ old('title') }}" required>
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
                        <select name="category" class="form-select" required>
                            <option value="">Select Category</option>
                            <option value="CV / Resume" {{ old('category') === 'CV / Resume' ? 'selected' : '' }}>CV / Resume</option>
                            <option value="Passport" {{ old('category') === 'Passport' ? 'selected' : '' }}>Passport</option>
                            <option value="National ID" {{ old('category') === 'National ID' ? 'selected' : '' }}>National ID</option>
                            <option value="Cover Letter" {{ old('category') === 'Cover Letter' ? 'selected' : '' }}>Cover Letter</option>
                            <option value="Reference Letter" {{ old('category') === 'Reference Letter' ? 'selected' : '' }}>Reference Letter</option>
                            <option value="Other Document" {{ old('category') === 'Other Document' ? 'selected' : '' }}>Other Document</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Select File <span class="text-danger">*</span></label>
                        <input type="file" name="file" class="form-control" required>
                        <small class="text-muted">Accepted formats: PDF, Word (DOC/DOCX), Images (JPG/PNG). Max size: 10MB.</small>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Description (Optional)</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Brief note about this document...">{{ old('description') }}</textarea>
                    </div>
                </div>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-primary px-4"><i class="fa-solid fa-cloud-arrow-up me-2"></i> Upload File</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
