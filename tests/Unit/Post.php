<?php

namespace Tests\Unit;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class Post extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    use RefreshDatabase;
    private $df = 'Y-m-d H:i:s';

    public function testCreateWithNoPost()
    {
        $this->createPost()->assertStatus(422);
    }

    public function testCreateOk()
    {
        $this->createPost('Post created from test')->assertOk();
    }

    public function testUpdateWithNoPost()
    {
        $this->updatePost()->assertStatus(422);
    }

    private function getUser()
    {
        $this->postJson('api/register', [
            'name' => 'Laravel test',
            'email' => 'laravel@test.com',
            'password' => 'test1234',
            'password_confirmation' => 'test1234',
        ]);
    }

    private function getToken()
    {
        $this->getUser();
        return $this->postJson('api/login', [
            'email' => 'laravel@test.com',
            'password' => 'test1234',
        ])
            ->decodeResponseJson('token');
    }

    private function createPost($post = null, $oneHourLess = false)
    {
        return $this->postJson('api/post',
            [
                'post' => $post,
                'created_at' => $oneHourLess
                    ? Carbon::now()->subMinutes(60)->format($this->df)
                    : Carbon::now()->format($this->df),
            ],
            [
                'Authorization' => 'Bearer ' . $this->getToken()
            ]);
    }

    private function updatePost($post = null, $oneHourLess = false)
    {
        $postId = $this->createPost('Post created from test', $oneHourLess)->decodeResponseJson('id');
        return $this->patchJson("api/post/{$postId}",
            [
                'post' => $post,
            ],
            [
                'Authorization' => 'Bearer ' . $this->getToken()
            ]);
    }
}
