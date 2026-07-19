@extends('layouts.app')

@section('title', 'Documents - Portfolio Manager')

@section('content')
<div class="card-custom p-4 mb-4">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div>
            <h4 class="fw-bold mb-1 text-main">Document Manager</h4>
            <p class="text-muted mb-0">Securely store and manage your CVs, ID copies, and general files.</p>
        </div>
        <a href="{{ route('documents.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
            <i class="fa-solid fa-file-arrow-up"></i> Upload Document
        </a>
    </div>
</div>

<div class="card-custom p-3 mb-4">
    <form action="{{ route('documents.index') }}" method="GET" class="row g-3 align-items-center">
        <div class="col-12 col-md-9">
            <div class="input-group">
                <span class="input-group-text bg-light text-muted border-end-0"><i class="fa-solid fa-magnifying-glass"></i></span>
                <input type="text" name="search" class="form-control border-start-0 bg-light" placeholder="Search by title or category..." value="{{ $search }}">
            </div>
        </div>
        <div class="col-12 col-md-3 d-flex gap-2">
            <button type="submit" class="btn btn-secondary w-100"><i class="fa-solid fa-filter me-2"></i> Search</button>
            @if(!empty($search))
                <a href="{{ route('documents.index') }}" class="btn btn-light border w-100">Clear</a>
            @endif
        </div>
    </form>
</div>

@if($documents->isEmpty())
    <div class="card-custom p-5 text-center">
        <img src="https://illustrations.popsy.co/blue/document-sign.svg" alt="No documents" style="width: 160px;" class="mb-4">
        <h5 class="fw-bold">No Documents Uploaded</h5>
        <p class="text-muted">Start storing your important files by clicking the upload button above.</p>
    </div>
@else
    <div class="card-custom p-4">
        <div class="table-responsive">
            <table class="table table-custom align-middle">
                <thead>
                    <tr>
                        <th style="width: 50px;">Type</th>
                        <th>Document Title</th>
                        <th>Category</th>
                        <th>Uploaded On</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($documents as $doc)
                        @php
                            $extension = strtolower(pathinfo($doc->file_path, PATHINFO_EXTENSION));
                            $icon = 'fa-file-lines text-secondary';
                            if ($extension === 'pdf') $icon = 'fa-file-pdf text-danger';
                            elseif (in_array($extension, ['doc', 'docx'])) $icon = 'fa-file-word text-primary';
                            elseif (in_array($extension, ['xls', 'xlsx', 'csv'])) $icon = 'fa-file-excel text-success';
                            elseif (in_array($extension, ['jpg', 'jpeg', 'png', 'webp'])) $icon = 'fa-file-image text-info';
                        @endphp
                        <tr>
                            <td class="text-center">
                                <i class="fa-solid {{ $icon }} fs-3"></i>
                            </td>
                            <td>
                                <span class="fw-bold text-main d-block">{{ $doc->title }}</span>
                                @if($doc->description)
                                    <span class="text-muted small text-truncate d-inline-block" style="max-width: 250px;">{{ $doc->description }}</span>
                                @endif
                            </td>
                            <td><span class="badge bg-secondary-subtle text-secondary">{{ $doc->category }}</span></td>
                            <td>{{ $doc->created_at->format('M d, Y') }}</td>
                            <td class="text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('documents.download', $doc->id) }}" class="btn btn-sm btn-success text-white" title="Download">
                                        <i class="fa-solid fa-download"></i>
                                    </a>
                                    <a href="{{ route('documents.edit', $doc->id) }}" class="btn btn-sm btn-light border" title="Edit">
                                        <i class="fa-solid fa-pen text-primary"></i>
                                    </a>
                                    <form action="{{ route('documents.destroy', $doc->id) }}" method="POST" onsubmit="return confirm('Delete this document?');" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-light border text-danger" title="Delete">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $documents->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endif
@endsection
