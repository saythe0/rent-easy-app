<?php

namespace App\Observers;

use App\Models\Post;
use Illuminate\Support\Facades\Storage;

class PostObserver
{
    /**
     * Handle the Post "created" event.
     */
    public function created(Post $post): void
    {
        //
    }

    /**
     * Handle the Post "updated" event.
     */
    public function updated(Post $post): void
    {
        $old = $post->getOriginal('image_path');
        $new = $post->image_path;

        if ($old && $old !== $new && Storage::disk('public')->exists($old)) {
            Storage::disk('public')->delete($old);
        }
    }

    /**
     * Handle the Post "deleted" event.
     */
    public function deleted(Post $post): void
    {
        if (Storage::disk('public')->exists($post->image_path)) {
            Storage::disk('public')->delete($post->image_path);
        }
    }
}
