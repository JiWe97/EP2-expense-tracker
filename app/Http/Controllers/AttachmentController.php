<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Attachment;

class AttachmentController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'attachment' => 'nullable|file|max:2048|mimes:jpeg,png,jpg',
        ]);

        // Define the file path and name
        $path = 'uploads/User_' . Auth::user()->id . '.png';

        // Check if a file already exists
        if (Storage::disk('public')->exists($path)) {
            // Delete the existing file
            Storage::disk('public')->delete($path);
        }

        // Store the new file
        $request->file('attachment')->storeAs('public', $path);

        // Store the path in the database user table
        $user = Auth::user();
        $user->profilepicture = $path;
        $user->save();

        return redirect()->back()->with('success', 'File uploaded successfully!');
    }

}
