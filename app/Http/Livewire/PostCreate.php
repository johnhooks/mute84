<?php

namespace App\Http\Livewire;

use App\Models\Post;
use App\Models\File;
use App\Rules\SlugFormat;
use App\Rules\SlugUnique;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;


class PostCreate extends Component
{
  use AuthorizesRequests;
  use WithFileUploads;

  /**
   * The post title
   *
   * @var string
   */
  public $title;

  /**
   * The post description
   *
   * @var string
   */
  public $description;

  /**
   * The post file
   *
   * @var UploadedFile
   */
  public $file;

  /**
   * The post description
   *
   * @var string
   */
  public $slug;

  /**
   * Boolean of whether the slug has been edited.
   *
   * @var boolean
   */
  public $slugEdited = false;

  /**
   * The post publish status
   *
   * @var string("draft", "unlisted", "published")
   */
  public $status = 'draft';

  protected function rules()
  {
    return [
      'title' => 'required|min:2|max:128',
      'description' => 'max:256',
      'file' => 'required|mimetypes:audio/mpeg|max:8000',
      'slug' => ['required', 'max:128', new SlugFormat, new SlugUnique],
      'status' => 'required|in:draft,unlisted,published',
    ];
  }

  public function mount(Post $post)
  {
    $this->fill([
      'title' => $post->title,
      'description' => $post->description,
      'slug' => $post->slug,
      'status' => $post->status,
    ]);
  }

  public function updatedTitle()
  {
    if ($this->slugEdited) return;
    $this->slug = Str::slug($this->title, '-');
  }

  public function updatedSlug()
  {
    $this->slugEdited = true;
  }

  public function submit()
  {
    $this->authorize('create', App\Models\Post::class);
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

    $post = new Post();
    $post->title = $this->title;
    $post->description = $this->description;
    $post->user_id = $user_id;
    $post->file_id = $file->id;
    $post->slug = $this->slug;
    $post->status = $this->status;

    if ($this->status == 'published') {
      $post->published_at = \Carbon\Carbon::now();
    }

    $post->save();

    DB::commit();

    return redirect()->route('posts.show', ['id' => $post->id]);
  }

  public function render()
  {
    return view('livewire.post-create');
  }
}
