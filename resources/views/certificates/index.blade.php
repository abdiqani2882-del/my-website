@extends('layouts.app')

@section('title', 'Certificates - Portfolio Manager')

@section('content')
<div class="card-custom p-4 mb-4">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div>
            <h4 class="fw-bold mb-1 text-main">Certificates</h4>
            <p class="text-muted mb-0">Manage and preview your academic and professional certifications.</p>
        </div>
        <a href="{{ route('certificates.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
            <i class="fa-solid fa-plus"></i> Add Certificate
        </a>
    </div>
</div>

<!-- Search and Filter Panel -->
<div class="card-custom p-3 mb-4">
    <form action="{{ route('certificates.index') }}" method="GET" class="row g-3 align-items-center">
        <div class="col-12 col-md-9">
            <div class="input-group">
                <span class="input-group-text bg-light text-muted border-end-0"><i class="fa-solid fa-magnifying-glass"></i></span>
                <input type="text" name="search" class="form-control border-start-0 bg-light" placeholder="Search by title, institution, or certificate number..." value="{{ $search }}">
            </div>
        </div>
        <div class="col-12 col-md-3 d-flex gap-2">
            <button type="submit" class="btn btn-secondary w-100"><i class="fa-solid fa-filter me-2"></i> Filter</button>
            @if(!empty($search))
                <a href="{{ route('certificates.index') }}" class="btn btn-light border w-100">Clear</a>
            @endif
        </div>
    </form>
</div>

@if($certificates->isEmpty())
    <div class="card-custom p-5 text-center">
        <img src="https://illustrations.popsy.co/blue/award.svg" alt="No certificates" style="width: 160px;" class="mb-4">
        <h5 class="fw-bold">No Certificates Found</h5>
        <p class="text-muted">Start showcasing your credentials by clicking the "Add Certificate" button above.</p>
    </div>
@else
    <div class="row g-4">
        @foreach($certificates as $cert)
            <div class="col-12 col-md-6 col-xl-4">
                <div class="card-custom p-4 h-100 d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex align-items-start justify-content-between mb-3">
                            <span class="badge bg-warning-subtle text-warning fw-semibold px-3 py-2" style="border-radius: 20px;">
                                <i class="fa-solid fa-award me-1"></i> Credential
                            </span>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-light rounded-circle" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="width: 32px; height: 32px; padding: 0;">
                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow border-0" style="border-radius: 8px;">
                                    <li><a class="dropdown-item py-2" href="{{ route('certificates.edit', $cert->id) }}"><i class="fa-solid fa-pen me-2 text-muted"></i> Edit</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="{{ route('certificates.destroy', $cert->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this certificate?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item py-2 text-danger"><i class="fa-solid fa-trash me-2"></i> Delete</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <h5 class="fw-bold mb-1 text-main text-truncate" title="{{ $cert->title }}">{{ $cert->title }}</h5>
                        <p class="text-muted small mb-3"><i class="fa-solid fa-university me-1"></i> {{ $cert->institution }}</p>
                        
                        <div class="bg-light p-2 rounded mb-3 small d-flex flex-column gap-1 text-muted">
                            <div><strong class="text-main">No:</strong> {{ $cert->certificate_number ?? 'N/A' }}</div>
                            <div><strong class="text-main">Issued:</strong> {{ \Carbon\Carbon::parse($cert->issue_date)->format('M d, Y') }}</div>
                            @if($cert->expiry_date)
                                <div><strong class="text-main">Expires:</strong> {{ \Carbon\Carbon::parse($cert->expiry_date)->format('M d, Y') }}</div>
                            @else
                                <div><strong class="text-main">Expires:</strong> Lifetime Validity</div>
                            @endif
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-3 pt-3 border-top">
                        <a href="{{ route('certificates.show', $cert->id) }}" class="btn btn-light btn-sm flex-fill d-flex align-items-center justify-content-center gap-1">
                            <i class="fa-solid fa-eye text-primary"></i> View & Print
                        </a>
                        <a href="{{ route('certificates.download', $cert->id) }}" class="btn btn-light btn-sm px-3 d-flex align-items-center justify-content-center text-success" title="Download">
                            <i class="fa-solid fa-download"></i>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $certificates->links('pagination::bootstrap-5') }}
    </div>
@endif
@endsection
