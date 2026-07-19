@extends('layouts.app')

@section('title', 'Edit Skill - Portfolio Manager')

@section('content')
<div class="row">
    <div class="col-12 col-lg-8 mx-auto">
        <div class="card-custom p-4">
            <div class="d-flex align-items-center justify-content-between mb-4 pb-2 border-bottom">
                <h4 class="fw-bold mb-0 text-main"><i class="fa-solid fa-pen text-primary me-2"></i> Edit Skill</h4>
                <a href="{{ route('skills.index') }}" class="btn btn-outline-secondary btn-sm">Cancel</a>
            </div>

            <form action="{{ route('skills.update', $skill->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold">Skill Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ $skill->name }}" required>
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
                        <input type="text" name="category" class="form-control" value="{{ $skill->category }}" list="categoriesList" required>
                        <datalist id="categoriesList">
                            <option value="Frontend Development">
                            <option value="Backend Development">
                            <option value="Database Management">
                            <option value="DevOps & Tools">
                            <option value="Soft Skills">
                            <option value="Languages">
                        </datalist>
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold">Proficiency Level (0-100) <span class="text-danger">*</span></label>
                        <div class="d-flex align-items-center gap-3">
                            <input type="range" name="level" class="form-range flex-grow-1" min="0" max="100" step="5" id="levelRange" value="{{ $skill->level }}" required>
                            <span id="levelValue" class="badge bg-primary fs-6" style="width: 60px;">{{ $skill->level }}%</span>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold">Experience (Optional)</label>
                        <input type="text" name="experience" class="form-control" value="{{ $skill->experience }}">
                    </div>
                </div>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-primary px-4"><i class="fa-solid fa-floppy-disk me-2"></i> Update Skill</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const levelRange = document.getElementById('levelRange');
    const levelValue = document.getElementById('levelValue');
    levelRange.addEventListener('input', function() {
        levelValue.textContent = this.value + '%';
    });
</script>
@endsection
