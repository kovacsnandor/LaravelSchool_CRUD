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
}
