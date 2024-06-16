<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FileUploadController extends Controller
{
    public function store(Request $request)
    {

        //Validate the uploaded file
        $request->validate([
            'my_file' => 'required|file|max:2048|mimes:jpeg, png, jpg',
        ]);

        //Define the file path and name
        $path = 'storage/app/public/uploads/User_' . Auth::user()->id . '.png';

        //Check if a file already exists
        if (Storage::disk('public')->exists($path)) {
            // Delete the existing file
            Storage::disk('public')->delete($path);
        }

        // Store the new file
        $request->file('my_file')->storeAs('public', $path);

        // store the path in the database user table
        $user = Auth::user();
        $user->profilepicture = $path;
        $user->save();

        return redirect()->back()->with('success', 'File uploaded successfully!');
    }
}
