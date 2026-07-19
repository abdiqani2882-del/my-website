@extends('layouts.app')

@section('title', 'Profile - Portfolio Manager')

@section('content')
<div class="row g-4">
    @if(!$profile)
        <!-- Profile Creation (Add Profile State) -->
        <div class="col-12 col-md-8 mx-auto">
            <div class="card-custom p-4">
                <h4 class="fw-bold mb-3"><i class="fa-solid fa-user-plus text-primary me-2"></i> Create Profile</h4>
                <p class="text-muted">No profile exists yet. Create one to fill in your bio, contact information, and social links.</p>
                <form action="{{ route('profile.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold">Full Name</label>
                            <input type="text" name="full_name" class="form-control" placeholder="John Doe" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="john@example.com" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold">Date of Birth</label>
                            <input type="date" name="date_of_birth" class="form-control">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold">Nationality</label>
                            <input type="text" name="nationality" class="form-control" placeholder="e.g. Somali">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Address</label>
                            <input type="text" name="address" class="form-control" placeholder="123 Street, City, Country">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold">Phone Number</label>
                            <input type="text" name="phone_number" class="form-control" placeholder="+252 61 XXXXXXX">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold">Profile Photo</label>
                            <input type="file" name="profile_photo" class="form-control" accept="image/*">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Biography</label>
                            <textarea name="biography" class="form-control" rows="4" placeholder="Write a short summary about yourself..."></textarea>
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="form-label fw-semibold"><i class="fa-brands fa-linkedin text-primary me-1"></i> LinkedIn</label>
                            <input type="url" name="linkedin" class="form-control" placeholder="https://linkedin.com/in/username">
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="form-label fw-semibold"><i class="fa-brands fa-github text-dark me-1"></i> GitHub</label>
                            <input type="url" name="github" class="form-control" placeholder="https://github.com/username">
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="form-label fw-semibold"><i class="fa-brands fa-facebook text-primary me-1"></i> Facebook</label>
                            <input type="url" name="facebook" class="form-control" placeholder="https://facebook.com/username">
                        </div>
                    </div>
                    <div class="mt-4 text-end">
                        <button type="submit" class="btn btn-primary px-4"><i class="fa-solid fa-floppy-disk me-2"></i> Save Profile</button>
                    </div>
                </form>
            </div>
        </div>
    @else
        <!-- Profile Details and Edit Forms (View/Edit/Delete States) -->
        <div class="col-12 col-lg-4">
            <div class="card-custom p-4 text-center h-100">
                <div class="position-relative d-inline-block mx-auto mb-3">
                    @php
                        $avatarUrl = $profile->profile_photo ? asset('storage/' . $profile->profile_photo) : 'https://ui-avatars.com/api/?name=' . urlencode($profile->full_name) . '&background=2563EB&color=ffffff&size=150';
                    @endphp
                    <img src="{{ $avatarUrl }}" alt="Profile Photo" class="rounded-circle shadow-sm border border-3 border-light" style="width: 130px; height: 130px; object-fit: cover;">
                </div>
                
                <h4 class="fw-bold mb-1 text-main">{{ $profile->full_name }}</h4>
                <p class="text-muted small mb-3"><i class="fa-solid fa-location-dot me-1"></i> {{ $profile->address ?? 'No Address Provided' }}</p>
                
                @if($profile->biography)
                    <div class="bg-light p-3 rounded mb-4 text-start" style="font-size: 0.925rem; max-height: 200px; overflow-y: auto;">
                        <span class="fw-bold text-main d-block mb-1">Biography</span>
                        <p class="text-muted mb-0">{{ $profile->biography }}</p>
                    </div>
                @endif

                <div class="d-flex justify-content-center gap-3 mb-4">
                    @if($profile->linkedin)
                        <a href="{{ $profile->linkedin }}" target="_blank" class="btn btn-outline-primary rounded-circle" style="width: 42px; height: 42px; padding: 8px 0;"><i class="fa-brands fa-linkedin-in"></i></a>
                    @endif
                    @if($profile->github)
                        <a href="{{ $profile->github }}" target="_blank" class="btn btn-outline-dark rounded-circle" style="width: 42px; height: 42px; padding: 8px 0;"><i class="fa-brands fa-github"></i></a>
                    @endif
                    @if($profile->facebook)
                        <a href="{{ $profile->facebook }}" target="_blank" class="btn btn-outline-info rounded-circle" style="width: 42px; height: 42px; padding: 8px 0;"><i class="fa-brands fa-facebook-f"></i></a>
                    @endif
                </div>

                <hr class="my-4">

                <!-- Danger Zone: Delete Profile -->
                <div class="text-start">
                    <span class="text-danger fw-semibold d-block mb-2 small">Danger Zone</span>
                    <button type="button" class="btn btn-outline-danger w-100 btn-sm" data-bs-toggle="modal" data-bs-target="#deleteProfileModal">
                        <i class="fa-solid fa-trash-can me-2"></i> Delete Profile
                    </button>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-8">
            <div class="card-custom h-100">
                <div class="card-header bg-transparent border-bottom p-0">
                    <ul class="nav nav-tabs border-0 px-4 pt-3" id="profileTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active fw-semibold border-0 text-main px-4 py-2" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button" role="tab" aria-controls="overview" aria-selected="true">
                                <i class="fa-solid fa-circle-info me-2 text-primary"></i> Overview
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link fw-semibold border-0 text-main px-4 py-2" id="edit-tab" data-bs-toggle="tab" data-bs-target="#edit" type="button" role="tab" aria-controls="edit" aria-selected="false">
                                <i class="fa-solid fa-user-gear me-2 text-primary"></i> Edit Profile
                            </button>
                        </li>
                    </ul>
                </div>
                <div class="card-body p-4">
                    <div class="tab-content" id="profileTabsContent">
                        <!-- Overview Tab -->
                        <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
                            <div class="row g-4">
                                <div class="col-12 col-sm-6">
                                    <span class="text-muted d-block small">Email Address</span>
                                    <span class="fw-semibold text-main">{{ $profile->email }}</span>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <span class="text-muted d-block small">Phone Number</span>
                                    <span class="fw-semibold text-main">{{ $profile->phone_number ?? 'N/A' }}</span>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <span class="text-muted d-block small">Date of Birth</span>
                                    <span class="fw-semibold text-main">
                                        {{ $profile->date_of_birth ? \Carbon\Carbon::parse($profile->date_of_birth)->format('M d, Y') : 'N/A' }}
                                    </span>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <span class="text-muted d-block small">Nationality</span>
                                    <span class="fw-semibold text-main">{{ $profile->nationality ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Edit Profile Tab -->
                        <div class="tab-pane fade" id="edit" role="tabpanel" aria-labelledby="edit-tab">
                            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row g-3">
                                    <div class="col-12 col-md-6">
                                        <label class="form-label fw-semibold">Full Name</label>
                                        <input type="text" name="full_name" class="form-control" value="{{ $profile->full_name }}" required>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="form-label fw-semibold">Email</label>
                                        <input type="email" name="email" class="form-control" value="{{ $profile->email }}" required>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="form-label fw-semibold">Date of Birth</label>
                                        <input type="date" name="date_of_birth" class="form-control" value="{{ $profile->date_of_birth }}">
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="form-label fw-semibold">Nationality</label>
                                        <input type="text" name="nationality" class="form-control" value="{{ $profile->nationality }}">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Address</label>
                                        <input type="text" name="address" class="form-control" value="{{ $profile->address }}">
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="form-label fw-semibold">Phone Number</label>
                                        <input type="text" name="phone_number" class="form-control" value="{{ $profile->phone_number }}">
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="form-label fw-semibold">Profile Photo</label>
                                        <input type="file" name="profile_photo" id="profile_photo_input" class="form-control" accept="image/*">
                                        <!-- Image Preview Div -->
                                        <div class="mt-2 d-none" id="preview_container">
                                            <span class="text-muted small d-block mb-1">New Image Preview:</span>
                                            <img id="profile_photo_preview" src="" alt="Preview" class="rounded-circle border" style="width: 60px; height: 60px; object-fit: cover;">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Biography</label>
                                        <textarea name="biography" class="form-control" rows="4">{{ $profile->biography }}</textarea>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label class="form-label fw-semibold"><i class="fa-brands fa-linkedin text-primary me-1"></i> LinkedIn</label>
                                        <input type="url" name="linkedin" class="form-control" value="{{ $profile->linkedin }}">
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label class="form-label fw-semibold"><i class="fa-brands fa-github text-dark me-1"></i> GitHub</label>
                                        <input type="url" name="github" class="form-control" value="{{ $profile->github }}">
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label class="form-label fw-semibold"><i class="fa-brands fa-facebook text-primary me-1"></i> Facebook</label>
                                        <input type="url" name="facebook" class="form-control" value="{{ $profile->facebook }}">
                                    </div>
                                </div>
                                <div class="mt-4 text-end">
                                    <button type="submit" class="btn btn-primary px-4"><i class="fa-solid fa-floppy-disk me-2"></i> Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div class="modal fade" id="deleteProfileModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteProfileModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="border-radius: 12px; border: none;">
                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title fw-bold" id="deleteProfileModalLabel">Delete Profile?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center py-4">
                        <i class="fa-solid fa-circle-exclamation text-danger fs-1 mb-3"></i>
                        <p class="mb-0">Are you sure you want to delete your profile? This will remove all biographical detail and your profile photo permanently. You can recreate one at any time.</p>
                    </div>
                    <div class="modal-footer border-0 pt-0 d-flex justify-content-between">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <form action="{{ route('profile.destroy') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger px-4">Delete Permanently</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
    // Live Image Preview script
    const photoInput = document.getElementById('profile_photo_input');
    const photoPreview = document.getElementById('profile_photo_preview');
    const previewContainer = document.getElementById('preview_container');

    if (photoInput) {
        photoInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    photoPreview.src = e.target.result;
                    previewContainer.classList.remove('d-none');
                }
                reader.readAsDataURL(file);
            } else {
                previewContainer.classList.add('d-none');
            }
        });
    }
</script>
@endsection
