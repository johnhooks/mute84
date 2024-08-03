<?php

namespace App\Http\Controllers;

use App\Exceptions\NotImplementedException;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $this->authorize('viewAny', Post::class);

        $posts = Post::all()->sortByDesc('created_at')->take(10);

        return view('post.list', ['posts' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $this->authorize('create', Post::class);

        return view('post.create', ['post' => new Post()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        // Handled by App\Livewire\PostCreate

        throw new NotImplementedException();
    }

    /**\
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $post = Post::find($id);

        $this->authorize('view', $post);

        return view('post.show', ['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);

        $this->authorize('update', $post);

        return view('post.edit', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     *
     * @return Response
     */
    public function update(Request $request, $id)
    {
        // Handled by App\Livewire\PostEdit

        throw new NotImplementedException();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function destroy($id): RedirectResponse
    {
        $post = Post::findOrFail($id);

        $this->authorize('delete', $post);

        Post::destroy($post->id);

        // @todo: should the file also be destroyed?

        return back()->with('status', 'File successfully deleted.');
    }
}
