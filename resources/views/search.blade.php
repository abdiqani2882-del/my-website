@extends('layouts.app')

@section('title', 'Search Results - Portfolio Manager')

@section('content')
<div class="card-custom p-4 mb-4">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div>
            <h4 class="fw-bold mb-1 text-main">Search Results</h4>
            <p class="text-muted mb-0">Found {{ $totalResults }} results for query: <span class="fw-semibold text-primary">"{{ $query }}"</span></p>
        </div>
        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm"><i class="fa-solid fa-arrow-left me-2"></i> Back to Dashboard</a>
    </div>
</div>

@if($totalResults === 0)
    <div class="card-custom p-5 text-center">
        <img src="https://illustrations.popsy.co/blue/searching.svg" alt="No results" style="width: 200px;" class="mb-4">
        <h5 class="fw-bold mb-1">No matches found</h5>
        <p class="text-muted">Double-check your spelling or try search terms with fewer characters.</p>
    </div>
@else
    <div class="row g-4">
        <!-- Certificates Matches -->
        @if($certificates->isNotEmpty())
            <div class="col-12">
                <div class="card-custom p-4">
                    <h5 class="fw-bold mb-3 text-warning"><i class="fa-solid fa-award me-2"></i> Certificates ({{ $certificates->count() }})</h5>
                    <div class="table-responsive">
                        <table class="table table-custom align-middle">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Institution</th>
                                    <th>Number</th>
                                    <th>Issue Date</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($certificates as $cert)
                                    <tr>
                                        <td class="fw-semibold">{{ $cert->title }}</td>
                                        <td>{{ $cert->institution }}</td>
                                        <td>{{ $cert->certificate_number ?? 'N/A' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($cert->issue_date)->format('M d, Y') }}</td>
                                        <td class="text-end">
                                            <a href="{{ route('certificates.show', $cert->id) }}" class="btn btn-sm btn-light"><i class="fa-solid fa-eye text-primary"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

        <!-- Work Experience Matches -->
        @if($workExperiences->isNotEmpty())
            <div class="col-12">
                <div class="card-custom p-4">
                    <h5 class="fw-bold mb-3 text-primary"><i class="fa-solid fa-briefcase me-2"></i> Work Experience ({{ $workExperiences->count() }})</h5>
                    <div class="table-responsive">
                        <table class="table table-custom align-middle">
                            <thead>
                                <tr>
                                    <th>Job Title</th>
                                    <th>Company</th>
                                    <th>Department</th>
                                    <th>Duration</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($workExperiences as $work)
                                    <tr>
                                        <td class="fw-semibold">{{ $work->job_title }}</td>
                                        <td>{{ $work->company }}</td>
                                        <td>{{ $work->department ?? 'N/A' }}</td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($work->start_date)->format('M Y') }} - 
                                            {{ $work->is_current ? 'Present' : \Carbon\Carbon::parse($work->end_date)->format('M Y') }}
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('work-experiences.edit', $work->id) }}" class="btn btn-sm btn-light"><i class="fa-solid fa-pen text-primary"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

        <!-- Education Matches -->
        @if($education->isNotEmpty())
            <div class="col-12">
                <div class="card-custom p-4">
                    <h5 class="fw-bold mb-3 text-info"><i class="fa-solid fa-graduation-cap me-2"></i> Education records ({{ $education->count() }})</h5>
                    <div class="table-responsive">
                        <table class="table table-custom align-middle">
                            <thead>
                                <tr>
                                    <th>Degree</th>
                                    <th>School/University</th>
                                    <th>Department</th>
                                    <th>Status</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($education as $edu)
                                    <tr>
                                        <td class="fw-semibold">{{ $edu->degree }}</td>
                                        <td>{{ $edu->school_name }}</td>
                                        <td>{{ $edu->department ?? 'N/A' }}</td>
                                        <td><span class="badge bg-light text-dark">{{ $edu->status }}</span></td>
                                        <td class="text-end">
                                            <a href="{{ route('education.edit', $edu->id) }}" class="btn btn-sm btn-light"><i class="fa-solid fa-pen text-primary"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

        <!-- Documents Matches -->
        @if($documents->isNotEmpty())
            <div class="col-12">
                <div class="card-custom p-4">
                    <h5 class="fw-bold mb-3 text-secondary"><i class="fa-solid fa-file-invoice me-2"></i> Documents ({{ $documents->count() }})</h5>
                    <div class="table-responsive">
                        <table class="table table-custom align-middle">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Description</th>
                                    <th>Uploaded At</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($documents as $doc)
                                    <tr>
                                        <td class="fw-semibold">{{ $doc->title }}</td>
                                        <td><span class="badge bg-secondary-subtle text-secondary">{{ $doc->category }}</span></td>
                                        <td>{{ Str::limit($doc->description, 50) }}</td>
                                        <td>{{ $doc->created_at->format('M d, Y') }}</td>
                                        <td class="text-end">
                                            <a href="{{ route('documents.download', $doc->id) }}" class="btn btn-sm btn-light text-success"><i class="fa-solid fa-download"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

        <!-- Skills Matches -->
        @if($skills->isNotEmpty())
            <div class="col-12 col-md-6">
                <div class="card-custom p-4 h-100">
                    <h5 class="fw-bold mb-3 text-danger"><i class="fa-solid fa-sliders me-2"></i> Skills ({{ $skills->count() }})</h5>
                    <div class="list-group list-group-flush">
                        @foreach($skills as $skill)
                            <div class="list-group-item bg-transparent border-0 px-0">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="fw-semibold">{{ $skill->name }} <small class="text-muted">({{ $skill->category }})</small></span>
                                    <span class="small fw-bold">{{ $skill->level }}%</span>
                                </div>
                                <div class="progress" style="height: 6px; border-radius: 10px;">
                                    <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $skill->level }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        <!-- Photos Matches -->
        @if($photos->isNotEmpty())
            <div class="col-12 col-md-6">
                <div class="card-custom p-4 h-100">
                    <h5 class="fw-bold mb-3 text-success"><i class="fa-solid fa-images me-2"></i> Photos ({{ $photos->count() }})</h5>
                    <div class="row g-2">
                        @foreach($photos as $photo)
                            <div class="col-4">
                                <div class="position-relative ratio ratio-1x1 rounded overflow-hidden shadow-sm" style="group">
                                    <img src="{{ asset('storage/' . $photo->file_path) }}" alt="Photo" style="object-fit: cover;">
                                    <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-25 d-flex align-items-end p-2">
                                        <span class="text-white small text-truncate fw-semibold w-100">{{ $photo->title ?? ucfirst($photo->category) }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>
@endif
@endsection
