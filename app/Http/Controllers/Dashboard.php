<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class Dashboard extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $files = User::find($user->id)->files()->latest()->take(10)->get();
        return view('dashboard', ['files' => $files]);
    }
}
