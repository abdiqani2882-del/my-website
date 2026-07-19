@extends('layouts.app')

@section('title', 'Add Work Experience - Portfolio Manager')

@section('content')
<div class="row">
    <div class="col-12 col-lg-8 mx-auto">
        <div class="card-custom p-4">
            <div class="d-flex align-items-center justify-content-between mb-4 pb-2 border-bottom">
                <h4 class="fw-bold mb-0 text-main"><i class="fa-solid fa-briefcase text-primary me-2"></i> Add Work Experience</h4>
                <a href="{{ route('work-experiences.index') }}" class="btn btn-outline-secondary btn-sm">Cancel</a>
            </div>

            <form action="{{ route('work-experiences.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold">Job Title <span class="text-danger">*</span></label>
                        <input type="text" name="job_title" class="form-control" placeholder="e.g. Senior Software Engineer" value="{{ old('job_title') }}" required>
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold">Company Organization <span class="text-danger">*</span></label>
                        <input type="text" name="company" class="form-control" placeholder="e.g. Google" value="{{ old('company') }}" required>
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold">Department (Optional)</label>
                        <input type="text" name="department" class="form-control" placeholder="e.g. Engineering" value="{{ old('department') }}">
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold">Company Logo (Optional)</label>
                        <input type="file" name="company_logo" class="form-control" accept="image/*">
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold">Start Date <span class="text-danger">*</span></label>
                        <input type="date" name="start_date" class="form-control" value="{{ old('start_date') }}" required>
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold">End Date</label>
                        <input type="date" name="end_date" id="end_date" class="form-control" value="{{ old('end_date') }}">
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" name="is_current" id="is_current" value="1" {{ old('is_current') ? 'checked' : '' }}>
                            <label class="form-check-label small" for="is_current">I currently work here</label>
                        </div>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Job Description</label>
                        <textarea name="job_description" class="form-control" rows="5" placeholder="Describe your responsibilities, achievements, and technologies used...">{{ old('job_description') }}</textarea>
                    </div>
                </div>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-primary px-4"><i class="fa-solid fa-floppy-disk me-2"></i> Save Experience</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const isCurrentCheckbox = document.getElementById('is_current');
        const endDateInput = document.getElementById('end_date');

        function toggleEndDate() {
            if (isCurrentCheckbox.checked) {
                endDateInput.value = '';
                endDateInput.disabled = true;
            } else {
                endDateInput.disabled = false;
            }
        }

        isCurrentCheckbox.addEventListener('change', toggleEndDate);
        toggleEndDate();
    });
</script>
@endsection
