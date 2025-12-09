<?php

namespace Tests\Feature;

use App\Models\Playingsport;
use App\Models\Schoolclass;
use App\Models\Sport;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\TestBase;
use PHPUnit\Framework\Attributes\DataProvider;

class PingTest extends TestBase
{
    use DatabaseTransactions;
    private static $dataUser = [
        "name" =>  "Tanuló3",
        "email" => "tanulo3@example.com",
        "password" => "123"
    ];

    private static $dataSchoolclass = [
        "osztalyNev" =>  "8d",
    ];
    private static $dataSport = [
        "sportNev" =>  "Táj csí1",
    ];

    private static $dataStudent = [
        "diakNev" => "Tóth Márton",
        "schoolclassId" => 3,
        "neme" => true,
        "iranyitoszam" => "4024",
        "lakHelyseg" => "Debrecen",
        "lakCim" => "Kossuth utca 18.",
        "szulHelyseg" => "Nyíregyháza",
        "szulDatum" => "2007-11-23",
        "igazolvanyszam" => "AB123456",
        "atlag" => 3.7,
        "osztondij" => 25000
    ];

    private static $dataPlayngSport = [
        "studentId" => 1,
        "sportId" => 8
    ];

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

    public static function tablesPostDeleteDataProvider(): array
    {
        return [
            'post-delete users admin' => ['users', 'admin@example.com', '123', true, true, self::$dataUser],
            'post-delete sports admin' => ['sports', 'admin@example.com', '123', true, true, self::$dataSport],
            'post-delete schoolclasses admin' => ['schoolclasses', 'admin@example.com', '123', true, true, self::$dataSchoolclass],
            'post-delete students admin' => ['students', 'admin@example.com', '123', true, true, self::$dataStudent],
            'post-delete playingsports admin' => ['playingsports', 'admin@example.com', '123', true, true, self::$dataPlayngSport],

            'post-delete users tanar' => ['users', 'tanar@example.com', '123', true, false, self::$dataUser],
            'post-delete sports tanar' => ['sports', 'tanar@example.com', '123', false, false, self::$dataSport],
            'post-delete schoolclasses tanar' => ['schoolclasses', 'tanar@example.com', '123', false, false, self::$dataSchoolclass],
            'post-delete students tanar' => ['students', 'tanar@example.com', '123', true, true, self::$dataStudent],
            'post-delete playingsports tanar' => ['playingsports', 'tanar@example.com', '123', false, false, self::$dataPlayngSport],

            'post-delete users diak1' => ['users', 'diak1@example.com', '123', true, false, self::$dataUser],
            'post-delete sports diak1' => ['sports', 'diak1@example.com', '123', false, false, self::$dataSport],
            'post-delete schoolclasses diak1' => ['schoolclasses', 'diak1@example.com', '123', false, false, self::$dataSchoolclass],
            'post-delete students diak1' => ['students', 'diak1@example.com', '123', false, false, self::$dataStudent],
            'post-delete playingsports diak1' => ['playingsports', 'diak1@example.com', '123', false, false, self::$dataPlayngSport],
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

    #[DataProvider('tablesPostDeleteDataProvider')]
    public function test_table_user_login_post_delete_logout($route, $email, $password, $expectedPostAccess,  $expectedDeletetAccess, $data)
    {
        //login
        $response = $this->login($email, $password);
        $response->assertStatus(200);

        //token
        $token = $this->myGetToken($response);

        //post tábla
        $uri = "/api/$route";
        $response = $this->myPost($uri, $data, $token);
        if ($expectedPostAccess) {
            //siker
            $response->assertSuccessful();
        } else {
            //hiba
            $response->assertClientError();
        }


        //delete tábla
        $table = $route;
        $uri = "/api/$table";
        $response = $this->myPost($uri, $data, $token);
        if ($expectedPostAccess) {
            # code...
            $response->assertSuccessful();
        } else {
            $response->assertClientError();
        }

        if ($table == "sports") {
            $response = Sport::factory()->create([
                "sportNev" => "Táj csí 3"
            ]);
        } else if ($table == 'users') {
            $response = User::factory()->create();
        } else if ($table == 'schoolclasses') {
            $response = Schoolclass::factory()->create([
                "osztalyNev" => "8x"
            ]);
        } else if ($table == 'students') {
            $response = Student::factory()->create();
        } else if ($table == 'playingsports') {
            $response = Playingsport::factory()->create();
        }

        $id = $response->id;
        $uri = $uri . "/$id";
        $response = $this->myDelete($uri, $token);
        if ($expectedDeletetAccess) {
            # code...
            $response->assertSuccessful();
        } else {
            $response->assertClientError();
        }

        //logout
        $response = $this->logout($token);
        $response->assertStatus(200);
    }
}
