<?php

namespace App\Http\Controllers;

use App\Http\Handlers\PostHandler;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    private $handler;

    public function __construct()
    {
        $this->handler = new PostHandler();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $response = $this->handler->getAll($request);

        return $this->sendResponse(200, $response, null);
    }

    /**
     * @param PostRequest $request
     * @return mixed
     */
    public function store(PostRequest $request)
    {
        $response = $this->handler->addPost($request);

        return $this->sendResponse(200, $response, null);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Post $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * @param PostRequest $request
     * @param Post $post
     * @return mixed
     * @throws \App\Exceptions\TimedOutException
     */
    public function update(PostRequest $request, Post $post)
    {
        $response = $this->handler->updatePost($request, $post);

        return $this->sendResponse(200, $response, null);
    }

    /**
     * @param Post $post
     * @return mixed
     * @throws \App\Exceptions\TimedOutException
     */
    public function destroy(Post $post)
    {
        $this->handler->deletePost($post);

        return $this->sendResponse(200, 'Successfully deleted.', null);
    }
}
