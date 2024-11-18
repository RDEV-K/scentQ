<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    protected function setUp(): void
    {
        parent::setUp();
        $this->withExceptionHandling();
        $this->artisan('scentq:seed')->expectsQuestion('What do you want to seed? all:a|taxonomy:t|page:p|gateway:g|notification template:nt', 'a');
    }
}


// namespace Tests;

// use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
// abstract class TestCase extends BaseTestCase
// {
//     use CreatesApplication;

//     protected function setUp(): void
//     {
//         parent::setUp();
//         $this->withExceptionHandling();
//         $this->artisan('scentq:seed')->expectsQuestion('What do you want to seed? all:a|taxonomy:t|page:p|gateway:g|notification template:nt', 'a');
//     }
// }
