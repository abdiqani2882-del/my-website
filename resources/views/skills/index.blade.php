@extends('layouts.app')

@section('title', 'Skills - Portfolio Manager')

@section('styles')
<style>
    .skill-progress {
        height: 8px;
        border-radius: 10px;
        background-color: #E2E8F0;
        overflow: hidden;
    }
    .skill-progress .progress-bar {
        border-radius: 10px;
        transition: width 1.5s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .dark-mode .skill-progress {
        background-color: #334155;
    }
</style>
@endsection

@section('content')
<div class="card-custom p-4 mb-4">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div>
            <h4 class="fw-bold mb-1 text-main">Skills Proficiency</h4>
            <p class="text-muted mb-0">Manage your technical and soft skills, grouped by category.</p>
        </div>
        <a href="{{ route('skills.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
            <i class="fa-solid fa-plus"></i> Add Skill
        </a>
    </div>
</div>

@if($groupedSkills->isEmpty())
    <div class="card-custom p-5 text-center">
        <img src="https://illustrations.popsy.co/blue/graphic-design.svg" alt="No skills" style="width: 160px;" class="mb-4">
        <h5 class="fw-bold">No Skills Found</h5>
        <p class="text-muted">You haven't listed any skills yet. Add some to showcase your capabilities.</p>
    </div>
@else
    <div class="row g-4">
        @php
            $colors = ['primary', 'success', 'warning', 'info', 'danger'];
            $colorIndex = 0;
        @endphp

        @foreach($groupedSkills as $category => $skillsList)
            @php
                $themeColor = $colors[$colorIndex % count($colors)];
                $colorIndex++;
            @endphp
            <div class="col-12 col-xl-6">
                <div class="card-custom p-4 h-100">
                    <h5 class="fw-bold mb-4 text-{{ $themeColor }} border-bottom pb-2">{{ $category }}</h5>
                    
                    <div class="list-group list-group-flush">
                        @foreach($skillsList as $skill)
                            <div class="list-group-item bg-transparent border-0 px-0 py-3 position-relative group-hover">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div>
                                        <span class="fw-semibold text-main">{{ $skill->name }}</span>
                                        @if($skill->experience)
                                            <span class="text-muted small ms-2 border-start ps-2">{{ $skill->experience }}</span>
                                        @endif
                                    </div>
                                    <div class="d-flex align-items-center gap-3">
                                        <span class="fw-bold text-{{ $themeColor }}">{{ $skill->level }}%</span>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-light rounded-circle" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="width: 28px; height: 28px; padding: 0;">
                                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end shadow border-0" style="border-radius: 8px;">
                                                <li><a class="dropdown-item py-2" href="{{ route('skills.edit', $skill->id) }}"><i class="fa-solid fa-pen me-2 text-muted"></i> Edit</a></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <form action="{{ route('skills.destroy', $skill->id) }}" method="POST" onsubmit="return confirm('Delete this skill?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item py-2 text-danger"><i class="fa-solid fa-trash me-2"></i> Delete</button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="skill-progress w-100">
                                    <div class="progress-bar bg-{{ $themeColor }}" role="progressbar" style="width: 0%;" data-target-width="{{ $skill->level }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Animate progress bars
        setTimeout(() => {
            const bars = document.querySelectorAll('.progress-bar');
            bars.forEach(bar => {
                const targetWidth = bar.getAttribute('data-target-width');
                bar.style.width = targetWidth;
            });
        }, 100);
    });
</script>
@endsection
