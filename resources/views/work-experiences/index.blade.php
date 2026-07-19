@extends('layouts.app')

@section('title', 'Work Experience - Portfolio Manager')

@section('content')
<div class="card-custom p-4 mb-4">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div>
            <h4 class="fw-bold mb-1 text-main">Work Experience</h4>
            <p class="text-muted mb-0">Manage your employment history and professional roles.</p>
        </div>
        <a href="{{ route('work-experiences.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
            <i class="fa-solid fa-plus"></i> Add Experience
        </a>
    </div>
</div>

@if($workExperiences->isEmpty())
    <div class="card-custom p-5 text-center">
        <img src="https://illustrations.popsy.co/blue/work-from-home.svg" alt="No work experience" style="width: 160px;" class="mb-4">
        <h5 class="fw-bold">No Work Experience Found</h5>
        <p class="text-muted">You haven't added any professional experience yet. Add your first role now.</p>
    </div>
@else
    <div class="row g-4">
        @foreach($workExperiences as $work)
            <div class="col-12 col-xl-6">
                <div class="card-custom p-4 h-100 position-relative">
                    <div class="dropdown position-absolute top-0 end-0 mt-3 me-3">
                        <button class="btn btn-sm btn-light rounded-circle" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="width: 32px; height: 32px; padding: 0;">
                            <i class="fa-solid fa-ellipsis-vertical"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0" style="border-radius: 8px;">
                            <li><a class="dropdown-item py-2" href="{{ route('work-experiences.edit', $work->id) }}"><i class="fa-solid fa-pen me-2 text-muted"></i> Edit</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('work-experiences.destroy', $work->id) }}" method="POST" onsubmit="return confirm('Delete this work experience?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="dropdown-item py-2 text-danger"><i class="fa-solid fa-trash me-2"></i> Delete</button>
                                </form>
                            </li>
                        </ul>
                    </div>

                    <div class="d-flex align-items-start gap-3 mb-3">
                        @if($work->company_logo)
                            <img src="{{ asset('storage/' . $work->company_logo) }}" alt="{{ $work->company }}" class="rounded shadow-sm" style="width: 56px; height: 56px; object-fit: cover;">
                        @else
                            <div class="rounded shadow-sm bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center" style="width: 56px; height: 56px; flex-shrink: 0;">
                                <i class="fa-solid fa-building fs-4"></i>
                            </div>
                        @endif
                        <div>
                            <h5 class="fw-bold mb-1 text-main pe-4">{{ $work->job_title }}</h5>
                            <div class="text-muted fw-medium">{{ $work->company }} {!! $work->department ? '<span class="fw-normal"> &bull; '.$work->department.'</span>' : '' !!}</div>
                        </div>
                    </div>

                    <div class="mb-3 d-flex align-items-center gap-2">
                        <span class="badge bg-light text-dark border">
                            <i class="fa-regular fa-calendar me-1"></i>
                            {{ \Carbon\Carbon::parse($work->start_date)->format('M Y') }} - 
                            {{ $work->is_current ? 'Present' : \Carbon\Carbon::parse($work->end_date)->format('M Y') }}
                        </span>
                        @if($work->is_current)
                            <span class="badge bg-success-subtle text-success">Current Role</span>
                        @endif
                    </div>

                    @if($work->job_description)
                        <div class="text-muted small" style="white-space: pre-line;">
                            {{ $work->job_description }}
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $workExperiences->links('pagination::bootstrap-5') }}
    </div>
@endif
@endsection
