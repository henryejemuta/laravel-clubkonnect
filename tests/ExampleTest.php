<?php

namespace HenryEjemuta\LaravelClubKonnect\Tests;

use HenryEjemuta\LaravelClubKonnect\ClubKonnectServiceProvider;
use Orchestra\Testbench\TestCase;

class ExampleTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [ClubKonnectServiceProvider::class];
    }

    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }
}
