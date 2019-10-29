<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class Comment extends TestCase
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

    public function testCreateWithNoPost()
    {
        $this->postJson('api/comment',
            [
                'comment' => 'First comment'
            ],
            [
                'Authorization' => 'Bearer ' . $this->getToken()
            ])
            ->assertStatus(422);
    }

    public function testCreateOk()
    {
        $this->postJson('api/comment',
            [
                'post_id' => $this->getPostId(),
                'comment' => 'This is my comment'
            ],
            [
                'Authorization' => 'Bearer ' . $this->getToken()
            ])
            ->assertOk();
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

    private function getPostId()
    {
        return $this->postJson('api/post',
            [
                'post' => 'Post created from test'
            ],
            [
                'Authorization' => 'Bearer ' . $this->getToken()
            ])
            ->decodeResponseJson('id');
    }
}
