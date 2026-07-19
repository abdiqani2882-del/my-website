@extends('layouts.app')

@section('title', 'Reports & Export - Portfolio Manager')

@section('styles')
<style>
    @media print {
        body {
            background-color: #fff !important;
        }
        .sidebar, .navbar, .btn, .no-print {
            display: none !important;
        }
        .main-content {
            margin-left: 0 !important;
            padding: 0 !important;
        }
        .card-custom {
            box-shadow: none !important;
            border: none !important;
            padding: 0 !important;
            margin-bottom: 20px !important;
        }
        .print-resume {
            max-width: 100% !important;
        }
    }
</style>
@endsection

@section('content')
<div class="row no-print mb-4">
    <div class="col-12">
        <div class="card-custom p-4">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div>
                    <h4 class="fw-bold mb-1 text-main">Reports & Exports</h4>
                    <p class="text-muted mb-0">Export your data to CSV or print a comprehensive resume summary.</p>
                </div>
                <button onclick="window.print()" class="btn btn-primary d-flex align-items-center gap-2">
                    <i class="fa-solid fa-print"></i> Print Resume Summary
                </button>
            </div>
            
            <hr class="my-4">
            
            <h5 class="fw-bold mb-3">Export Data to CSV</h5>
            <div class="d-flex flex-wrap gap-3">
                <a href="{{ route('reports.export', 'experiences') }}" class="btn btn-outline-primary d-flex align-items-center gap-2">
                    <i class="fa-solid fa-file-csv"></i> Work Experience
                </a>
                <a href="{{ route('reports.export', 'education') }}" class="btn btn-outline-primary d-flex align-items-center gap-2">
                    <i class="fa-solid fa-file-csv"></i> Education
                </a>
                <a href="{{ route('reports.export', 'skills') }}" class="btn btn-outline-primary d-flex align-items-center gap-2">
                    <i class="fa-solid fa-file-csv"></i> Skills
                </a>
                <a href="{{ route('reports.export', 'certificates') }}" class="btn btn-outline-primary d-flex align-items-center gap-2">
                    <i class="fa-solid fa-file-csv"></i> Certificates
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Printable Resume Summary -->
<div class="row print-resume">
    <div class="col-12 mx-auto" style="max-width: 900px;">
        <div class="card-custom p-5">
            <!-- Header -->
            <div class="text-center mb-5 border-bottom pb-4">
                @if($profile && $profile->profile_picture)
                    <img src="{{ asset('storage/' . $profile->profile_picture) }}" alt="Profile" class="rounded-circle mb-3" style="width: 120px; height: 120px; object-fit: cover;">
                @endif
                <h1 class="fw-bold text-dark mb-1">{{ $profile->full_name ?? Auth::user()->name }}</h1>
                <h4 class="text-primary mb-3">{{ $profile->professional_title ?? 'Professional Title' }}</h4>
                <div class="d-flex justify-content-center flex-wrap gap-3 text-muted">
                    @if($profile)
                        @if($profile->email) <span><i class="fa-solid fa-envelope me-1"></i> {{ $profile->email }}</span> @endif
                        @if($profile->phone) <span><i class="fa-solid fa-phone me-1"></i> {{ $profile->phone }}</span> @endif
                        @if($profile->location) <span><i class="fa-solid fa-location-dot me-1"></i> {{ $profile->location }}</span> @endif
                    @endif
                </div>
            </div>

            <!-- About -->
            @if($profile && $profile->bio)
                <div class="mb-5">
                    <h4 class="fw-bold text-dark border-bottom pb-2 mb-3 text-uppercase fs-6 tracking-wide">About Me</h4>
                    <p class="text-dark" style="white-space: pre-line;">{{ $profile->bio }}</p>
                </div>
            @endif

            <!-- Work Experience -->
            @if($experiences->isNotEmpty())
                <div class="mb-5">
                    <h4 class="fw-bold text-dark border-bottom pb-2 mb-3 text-uppercase fs-6 tracking-wide">Work Experience</h4>
                    @foreach($experiences as $work)
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-baseline mb-1">
                                <h5 class="fw-bold text-dark mb-0">{{ $work->job_title }}</h5>
                                <span class="text-primary fw-medium small">
                                    {{ \Carbon\Carbon::parse($work->start_date)->format('M Y') }} - 
                                    {{ $work->is_current ? 'Present' : \Carbon\Carbon::parse($work->end_date)->format('M Y') }}
                                </span>
                            </div>
                            <div class="fw-semibold text-muted mb-2">{{ $work->company }} {!! $work->department ? '<span class="fw-normal">| '.$work->department.'</span>' : '' !!}</div>
                            @if($work->job_description)
                                <p class="text-dark small mb-0" style="white-space: pre-line;">{{ $work->job_description }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Education -->
            @if($education->isNotEmpty())
                <div class="mb-5">
                    <h4 class="fw-bold text-dark border-bottom pb-2 mb-3 text-uppercase fs-6 tracking-wide">Education</h4>
                    @foreach($education as $edu)
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-baseline mb-1">
                                <h5 class="fw-bold text-dark mb-0">{{ $edu->degree }} in {{ $edu->field_of_study }}</h5>
                                <span class="text-primary fw-medium small">
                                    {{ \Carbon\Carbon::parse($edu->start_date)->format('Y') }} - 
                                    {{ $edu->is_current ? 'Present' : \Carbon\Carbon::parse($edu->end_date)->format('Y') }}
                                </span>
                            </div>
                            <div class="fw-semibold text-muted mb-2">{{ $edu->institution }}</div>
                            @if($edu->description)
                                <p class="text-dark small mb-0">{{ $edu->description }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Skills -->
            @if($skills->isNotEmpty())
                <div class="mb-5">
                    <h4 class="fw-bold text-dark border-bottom pb-2 mb-3 text-uppercase fs-6 tracking-wide">Skills & Expertise</h4>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($skills as $skill)
                            <span class="badge bg-light text-dark border p-2">{{ $skill->name }}</span>
                        @endforeach
                    </div>
                </div>
            @endif
            
            <!-- Certificates -->
            @if($certificates->isNotEmpty())
                <div class="mb-5">
                    <h4 class="fw-bold text-dark border-bottom pb-2 mb-3 text-uppercase fs-6 tracking-wide">Certifications</h4>
                    <ul class="list-unstyled">
                        @foreach($certificates as $cert)
                            <li class="mb-2">
                                <span class="fw-bold text-dark">{{ $cert->name }}</span> - <span class="text-muted">{{ $cert->issuing_organization }}</span>
                                <span class="small text-muted ms-2">({{ \Carbon\Carbon::parse($cert->issue_date)->format('M Y') }})</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

        </div>
    </div>
</div>
@endsection
