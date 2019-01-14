<?php

namespace Tests\Unit;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUserCreation()
    {
        $response = $this->json('POST', 'api/register', [
            'name' => 'Demo User',
            'email' => str_random(10).'@demo.com',
            'password' => 'password'
        ]);

        $response->assertStatus(200)->assertJsonStructure([
            'success' => ['token', 'name']
        ]);
    }

    public function testUserLogin()
    {
        $response = $this->json('POST', 'api/login', [
            'email' => 'testemail@domain.com',
            'password' => 'password'
        ]);

        $response->assertStatus(200)->assertJsonStructure([
            'success' => ['token']
        ]);
    }

    public function testGetCategories()
    {
        $user = User::find(1);

        $response = $this->actingAs($user, 'api')
            ->json('GET', '/api/categories')
            ->assertStatus(200)
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'name',
                    'created_at',
                    'updated_at',
                    'deleted_at'
                ]
            ]);
    }
}
