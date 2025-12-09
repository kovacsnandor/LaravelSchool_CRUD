<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestBase;

class ExampleTest extends TestBase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/api/x');
        //dd($response);
        $response->assertStatus(200);
        $response->assertSee('API');
    }

    public function test_user_login_logout()
    {
        //login admin
        $response = $this->login('tanar@example.com', '123');
        $response->assertStatus(200);

        //token
        $token = $this->myGetToken($response);

        //get
        $uri = '/api/users';
        $response = $this->myGet($uri, $token);
        //2xx: minden oké
        //4xx: klienshiba
        //5xx: serverhiba
        // $response->assertStatus(403);
       //$response->assertSuccessful();
       $response->assertClientError();

        //logout
        $response = $this->logout($token);
        $response->assertStatus(200);


    }
}
