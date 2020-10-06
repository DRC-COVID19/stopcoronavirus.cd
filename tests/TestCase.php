<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Faker\Factory as Faker;
use App\Exceptions\Handler;
use Illuminate\Contracts\Debug\ExceptionHandler;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseMigrations, DatabaseTransactions;
    protected $faker;

    /**
     * Set up the test
     */
    protected function setUp():void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
        $this->disableExceptionHandling();
        $this->faker = Faker::create();

    }

    protected function disableExceptionHandling()
    {

        $this->app->instance(ExceptionHandler::class, new class extends Handler {
            public function __construct() {}

            public function report(\Throwable $e)
            {
                // no-op
            }

            public function render($request, \Throwable $e) {
                throw $e;
            }
        });
    }

    /**
     * Reset the migrations
     */
    protected function tearDown():void
    {
        $this->artisan('migrate:reset');
        parent::tearDown();
    }

}
