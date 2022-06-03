<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\File;

class Dashboard extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $files = File::with('user')->orderBy('updated_at', 'desc')->paginate(20);
        // $files = File::orderBy('updated_at', 'desc')->paginate(20);
        return view('dashboard', ['files' => $files, 'user' => $user]);
    }
}
