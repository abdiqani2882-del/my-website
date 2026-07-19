<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\WorkExperience;
use App\Models\Education;
use App\Models\Skill;
use App\Models\Certificate;
use App\Models\Profile;

class ReportController extends Controller
{
    public function index()
    {
        $profile = Profile::where('user_id', Auth::id())->first();
        $experiences = WorkExperience::where('user_id', Auth::id())->orderBy('start_date', 'desc')->get();
        $education = Education::where('user_id', Auth::id())->orderBy('start_date', 'desc')->get();
        $skills = Skill::where('user_id', Auth::id())->orderBy('level', 'desc')->get();
        $certificates = Certificate::where('user_id', Auth::id())->orderBy('issue_date', 'desc')->get();
        
        return view('reports.index', compact('profile', 'experiences', 'education', 'skills', 'certificates'));
    }

    public function export($type)
    {
        $userId = Auth::id();
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=export_{$type}_" . date('Y-m-d') . ".csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use ($type, $userId) {
            $file = fopen('php://output', 'w');

            if ($type === 'experiences') {
                fputcsv($file, ['Job Title', 'Company', 'Department', 'Start Date', 'End Date', 'Is Current', 'Description']);
                $records = WorkExperience::where('user_id', $userId)->orderBy('start_date', 'desc')->get();
                foreach ($records as $row) {
                    fputcsv($file, [$row->job_title, $row->company, $row->department, $row->start_date, $row->end_date, $row->is_current ? 'Yes' : 'No', $row->job_description]);
                }
            } elseif ($type === 'education') {
                fputcsv($file, ['Institution', 'Degree', 'Field of Study', 'Start Date', 'End Date', 'Is Current', 'Description']);
                $records = Education::where('user_id', $userId)->orderBy('start_date', 'desc')->get();
                foreach ($records as $row) {
                    fputcsv($file, [$row->institution, $row->degree, $row->field_of_study, $row->start_date, $row->end_date, $row->is_current ? 'Yes' : 'No', $row->description]);
                }
            } elseif ($type === 'skills') {
                fputcsv($file, ['Skill Name', 'Category', 'Level', 'Experience']);
                $records = Skill::where('user_id', $userId)->orderBy('category')->get();
                foreach ($records as $row) {
                    fputcsv($file, [$row->name, $row->category, $row->level . '%', $row->experience]);
                }
            } elseif ($type === 'certificates') {
                fputcsv($file, ['Certificate Name', 'Issuing Organization', 'Issue Date', 'Expiry Date', 'Credential ID']);
                $records = Certificate::where('user_id', $userId)->orderBy('issue_date', 'desc')->get();
                foreach ($records as $row) {
                    fputcsv($file, [$row->name, $row->issuing_organization, $row->issue_date, $row->expiry_date, $row->credential_id]);
                }
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
