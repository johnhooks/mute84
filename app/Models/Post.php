<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory, SoftDeletes;

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
     *
     * @return \App\Models\User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the file associated with this post.
     *
     * @return \App\Models\Post
     */
    public function file()
    {
        return $this->belongsTo(File::class);
    }

    public function permalink()
    {
        return url('/') . '/' . $this->user->slug . '/audio/' . $this->slug;
    }
}
