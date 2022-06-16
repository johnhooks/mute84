<?php

namespace App\Rules;

use App\Models\User;
use App\Models\Post;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Support\Facades\Auth;

class SlugUnique implements Rule, DataAwareRule
{
    /**
     * All of the data under validation.
     *
     * @var array
     */
    protected $data = [];

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $id = $this->data['post']['id'] ?? null;
        if ($id) {
            $post = Post::select('slug')->where('id', $id)->first();
            // Check if the value changed
            if ($post->slug === $value) return true;
        }
        $match = Post::select('id')->where('user_id', Auth::user()->id)->where('slug', $value)->first();
        return $match === null;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute is already in use, it must be unique.';
    }

    /**
     * Set the data under validation.
     *
     * @param  array  $data
     * @return $this
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }
}
