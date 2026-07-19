@extends('layouts.app')

@section('title', 'Settings - Portfolio Manager')

@section('content')
<div class="card-custom p-4 mb-4">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div>
            <h4 class="fw-bold mb-1 text-main">System Settings</h4>
            <p class="text-muted mb-0">Manage your account security and data backups.</p>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Password Update -->
    <div class="col-12 col-lg-6">
        <div class="card-custom p-4 h-100">
            <h5 class="fw-bold mb-4 border-bottom pb-3"><i class="fa-solid fa-lock text-primary me-2"></i> Change Password</h5>
            
            <form action="{{ route('settings.password') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold">Current Password</label>
                    <input type="password" name="current_password" class="form-control" required>
                    @error('current_password')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-semibold">New Password</label>
                    <input type="password" name="password" class="form-control" required>
                    @error('password')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label class="form-label fw-semibold">Confirm New Password</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>
                
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-key me-2"></i> Update Password</button>
            </form>
        </div>
    </div>

    <!-- System Backup -->
    <div class="col-12 col-lg-6">
        <div class="card-custom p-4 h-100 bg-light border-0">
            <h5 class="fw-bold mb-4 border-bottom pb-3"><i class="fa-solid fa-database text-primary me-2"></i> Database Backup</h5>
            
            <div class="d-flex flex-column align-items-center text-center p-4">
                <i class="fa-solid fa-server text-secondary mb-3" style="font-size: 48px;"></i>
                <h6 class="fw-bold">Export Complete SQL Backup</h6>
                <p class="text-muted small mb-4">Generate and download a complete .sql dump of your current database structure and data. Keep this safe for restoration purposes.</p>
                
                <form action="{{ route('settings.backup') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-dark d-flex align-items-center gap-2 px-4 py-2">
                        <i class="fa-solid fa-download"></i> Generate SQL Backup
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
