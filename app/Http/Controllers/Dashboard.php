<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Post;

class Dashboard extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $posts = Post::with(['user', 'file'])->where('user_id', $user->id)->orderBy('updated_at', 'desc')->paginate(20);
        return view('dashboard', ['posts' => $posts, 'user' => $user]);
    }
}
