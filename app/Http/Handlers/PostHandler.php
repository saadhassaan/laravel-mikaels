<?php

namespace App\Http\Handlers;

use App\Exceptions\TimedOutException;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostHandler
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function getAll(Request $request)
    {
        $limit = $request->get('limit') ?: 10;
        return Post::with(['likes', 'comments'])
            ->paginate($limit)
            ->items();
    }

    /**
     * @param Request $request
     * @return Post
     */
    public function addPost(Request $request): Post
    {
        $post = new Post([
            'post' => $request->get('post'),
            'user_id' => Auth::user()->id
        ]);
        $post->save();

        return $post;
    }

    /**
     * @param Request $request
     * @param Post $post
     * @return Post
     * @throws TimedOutException
     */
    public function updatePost(Request $request, Post $post)
    {
        if ($this->getDiffFromNow($post->created_at) <= 1) {
            $post->post = $request->get('post');
            $post->save();

            return $post;
        }

        throw new TimedOutException();
    }

    /**
     * @param Post $post
     * @throws TimedOutException
     */
    public function deletePost(Post $post)
    {
        if ($this->getDiffFromNow($post->created_at) <= 1) {

            $post->delete();

            return true;
        }

        throw new TimedOutException();
    }

    private function getDiffFromNow(Carbon $time)
    {
        return Carbon::now()->diffInHours($time);
    }


}
