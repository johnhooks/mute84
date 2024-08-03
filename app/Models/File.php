<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class File
 *
 * @property int $id
 * @property string $name
 * @property string $path
 * @property string $type
 * @property int $size
 * @property int $user_id
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \App\Models\User $user
 * @property \App\Models\Post $post
 *
 * @package App\Models
 */
class File extends Model
{
    use HasFactory;

    /**
     * Get the user that owns the file.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the post the file owns.
     */
    public function post(): HasOne
    {
        return $this->hasOne(Post::class);
    }
}
