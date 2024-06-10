<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attachment

class AttachmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Validate the uploaded file
        $request->validate([
            'attachment' => 'nullable|file|max:2048|mimes:jpeg, png, jpg',
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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
