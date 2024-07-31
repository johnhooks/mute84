<?php

namespace App\Livewire;

use App\Models\Post;
use App\Models\File;
use App\Rules\SlugFormat;
use App\Rules\SlugUnique;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostCreate extends Component
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

  /**
   * Boolean of whether the slug has been edited.
   *
   * @var boolean
   */
  public $slugEdited = false;

  protected function rules()
  {
    return [
      'post.title' => 'required|min:2|max:128',
      'post.description' => 'max:256',
      'file' => 'required|mimetypes:audio/mpeg|max:8000',
      'post.slug' => ['required', 'max:32', new SlugFormat, new SlugUnique],
      'post.status' => 'required|in:draft,unlisted,published',
    ];
  }

  public function mount(Post $post)
  {
    $this->post = $post;
  }

  public function updatedFile()
  {
    $this->validate([
      'file' => 'required|mimetypes:audio/mpeg|max:8000',
    ]);
  }

  public function updatedPostTitle()
  {
    if ($this->slugEdited) return;
    $this->post->slug = Str::slug($this->post->title, '-');
  }

  public function updatedPostSlug()
  {
    $this->slugEdited = true;
    $this->validateOnly('post.slug');
  }

  public function submit()
  {
    $this->authorize('create', Post::class);
    $this->validate();

    DB::beginTransaction();

    $user_id = Auth::user()->id;
    $file_path = $this->file->store('uploads', 'public');

    if (!$file_path) throw new \Exception('Unable to save uploaded file.');

    $file = new File();
    $file->name = $this->file->getClientOriginalName();
    $file->user_id = $user_id;
    $file->file_path = $file_path;
    $file->save();

    $this->post->user_id = $user_id;
    $this->post->file_id = $file->id;

    if ($this->post->status === 'published') {
      $this->post->published_at = Carbon::now();
    }

    $this->post->save();

    DB::commit();

    // Clean up temporary file
    $this->file->delete();

    return redirect()->route('posts.show', ['id' => $this->post->id]);
  }

  public function render()
  {
    return view('livewire.post-form');
  }
}
