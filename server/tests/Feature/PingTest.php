<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\TestBase;
use PHPUnit\Framework\Attributes\DataProvider;

class PingTest extends TestBase
{
    use DatabaseTransactions;

        public static function tablesGetDataProvider(): array
    {
        return [
            'get users admin: 200' => ['users', 'admin@example.com', '123', 200],
            'get usersme admin: 200' => ['usersme', 'admin@example.com', '123', 200],
            'get sports admin: 200' => ['sports', 'admin@example.com', '123', 200],
            'get schoolclasses admin: 200' => ['schoolclasses', 'admin@example.com', '123', 200],
            'get playingsports admin: 200' => ['playingsports', 'admin@example.com', '123', 200],
            'get students admin: 200' => ['students', 'admin@example.com', '123', 200],

            'get users tanar: 403' => ['users', 'tanar@example.com', '123', 403],
            'get usersme tanar: 200' => ['usersme', 'tanar@example.com', '123', 200],
            'get sports tanar: 200' => ['sports', 'tanar@example.com', '123', 200],
            'get schoolclasses tanar: 200' => ['schoolclasses', 'tanar@example.com', '123', 200],
            'get students tanar: 200' => ['students', 'tanar@example.com', '123', 200],
            'get playingsports tanar: 200' => ['playingsports', 'tanar@example.com', '123', 200],

            'get users diak1: 403' => ['users', 'diak1@example.com', '123', 403],
            'get usersme diak1: 200' => ['usersme', 'diak1@example.com', '123', 200],
            'get sports diak1: 200' => ['sports', 'diak1@example.com', '123', 200],
            'get schoolclasses diak1: 200' => ['schoolclasses', 'diak1@example.com', '123', 200],
            'get students diak1: 200' => ['students', 'diak1@example.com', '123', 200],
            'get playingsports diak1: 200' => ['playingsports', 'diak1@example.com', '123', 200],
        ];
    }


    //Attribútum: Megmonjuk, hogy mi a dataPrivider-e a függvénynek
    #[DataProvider('tablesGetDataProvider')]
    public function test_table_user_login_get_logout($route, $email, $password, $expectedStatus): void
    {
        //login
        $response = $this->login($email, $password);
        $response->assertStatus(200);

        //token
        $token = $this->myGetToken($response);

        //get tábla
        $uri = "/api/$route";
        $response = $this->myGet($uri, $token);
        $response->assertStatus($expectedStatus);

        //logout
        $response = $this->logout($token);
        $response->assertStatus(200);
    }
}
