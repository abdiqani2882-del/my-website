<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Photo;

class PhotoController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->input('category');
        $query = Photo::where('user_id', Auth::id());
        
        if (!empty($category) && $category !== 'all') {
            $query->where('category', $category);
        }
        
        $photos = $query->latest()->paginate(12)->withQueryString();
        
        return view('photos.index', compact('photos', 'category'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:50'],
            'file' => ['required', 'image', 'mimes:jpeg,png,jpg,webp', 'max:8192'], // up to 8MB
        ]);

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('photos', 'public');
            
            Photo::create([
                'user_id' => Auth::id(),
                'title' => $request->title,
                'category' => $request->category,
                'file_path' => $path,
            ]);
        }

        return redirect()->route('photos.index', ['category' => $request->category])
            ->with('success', 'Photo uploaded successfully.');
    }

    public function destroy(Photo $photo)
    {
        if ($photo->user_id !== Auth::id()) {
            abort(403);
        }

        if ($photo->file_path) {
            Storage::disk('public')->delete($photo->file_path);
        }

        $photo->delete();

        return back()->with('success', 'Photo deleted successfully.');
    }

    public function download(Photo $photo)
    {
        if ($photo->user_id !== Auth::id()) {
            abort(403);
        }

        if ($photo->file_path && Storage::disk('public')->exists($photo->file_path)) {
            $fileName = ($photo->title ?? 'photo_' . $photo->id) . '.' . pathinfo($photo->file_path, PATHINFO_EXTENSION);
            return Storage::disk('public')->download($photo->file_path, $fileName);
        }

        return back()->with('error', 'File not found on server.');
    }
}
