<?php

namespace Tests\Unit;

use Tests\TestCase;

class RegisterTest extends TestCase
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

    public function testWithNoName()
    {
        $this->postJson('api/register', [
            'name' => '',
            'email' => 's.saad45@gmail.com',
            'password' => 'abc123',
            'password_confirmation' => 'abc123',
        ])
            ->assertStatus(422);
    }

    public function testWithNoEmail()
    {
        $this->postJson('api/register', [
            'name' => 'Saad Hassan',
            'email' => '',
            'password' => 'abc123',
            'password_confirmation' => 'abc123',
        ])
            ->assertStatus(422);
    }

    public function testWithInvalidEmail()
    {
        $this->postJson('api/register', [
            'name' => 'Saad Hassan',
            'email' => 'saad.hassan',
            'password' => 'abc123',
            'password_confirmation' => 'abc123',
        ])
            ->assertStatus(422);
    }

    public function testWithNoPassword()
    {
        $this->postJson('api/register', [
            'name' => 'Laravel test',
            'email' => 's.saad45@gmail.com',
            'password' => '',
            'password_confirmation' => 'abc123',
        ])
            ->assertStatus(422);
    }

    public function testWithPasswordLengthLessThanSix()
    {
        $this->postJson('api/register', [
            'name' => 'Saad Hassan',
            'email' => 's.saad45@gmail.com',
            'password' => 'abc123',
            'password_confirmation' => 'abc123',
        ])
            ->assertStatus(422);
    }

    public function testOk()
    {
        $this->postJson('api/register', [
            'name' => 'Saad Hassan',
            'email' => 's.saad45@gmail.com',
            'password' => 'abc123',
            'password_confirmation' => 'abc123',
        ])
            ->assertOk();
    }
}
