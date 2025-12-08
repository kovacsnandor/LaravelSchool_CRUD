<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseTransactions;
    //Létrehozunk és törlünk usert
        public function test_create_delete_user(): void
    {

        $data = [
            'name' => 'Tanuló 3',
            'email' => 'tanulo3@example.com',
            'password' => '123',
        ];
        $uri = '/api/users';

        $response = $this
            ->withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])
            ->postJson($uri, $data);
        // dd($response);

        $response->assertStatus(201);
        $this->assertDatabaseHas('users', ['email' => $data['email']]);

        $user = User::where('email', $data['email'])->first();
        $this->assertNotNull($user);

        //user törlés, ez így tiltott
        $id = $response->json('data')['id'];
        $uri = "/api/users/$id";

        $response = $this
            ->withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])
            ->deleteJson($uri);
            
        $response->assertStatus(401);                
    }

}
