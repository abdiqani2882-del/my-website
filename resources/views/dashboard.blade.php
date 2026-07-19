@extends('layouts.app')

@section('title', 'Dashboard - Portfolio Manager')

@section('content')
<div class="row g-4 mb-4">
    <!-- Stat Card: Certificates -->
    <div class="col-12 col-sm-6 col-xl-4">
        <div class="card-custom p-4 h-100 d-flex align-items-center justify-content-between">
            <div>
                <span class="text-muted small fw-semibold d-block mb-1">Total Certificates</span>
                <h3 class="fw-bold mb-0 text-main">{{ $totalCertificates }}</h3>
            </div>
            <div class="rounded-circle p-3 bg-warning-subtle text-warning">
                <i class="fa-solid fa-award fs-3"></i>
            </div>
        </div>
    </div>

    <!-- Stat Card: Photos -->
    <div class="col-12 col-sm-6 col-xl-4">
        <div class="card-custom p-4 h-100 d-flex align-items-center justify-content-between">
            <div>
                <span class="text-muted small fw-semibold d-block mb-1">Total Photos</span>
                <h3 class="fw-bold mb-0 text-main">{{ $totalPhotos }}</h3>
            </div>
            <div class="rounded-circle p-3 bg-success-subtle text-success">
                <i class="fa-solid fa-images fs-3"></i>
            </div>
        </div>
    </div>

    <!-- Stat Card: Work Experiences -->
    <div class="col-12 col-sm-6 col-xl-4">
        <div class="card-custom p-4 h-100 d-flex align-items-center justify-content-between">
            <div>
                <span class="text-muted small fw-semibold d-block mb-1">Work Experiences</span>
                <h3 class="fw-bold mb-0 text-main">{{ $totalWorkExperiences }}</h3>
            </div>
            <div class="rounded-circle p-3 bg-primary-subtle text-primary">
                <i class="fa-solid fa-briefcase fs-3"></i>
            </div>
        </div>
    </div>

    <!-- Stat Card: Education -->
    <div class="col-12 col-sm-6 col-xl-4">
        <div class="card-custom p-4 h-100 d-flex align-items-center justify-content-between">
            <div>
                <span class="text-muted small fw-semibold d-block mb-1">Education Records</span>
                <h3 class="fw-bold mb-0 text-main">{{ $totalEducation }}</h3>
            </div>
            <div class="rounded-circle p-3 bg-info-subtle text-info">
                <i class="fa-solid fa-graduation-cap fs-3"></i>
            </div>
        </div>
    </div>

    <!-- Stat Card: Skills -->
    <div class="col-12 col-sm-6 col-xl-4">
        <div class="card-custom p-4 h-100 d-flex align-items-center justify-content-between">
            <div>
                <span class="text-muted small fw-semibold d-block mb-1">Total Skills</span>
                <h3 class="fw-bold mb-0 text-main">{{ $totalSkills }}</h3>
            </div>
            <div class="rounded-circle p-3 bg-danger-subtle text-danger">
                <i class="fa-solid fa-sliders fs-3"></i>
            </div>
        </div>
    </div>

    <!-- Stat Card: Documents -->
    <div class="col-12 col-sm-6 col-xl-4">
        <div class="card-custom p-4 h-100 d-flex align-items-center justify-content-between">
            <div>
                <span class="text-muted small fw-semibold d-block mb-1">Total Documents</span>
                <h3 class="fw-bold mb-0 text-main">{{ $totalDocuments }}</h3>
            </div>
            <div class="rounded-circle p-3 bg-secondary-subtle text-secondary">
                <i class="fa-solid fa-file-invoice fs-3"></i>
            </div>
        </div>
    </div>
</div>

<!-- Quick Action Buttons -->
<div class="card-custom p-4 mb-4">
    <h5 class="fw-bold mb-3"><i class="fa-solid fa-bolt text-primary me-2"></i> Quick Actions</h5>
    <div class="d-flex flex-wrap gap-3">
        <a href="{{ route('profile.index') }}" class="btn btn-outline-primary d-flex align-items-center gap-2">
            <i class="fa-solid fa-user-pen"></i> Update Profile
        </a>
        <a href="{{ route('certificates.create') }}" class="btn btn-outline-warning d-flex align-items-center gap-2" style="color: #D97706; border-color: #F59E0B;">
            <i class="fa-solid fa-award"></i> Add Certificate
        </a>
        <a href="{{ route('documents.create') }}" class="btn btn-outline-secondary d-flex align-items-center gap-2">
            <i class="fa-solid fa-file-arrow-up"></i> Upload Document
        </a>
        <a href="{{ route('photos.index') }}" class="btn btn-outline-success d-flex align-items-center gap-2">
            <i class="fa-solid fa-image"></i> Add Photos
        </a>
        <a href="{{ route('work-experiences.create') }}" class="btn btn-outline-info d-flex align-items-center gap-2">
            <i class="fa-solid fa-briefcase"></i> Add Experience
        </a>
    </div>
</div>

