@extends('layouts.app')

@section('title', 'Add Education - Portfolio Manager')

@section('content')
<div class="row">
    <div class="col-12 col-lg-8 mx-auto">
        <div class="card-custom p-4">
            <div class="d-flex align-items-center justify-content-between mb-4 pb-2 border-bottom">
                <h4 class="fw-bold mb-0 text-main"><i class="fa-solid fa-graduation-cap text-primary me-2"></i> Add Education Record</h4>
                <a href="{{ route('education.index') }}" class="btn btn-outline-secondary btn-sm">Cancel</a>
            </div>

            <form action="{{ route('education.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold">School / University Name <span class="text-danger">*</span></label>
                        <input type="text" name="school_name" class="form-control" placeholder="e.g. Amoud University" value="{{ old('school_name') }}" required>
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold">Degree Obtained <span class="text-danger">*</span></label>
                        <input type="text" name="degree" class="form-control" placeholder="e.g. Bachelor of Science in Information Technology" value="{{ old('degree') }}" required>
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold">Department / Faculty</label>
                        <input type="text" name="department" class="form-control" placeholder="e.g. Faculty of Computing & Informatics" value="{{ old('department') }}">
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select" required>
                            <option value="">Select Status</option>
                            <option value="Completed" {{ old('status') === 'Completed' ? 'selected' : '' }}>Completed</option>
                            <option value="Graduated" {{ old('status') === 'Graduated' ? 'selected' : '' }}>Graduated</option>
                            <option value="In Progress" {{ old('status') === 'In Progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="On Leave" {{ old('status') === 'On Leave' ? 'selected' : '' }}>On Leave</option>
                        </select>
                    </div>

                    <div class="col-12 col-md-4">
                        <label class="form-label fw-semibold">Start Date <span class="text-danger">*</span></label>
                        <input type="date" name="start_date" class="form-control" value="{{ old('start_date') }}" required>
                    </div>

                    <div class="col-12 col-md-4">
                        <label class="form-label fw-semibold">End Date (Optional)</label>
                        <input type="date" name="end_date" class="form-control" value="{{ old('end_date') }}">
                        <small class="text-muted">Leave empty if currently enrolled.</small>
                    </div>

                    <div class="col-12 col-md-4">
                        <label class="form-label fw-semibold">GPA (Optional)</label>
                        <input type="text" name="gpa" class="form-control" placeholder="e.g. 3.8/4.0" value="{{ old('gpa') }}">
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Upload Certificate / Transcript (Optional)</label>
                        <input type="file" name="file" class="form-control" accept="image/*,application/pdf">
                        <small class="text-muted">Accepted formats: JPG, PNG, PDF. Max: 4MB.</small>
                    </div>
                </div>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-primary px-4"><i class="fa-solid fa-floppy-disk me-2"></i> Save Record</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
