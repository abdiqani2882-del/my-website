<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Certificate;
use App\Models\Photo;
use App\Models\WorkExperience;
use App\Models\Education;
use App\Models\Skill;
use App\Models\Document;

class DashboardController extends Controller
{
    /**
     * Show the main admin dashboard.
     */
    public function index()
    {
        $user = Auth::user();

        // Retrieve counts
        $totalCertificates = Certificate::where('user_id', $user->id)->count();
        $totalPhotos = Photo::where('user_id', $user->id)->count();
        $totalWorkExperiences = WorkExperience::where('user_id', $user->id)->count();
        $totalEducation = Education::where('user_id', $user->id)->count();
        $totalSkills = Skill::where('user_id', $user->id)->count();
        $totalDocuments = Document::where('user_id', $user->id)->count();

        // Fetch recent uploads (combining Certificates, Documents, Photos)
        $recentCertificates = Certificate::where('user_id', $user->id)
            ->latest()
            ->take(3)
            ->get()
            ->map(function ($item) {
                $item->type = 'Certificate';
                $item->icon = 'fa-award text-warning';
                $item->display_title = $item->title;
                $item->detail = $item->institution;
                return $item;
            });

        $recentDocuments = Document::where('user_id', $user->id)
            ->latest()
            ->take(3)
            ->get()
            ->map(function ($item) {
                $item->type = 'Document';
                $item->icon = 'fa-file-invoice text-primary';
                $item->display_title = $item->title;
                $item->detail = $item->category;
                return $item;
            });

        $recentPhotos = Photo::where('user_id', $user->id)
            ->latest()
            ->take(3)
            ->get()
            ->map(function ($item) {
                $item->type = 'Photo';
                $item->icon = 'fa-image text-success';
                $item->display_title = $item->title ?? 'Untitled Photo';
                $item->detail = ucfirst($item->category);
                return $item;
            });

        $recentUploads = $recentCertificates
            ->concat($recentDocuments)
            ->concat($recentPhotos)
            ->sortByDesc('created_at')
            ->take(5);

        // Recent Work & Education records
        $recentWork = WorkExperience::where('user_id', $user->id)
            ->latest()
            ->take(2)
            ->get();

        $recentEdu = Education::where('user_id', $user->id)
            ->latest()
            ->take(2)
            ->get();

        return view('dashboard', compact(
            'totalCertificates',
            'totalPhotos',
            'totalWorkExperiences',
            'totalEducation',
            'totalSkills',
            'totalDocuments',
            'recentUploads',
            'recentWork',
            'recentEdu'
        ));
    }

    /**
     * Perform global search across all tables.
     */
    public function search(Request $request)
    {
        $query = $request->input('query');
        $user = Auth::user();

        if (empty($query)) {
            return redirect()->route('dashboard');
        }

        $certificates = Certificate::where('user_id', $user->id)
            ->where(function($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('institution', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%");
            })->get();

        $education = Education::where('user_id', $user->id)
            ->where(function($q) use ($query) {
                $q->where('school_name', 'like', "%{$query}%")
                  ->orWhere('degree', 'like', "%{$query}%")
                  ->orWhere('department', 'like', "%{$query}%");
            })->get();

        $workExperiences = WorkExperience::where('user_id', $user->id)
            ->where(function($q) use ($query) {
                $q->where('company', 'like', "%{$query}%")
                  ->orWhere('job_title', 'like', "%{$query}%")
                  ->orWhere('job_description', 'like', "%{$query}%");
            })->get();

        $skills = Skill::where('user_id', $user->id)
            ->where(function($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('category', 'like', "%{$query}%");
            })->get();

        $documents = Document::where('user_id', $user->id)
            ->where(function($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('category', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%");
            })->get();

        $photos = Photo::where('user_id', $user->id)
            ->where(function($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('category', 'like', "%{$query}%");
            })->get();

        $totalResults = $certificates->count() + 
                       $education->count() + 
                       $workExperiences->count() + 
                       $skills->count() + 
                       $documents->count() + 
                       $photos->count();

        return view('search', compact(
            'query',
            'certificates',
            'education',
            'workExperiences',
            'skills',
            'documents',
            'photos',
            'totalResults'
        ));
    }
}