<div class="row g-4">
    <!-- Chart Column -->
    <div class="col-12 col-lg-5">
        <div class="card-custom p-4 h-100">
            <h5 class="fw-bold mb-4"><i class="fa-solid fa-chart-pie text-primary me-2"></i> Portfolio Distribution</h5>
            <div class="d-flex justify-content-center align-items-center" style="position: relative; height: 260px;">
                <canvas id="portfolioChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Recent Activities & Uploads -->
    <div class="col-12 col-lg-7">
        <div class="card-custom p-4 h-100">
            <h5 class="fw-bold mb-3"><i class="fa-solid fa-clock-rotate-left text-primary me-2"></i> Recent Uploads</h5>
            @if($recentUploads->isEmpty())
                <div class="text-center py-5">
                    <img src="https://illustrations.popsy.co/blue/document-sign.svg" alt="Empty" style="width: 120px;" class="mb-3">
                    <p class="text-muted mb-0">No files uploaded yet.</p>
                </div>
            @else
                <div class="list-group list-group-flush">
                    @foreach($recentUploads as $upload)
                        <div class="list-group-item bg-transparent border-0 px-0 py-3 d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle p-2 bg-light text-center me-3" style="width: 40px; height: 40px;">
                                    <i class="fa-solid {{ $upload->icon }} fs-5"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-semibold">{{ $upload->display_title }}</h6>
                                    <span class="text-muted small">{{ $upload->type }} • {{ $upload->detail }}</span>
                                </div>
                            </div>
                            <span class="text-muted small fw-medium">{{ $upload->created_at->diffForHumans() }}</span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Next Row: Recent Work & Education Summary -->
<div class="row g-4 mt-2">
    <div class="col-12 col-md-6">
        <div class="card-custom p-4 h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0"><i class="fa-solid fa-briefcase text-primary me-2"></i> Work Experience</h5>
                <a href="{{ route('work-experiences.index') }}" class="btn btn-sm btn-link text-decoration-none">View All</a>
            </div>
            @if($recentWork->isEmpty())
                <p class="text-muted small mb-0">No work experiences added yet.</p>
            @else
                <ul class="list-unstyled mb-0">
                    @foreach($recentWork as $work)
                        <li class="mb-3 last-mb-0">
                            <div class="d-flex justify-content-between">
                                <span class="fw-semibold">{{ $work->job_title }}</span>
                                <span class="badge bg-light text-dark small fw-normal">{{ \Carbon\Carbon::parse($work->start_date)->format('Y') }} - {{ $work->is_current ? 'Present' : \Carbon\Carbon::parse($work->end_date)->format('Y') }}</span>
                            </div>
                            <div class="text-muted small">{{ $work->company }} • {{ $work->department }}</div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="card-custom p-4 h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0"><i class="fa-solid fa-graduation-cap text-primary me-2"></i> Education</h5>
                <a href="{{ route('education.index') }}" class="btn btn-sm btn-link text-decoration-none">View All</a>
            </div>
            @if($recentEdu->isEmpty())
                <p class="text-muted small mb-0">No education history added yet.</p>
            @else
                <ul class="list-unstyled mb-0">
                    @foreach($recentEdu as $edu)
                        <li class="mb-3 last-mb-0">
                            <div class="d-flex justify-content-between">
                                <span class="fw-semibold">{{ $edu->degree }}</span>
                                <span class="badge bg-light text-dark small fw-normal">{{ \Carbon\Carbon::parse($edu->start_date)->format('Y') }} - {{ $edu->end_date ? \Carbon\Carbon::parse($edu->end_date)->format('Y') : 'Present' }}</span>
                            </div>
                            <div class="text-muted small">{{ $edu->school_name }} • {{ $edu->department }}</div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('portfolioChart').getContext('2d');
        
        // Dynamically fetch values from backend compact variables
        const data = {
            labels: ['Certificates', 'Photos', 'Work Exp', 'Edu Records', 'Documents'],
            datasets: [{
                data: [
                    {{ $totalCertificates }},
                    {{ $totalPhotos }},
                    {{ $totalWorkExperiences }},
                    {{ $totalEducation }},
                    {{ $totalDocuments }}
                ],
                backgroundColor: [
                    '#F59E0B', // Amber
                    '#10B981', // Emerald
                    '#2563EB', // Blue
                    '#06B6D4', // Cyan
                    '#64748B'  // Slate
                ],
                borderWidth: 0
            }]
        };

        const config = {
            type: 'doughnut',
            data: data,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: getComputedStyle(document.documentElement).getPropertyValue('--text-main').trim(),
                            font: {
                                family: 'Outfit',
                                size: 12
                            }
                        }
                    }
                },
                cutout: '70%'
            }
        };

        const myChart = new Chart(ctx, config);

        // Adjust chart label colors on theme change
        document.getElementById('theme-toggle').addEventListener('click', () => {
            setTimeout(() => {
                const textMainColor = getComputedStyle(document.documentElement).getPropertyValue('--text-main').trim();
                myChart.options.plugins.legend.labels.color = textMainColor;
                myChart.update();
            }, 350);
        });
    });
</script>
@endsection
