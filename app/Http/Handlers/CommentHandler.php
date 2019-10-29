<?php


namespace App\Http\Handlers;


use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentHandler
{
    /**
     * @param Request $request
     * @param Post $post
     * @return Comment
     */
    public function addComment(Request $request): Comment
    {
        $comment = new Comment([
            'comment' => $request->get('comment'),
            'user_id' => Auth::user()->id,
            'post_id' => $request->get('post_id')
        ]);

        $comment->save();

        return $comment;
    }
}
