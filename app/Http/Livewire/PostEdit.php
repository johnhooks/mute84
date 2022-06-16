<?php

namespace App\Http\Livewire;

use App\Models\Post;
use App\Models\File;
use App\Rules\SlugFormat;
use App\Rules\SlugUnique;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\TemporaryUploadedFile;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Validator;

class PostEdit extends Component
{
  use AuthorizesRequests;
  use WithFileUploads;

  /**
   * The post model.
   *
   * @var \App\Models\Post
   */
  public $post;

  /**
   * The post file
   *
   * @var TemporaryUploadedFile
   */
  public $file;

  protected function rules()
  {
    return [
      'post.title' => 'required|min:2|max:128',
      'post.description' => 'max:256',
      'file' => 'nullable|mimetypes:audio/mpeg|max:8000',
      'post.slug' => ['required', 'max:128', new SlugFormat, new SlugUnique],
      'post.status' => 'required|in:draft,unlisted,published',
    ];
  }

  public function mount(Post $post)
  {
    $this->post = $post;
  }

  public function updatedPostSlug()
  {
    $this->validateOnly('post.slug');
  }

  public function submit()
  {
    $this->authorizeForUser(Auth::user(), 'update', $this->post);
    $this->validate();

    $user_id = Auth::user()->id;

    DB::beginTransaction();

    if ($this->file !== null) {
      $file_path = $this->file->store('uploads', 'public');
      if (!$file_path) throw new \Exception('Unable to save uploaded file.');
      $file = new File();
      $file->name = $this->file->getClientOriginalName();
      $file->user_id = $user_id;
      $file->file_path = $file_path;
      $file->save();
      $this->post->file_id = $file->id;
    }

    if ($this->post->published_at === null && $this->post->status === 'published') {
      $this->post->published_at = Carbon::now();
    }

    $this->post->save();

    DB::commit();

    // Clean up temporary file
    if ($this->file !== null) $this->file->delete();

    session()->flash('message', 'Post successfully updated.');

    return redirect()->route('posts.show', ['id' => $this->post->id]);
  }

  public function render()
  {
    return view('livewire.post-form');
  }
}
