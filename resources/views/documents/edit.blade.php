@extends('layouts.app')

@section('title', 'Edit Document - Portfolio Manager')

@section('content')
<div class="row">
    <div class="col-12 col-lg-8 mx-auto">
        <div class="card-custom p-4">
            <div class="d-flex align-items-center justify-content-between mb-4 pb-2 border-bottom">
                <h4 class="fw-bold mb-0 text-main"><i class="fa-solid fa-pen text-primary me-2"></i> Edit Document Metadata</h4>
                <a href="{{ route('documents.index') }}" class="btn btn-outline-secondary btn-sm">Cancel</a>
            </div>

            <form action="{{ route('documents.update', $document->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold">Document Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" value="{{ $document->title }}" required>
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
                        <select name="category" class="form-select" required>
                            <option value="CV / Resume" {{ $document->category === 'CV / Resume' ? 'selected' : '' }}>CV / Resume</option>
                            <option value="Passport" {{ $document->category === 'Passport' ? 'selected' : '' }}>Passport</option>
                            <option value="National ID" {{ $document->category === 'National ID' ? 'selected' : '' }}>National ID</option>
                            <option value="Cover Letter" {{ $document->category === 'Cover Letter' ? 'selected' : '' }}>Cover Letter</option>
                            <option value="Reference Letter" {{ $document->category === 'Reference Letter' ? 'selected' : '' }}>Reference Letter</option>
                            <option value="Other Document" {{ $document->category === 'Other Document' ? 'selected' : '' }}>Other Document</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Replace File (Optional)</label>
                        <input type="file" name="file" class="form-control">
                        <small class="text-muted">Leave empty to keep the current file. Max size: 10MB.</small>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Description (Optional)</label>
                        <textarea name="description" class="form-control" rows="3">{{ $document->description }}</textarea>
                    </div>
                </div>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-primary px-4"><i class="fa-solid fa-floppy-disk me-2"></i> Update Document</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
