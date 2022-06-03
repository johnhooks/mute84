<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\File;


class FileUpload extends Controller
{
    public function createForm()
    {
        return view('file-upload');
    }

    public function fileUpload(Request $req)
    {
        $user = Auth::user();
        $req->validate([
            'file' => 'required|mimetypes:audio/mpeg|max:8000',
            'name' => 'required|min:1|max:128'
        ]);

        $fileModel = new File();

        if ($req->file()) {
            $fileName = time() . '_' . $req->file->getClientOriginalName();
            $filePath = $req->file('file')->store('uploads', 'public');
            $fileModel->user_id = $user->id;
            $fileModel->name = $req->name;
            $fileModel->file_path = $filePath;
            $fileModel->save();
            return back()
                ->with('success', 'File has been uploaded.')
                ->with('file', $fileName);
        }
    }
}
