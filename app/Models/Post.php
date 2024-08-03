<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Post
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $body
 * @property string $slug
 * @property string $status
 * @property int $user_id
 * @property int $file_id
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon $deleted_at
 * @property \App\Models\User $user
 * @property \App\Models\File $file
 *
 * @package App\Models
 */
class Post extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * I don't know if this is the best. But it will work for right now.
     */
    protected $with = ['file'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'body',
    ];

    /**
     * The attribute default values.
     *
     * @var array<string, string>
     */
    protected $attributes = [
        'title' => '',
        'description' => '',
        'slug' => '',
        'status' => 'draft',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'user_id',
        'file_id',
    ];

    /**
     * Get the user that owns the post.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the file associated with this post.
     */
    public function file(): BelongsTo
    {
        return $this->belongsTo(File::class);
    }

    public function permalink()
    {
        return url('/') . '/' . $this->user->slug . '/audio/' . $this->slug;
    }
}
