<?php

namespace Tests\Browser\Pages;

use App\Models\User;
use Laravel\Dusk\Browser;
use Laravel\Dusk\Page;

class Login extends Page
{

    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return route('login');
    }

    /**
     * Assert that the browser is on the page.
     *
     * @param  Browser  $browser
     * @return void
     */
    public function assert(Browser $browser)
    {
        $user = User::factory()->create(); // password
        $browser->type('@email', 'email@gmail.com')
            ->type('@password', 'admin')
            ->pressAndWaitFor('@submit')
            ->assertSee('These credentials do not match our records.');

        $browser->type('@email', $user->email)
            ->type('@password', 'password')
            ->pressAndWaitFor('@submit')
            ->assertRouteIs('subscribe');
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@email' => '[type="email"]',
            '@password' => '[type="password"]',
            '@submit' => '[type="submit"]',
        ];
    }
}
