@extends('layouts.app')

@section('title', 'Photo Gallery - Portfolio Manager')

@section('styles')
<style>
    .gallery-item {
        position: relative;
        overflow: hidden;
        border-radius: 12px;
        box-shadow: var(--shadow-sm);
        aspect-ratio: 1 / 1;
        background-color: var(--border-color);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .gallery-item:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
    }
    
    .gallery-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    
    .gallery-item:hover .gallery-img {
        transform: scale(1.05);
    }
    
    .gallery-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 20px;
        background: linear-gradient(to top, rgba(15, 23, 42, 0.9) 0%, rgba(15, 23, 42, 0) 100%);
        color: #fff;
        opacity: 0;
        transform: translateY(20px);
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
    }
    
    .gallery-item:hover .gallery-overlay {
        opacity: 1;
        transform: translateY(0);
    }
    
    .gallery-actions {
        position: absolute;
        top: 10px;
        right: 10px;
        display: flex;
        gap: 8px;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .gallery-item:hover .gallery-actions {
        opacity: 1;
    }
</style>
@endsection

@section('content')
<div class="card-custom p-4 mb-4">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div>
            <h4 class="fw-bold mb-1 text-main">Photo Gallery</h4>
            <p class="text-muted mb-0">Organize and showcase your personal, event, and work-related photos.</p>
        </div>
        <button type="button" class="btn btn-primary d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#uploadModal">
            <i class="fa-solid fa-cloud-arrow-up"></i> Upload Photo
        </button>
    </div>
</div>

<!-- Filter Nav -->
<ul class="nav nav-pills mb-4 gap-2">
    <li class="nav-item">
        <a class="nav-link {{ empty($category) || $category == 'all' ? 'active bg-primary' : 'bg-white text-dark border' }}" href="{{ route('photos.index', ['category' => 'all']) }}">All Photos</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $category == 'personal' ? 'active bg-primary' : 'bg-white text-dark border' }}" href="{{ route('photos.index', ['category' => 'personal']) }}">Personal</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $category == 'event' ? 'active bg-primary' : 'bg-white text-dark border' }}" href="{{ route('photos.index', ['category' => 'event']) }}">Events</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $category == 'work' ? 'active bg-primary' : 'bg-white text-dark border' }}" href="{{ route('photos.index', ['category' => 'work']) }}">Work</a>
    </li>
</ul>

@if($photos->isEmpty())
    <div class="card-custom p-5 text-center">
        <img src="https://illustrations.popsy.co/blue/photographer.svg" alt="No photos" style="width: 180px;" class="mb-4">
        <h5 class="fw-bold">No Photos in this Category</h5>
        <p class="text-muted">Click the "Upload Photo" button above to add to your gallery.</p>
    </div>
@else
    <div class="row g-4">
        @foreach($photos as $photo)
            <div class="col-12 col-sm-6 col-md-4 col-xl-3">
                <div class="gallery-item">
                    <img src="{{ asset('storage/' . $photo->file_path) }}" alt="{{ $photo->title ?? 'Photo' }}" class="gallery-img">
                    
                    <div class="gallery-actions">
                        <a href="{{ route('photos.download', $photo->id) }}" class="btn btn-sm btn-light rounded-circle shadow-sm" style="width: 32px; height: 32px; padding: 5px;" title="Download">
                            <i class="fa-solid fa-download text-success"></i>
                        </a>
                        <form action="{{ route('photos.destroy', $photo->id) }}" method="POST" onsubmit="return confirm('Delete this photo permanently?');" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-light rounded-circle shadow-sm" style="width: 32px; height: 32px; padding: 5px;" title="Delete">
                                <i class="fa-solid fa-trash text-danger"></i>
                            </button>
                        </form>
                    </div>

                    <div class="gallery-overlay">
                        <h6 class="mb-1 fw-bold text-truncate" title="{{ $photo->title }}">{{ $photo->title ?? 'Untitled Photo' }}</h6>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge bg-light text-dark text-capitalize">{{ $photo->category }}</span>
                            <small class="opacity-75">{{ $photo->created_at->format('M d, Y') }}</small>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-5">
        {{ $photos->links('pagination::bootstrap-5') }}
    </div>
@endif

<!-- Upload Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 12px; border: none;">
            <div class="modal-header border-bottom">
                <h5 class="modal-title fw-bold" id="uploadModalLabel"><i class="fa-solid fa-cloud-arrow-up text-primary me-2"></i> Upload Photo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('photos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Photo Title (Optional)</label>
                        <input type="text" name="title" class="form-control" placeholder="e.g. Conference 2023">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
                        <select name="category" class="form-select" required>
                            <option value="personal">Personal</option>
                            <option value="event">Event</option>
                            <option value="work">Work</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Select Image <span class="text-danger">*</span></label>
                        <input type="file" name="file" class="form-control" accept="image/*" id="photoUploadInput" required>
                        <small class="text-muted">JPG, PNG, WEBP. Max size: 8MB.</small>
                    </div>
                    <div class="mt-3 text-center d-none" id="photoPreviewContainer">
                        <img src="" alt="Preview" id="photoPreviewImg" class="img-fluid rounded shadow-sm" style="max-height: 200px;">
                    </div>
                </div>
                <div class="modal-footer border-top bg-light" style="border-radius: 0 0 12px 12px;">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-check me-2"></i> Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const input = document.getElementById('photoUploadInput');
        const preview = document.getElementById('photoPreviewImg');
        const container = document.getElementById('photoPreviewContainer');

        if (input) {
            input.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        container.classList.remove('d-none');
                    }
                    reader.readAsDataURL(file);
                } else {
                    container.classList.add('d-none');
                }
            });
        }
    });
</script>
@endsection
