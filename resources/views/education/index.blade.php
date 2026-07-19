@extends('layouts.app')

@section('title', 'Education - Portfolio Manager')

@section('content')
<div class="card-custom p-4 mb-4">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div>
            <h4 class="fw-bold mb-1 text-main">Education History</h4>
            <p class="text-muted mb-0">Record and track your academic journey, degrees, and institutions.</p>
        </div>
        <a href="{{ route('education.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
            <i class="fa-solid fa-plus"></i> Add Education
        </a>
    </div>
</div>

@if($education->isEmpty())
    <div class="card-custom p-5 text-center">
        <img src="https://illustrations.popsy.co/blue/graduation.svg" alt="No education" style="width: 160px;" class="mb-4">
        <h5 class="fw-bold">No Education History Found</h5>
        <p class="text-muted">Academic background is empty. Click the button above to record your first degree.</p>
    </div>
@else
    <div class="card-custom p-4">
        <div class="table-responsive">
            <table class="table table-custom align-middle">
                <thead>
                    <tr>
                        <th>School / University</th>
                        <th>Degree</th>
                        <th>Department</th>
                        <th>Period</th>
                        <th>GPA</th>
                        <th>Status</th>
                        <th>Certificate</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($education as $edu)
                        <tr>
                            <td>
                                <span class="fw-bold text-main d-block">{{ $edu->school_name }}</span>
                            </td>
                            <td><span class="text-main fw-semibold">{{ $edu->degree }}</span></td>
                            <td>{{ $edu->department ?? 'N/A' }}</td>
                            <td>
                                <span class="small">
                                    {{ \Carbon\Carbon::parse($edu->start_date)->format('M Y') }} - 
                                    {{ $edu->end_date ? \Carbon\Carbon::parse($edu->end_date)->format('M Y') : 'Present' }}
                                </span>
                            </td>
                            <td><span class="badge bg-light text-dark">{{ $edu->gpa ?? 'N/A' }}</span></td>
                            <td>
                                @php
                                    $badgeClass = 'bg-secondary';
                                    if (strtolower($edu->status) === 'completed' || strtolower($edu->status) === 'graduated') {
                                        $badgeClass = 'bg-success-subtle text-success';
                                    } elseif (strtolower($edu->status) === 'in progress' || strtolower($edu->status) === 'enrolled') {
                                        $badgeClass = 'bg-primary-subtle text-primary';
                                    }
                                @endphp
                                <span class="badge {{ $badgeClass }}">{{ ucfirst($edu->status) }}</span>
                            </td>
                            <td>
                                @if($edu->certificate_path)
                                    <a href="{{ route('education.download', $edu->id) }}" class="btn btn-sm btn-link text-decoration-none">
                                        <i class="fa-solid fa-file-arrow-down me-1"></i> Download
                                    </a>
                                @else
                                    <span class="text-muted small">None</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('education.edit', $edu->id) }}" class="btn btn-sm btn-light border" title="Edit"><i class="fa-solid fa-pen text-primary"></i></a>
                                    <form action="{{ route('education.destroy', $edu->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this education record?');" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-light border text-danger" title="Delete"><i class="fa-solid fa-trash-can"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $education->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endif
@endsection
