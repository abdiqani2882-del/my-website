@extends('layouts.app')

@section('title', $certificate->title . ' - Details')

@section('styles')
<style>
    @media print {
        #sidebar, .top-navbar, .btn-print-actions, .nav-tabs, .card-header, .alert, footer {
            display: none !important;
        }
        #main-wrapper {
            margin-left: 0 !important;
            padding: 0 !important;
        }
        .content-body {
            padding: 0 !important;
        }
        .card-custom {
            border: none !important;
            box-shadow: none !important;
            background: transparent !important;
        }
        .print-full-width {
            width: 100% !important;
        }
        .certificate-preview-box {
            page-break-before: always;
        }
    }
</style>
@endsection

@section('content')
<div class="row g-4">
    <!-- Certificate Details Panel -->
    <div class="col-12 col-xl-4 print-full-width">
        <div class="card-custom p-4 h-100">
            <div class="d-flex align-items-center justify-content-between mb-4 btn-print-actions pb-2 border-bottom">
                <h5 class="fw-bold mb-0 text-main"><i class="fa-solid fa-award text-warning me-2"></i> Certificate Details</h5>
                <a href="{{ route('certificates.index') }}" class="btn btn-outline-secondary btn-sm"><i class="fa-solid fa-arrow-left"></i></a>
            </div>

            <div class="mb-3">
                <span class="text-muted small d-block">Certificate Title</span>
                <h4 class="fw-bold text-main mb-0">{{ $certificate->title }}</h4>
            </div>

            <div class="mb-3">
                <span class="text-muted small d-block">Issuing Institution</span>
                <span class="fw-semibold text-main">{{ $certificate->institution }}</span>
            </div>

            <div class="mb-3">
                <span class="text-muted small d-block">Credential Number / ID</span>
                <span class="fw-semibold text-main">{{ $certificate->certificate_number ?? 'N/A' }}</span>
            </div>

            <div class="row mb-3">
                <div class="col-6">
                    <span class="text-muted small d-block">Issue Date</span>
                    <span class="fw-semibold text-main">{{ \Carbon\Carbon::parse($certificate->issue_date)->format('M d, Y') }}</span>
                </div>
                <div class="col-6">
                    <span class="text-muted small d-block">Expiry Date</span>
                    <span class="fw-semibold text-main">
                        {{ $certificate->expiry_date ? \Carbon\Carbon::parse($certificate->expiry_date)->format('M d, Y') : 'Lifetime' }}
                    </span>
                </div>
            </div>

            @if($certificate->description)
                <div class="mb-4">
                    <span class="text-muted small d-block">Scope / Description</span>
                    <p class="text-muted small mb-0" style="white-space: pre-line;">{{ $certificate->description }}</p>
                </div>
            @endif

            <div class="d-flex flex-column gap-2 mt-4 btn-print-actions">
                <button onclick="window.print()" class="btn btn-primary d-flex align-items-center justify-content-center gap-2">
                    <i class="fa-solid fa-print"></i> Print Document
                </button>
                <a href="{{ route('certificates.download', $certificate->id) }}" class="btn btn-success d-flex align-items-center justify-content-center gap-2">
                    <i class="fa-solid fa-download"></i> Download File
                </a>
                <a href="{{ route('certificates.edit', $certificate->id) }}" class="btn btn-light border d-flex align-items-center justify-content-center gap-2">
                    <i class="fa-solid fa-pen text-muted"></i> Edit Details
                </a>
            </div>
        </div>
    </div>

    <!-- Certificate Preview Box -->
    <div class="col-12 col-xl-8 print-full-width certificate-preview-box">
        <div class="card-custom p-4 h-100">
            <h5 class="fw-bold mb-3 btn-print-actions"><i class="fa-solid fa-eye text-primary me-2"></i> File Preview</h5>
            
            @php
                $extension = pathinfo($certificate->file_path, PATHINFO_EXTENSION);
            @endphp

            <div class="border rounded bg-light p-2 d-flex align-items-center justify-content-center overflow-hidden" style="min-height: 500px;">
                @if(strtolower($extension) === 'pdf')
                    <iframe src="{{ route('certificates.preview', $certificate->id) }}#toolbar=0" width="100%" height="600px" style="border: none;"></iframe>
                @elseif(in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'webp']))
                    <img src="{{ route('certificates.preview', $certificate->id) }}" alt="Certificate" class="img-fluid rounded shadow-sm" style="max-height: 600px; object-fit: contain;">
                @else
                    <div class="text-center py-5">
                        <i class="fa-regular fa-file-pdf text-danger fs-1 mb-3"></i>
                        <p class="mb-0">Preview not available for this format. Please download the file to view.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
