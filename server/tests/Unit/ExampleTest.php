<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_that_true_is_true(): void
    {
        $valami = true;
        $this->assertTrue($valami, "A valami az nem true: $valami");
    }

    public function test_theAssert_is_true(){
        $a = 7;
        $b = 5;
        $theAssert = $a > $b;
        $this->assertTrue($theAssert, "Az állítás nem igaz");
    }

    public function test_check_person_map(){
        $person = [
            'name' => 'roger',
            'age' => 18
        ];
        
        $age = 18;
        $key = "age";
        $name = "roger";
        $personPropertyCount = 2;
        $this->assertEquals($age, $person['age'], "Az 'age' nem $age");
        $this->assertArrayHasKey($key, $person, "A kulcs nem '$key'");
        $this->assertContains($name, $person, "Ez nem $name");
        $this->assertCount($personPropertyCount, $person, "A személy adatainak száma nem: $personPropertyCount");
        $this->assertIsArray($person,"Ez nem gyűjtemény");
        $this->assertIsString($name, "Ez nem sztring");
    }

}
