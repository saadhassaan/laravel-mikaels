<?php


namespace App\Http\Handlers;


use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeHandler
{
    public function addLike(Request $request)
    {
        return Like::firstOrCreate([
            'post_id' => $request->get('post_id'),
            'user_id' => Auth::user()->id
        ]);
    }
}
