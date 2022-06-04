<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function mockObject($class, $constructor = null)
    {
        if ($constructor) {
            $mock = \Mockery::mock($class, $constructor);
        } else {
            $mock = \Mockery::mock($class);
        }
        
        $this->app->instance($class, $mock);

        return $mock;
    }
}
