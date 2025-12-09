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

    private function login(string $email = 'admin@example.com', string $password = '123')
    {
        $uri = '/api/users/login';
        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
        $data = [
            'email' => $email,
            'password' => $password,
        ];
        $response = $this
            ->withHeaders($headers)
            ->postJson($uri, $data);

        return $response;
    }

    private function logout($token)
    {
        $uri = '/api/users/logout';
        $headers = [
            'Accept' => 'application/json',
            'Authorization' => "Bearer $token"
        ];
        $response = $this
            ->withHeaders($headers)
            ->postJson($uri);

        return $response;            
    }



    //Létrehozunk és törlünk usert
    public function test_create_delete_user(): void
    {

        $data = [
            'name' => 'Tanuló 3',
            'email' => 'tanulo3@example.com',
            'password' => '123',
        ];
        $uri = '/api/users';
        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];

        $response = $this
            ->withHeaders($headers)
            ->postJson($uri, $data);
        // dd($response);

        $response->assertStatus(201);
        $this->assertDatabaseHas('users', ['email' => $data['email']]);

        $user = User::where('email', $data['email'])->first();
        $this->assertNotNull($user);

        //user törlés, ez így tiltott, nem tudja letörölni.
        $id = $response->json('data')['id'];
        $uri = "/api/users/$id";

        $response = $this
            ->withHeaders($headers)
            ->deleteJson($uri);

        $response->assertStatus(401);
    }

    public function test_login()
    {
        //Csinálok egy user-t
        $data = [
            'name' => 'Tanuló 3',
            'email' => 'tanulo3@example.com',
            'password' => '123',
        ];
        $uri = '/api/users';
        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];

        $response = $this
            ->withHeaders($headers)
            ->postJson($uri, $data);

        $response->assertStatus(201);

        // $response = $this->login($data['email'], $data['password']);
        $response = $this->login();
        dd($response);
        $token = $response->json('data')['token'];
        $role = $response->json('data')['role'];

        $this->assertNotNull($token,"Bejelentkezés sikertelen");

        //Egy védett tartalmat próbáunk elérni: get api/users
        $uri = '/api/users';
        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => "Bearer $token"
        ];

        $response = $this
            ->withHeaders($headers)
            ->get($uri);

        //nem engedi
        // $response->assertStatus(403);
        $response->assertStatus(200);
        
        $response = $this->logout($token);
        $response->assertStatus(200);

    }
}
