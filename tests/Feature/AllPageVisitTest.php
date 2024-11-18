<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Plan;
use Inertia\Testing\Assert;
use App\Models\User;
use Inertia\Testing\AssertableInertia;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AllPageVisitTest extends TestCase
{
    use RefreshDatabase;

    // Home page visit test
    public function test_visit_home_page_without_any_error(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('Landing')
                    ->where('errors', [])
            );
    }

    // About us page visit test
    public function test_visit_about_us_page_without_any_error(): void
    {
        $this->get('/page/about-us')
            ->assertOk()
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('AboutUs')
                    ->where('errors', [])
            );
    }

    // Faq page visit test
    public function test_visit_faq_page_without_any_error(): void
    {
        $this->get('/faq')
            ->assertOk()
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('NewFaqs')
                    ->where('errors', [])
            );
    }

    // Brands page visit test
    public function test_visit_brands_page_without_any_error(): void
    {
        $this->get('/brands')
            ->assertOk()
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('AllBrands')
                    ->where('errors', [])
            );
    }

    // Perfume page visit test
    public function test_visit_perfume_page_without_any_error(): void
    {
        $this->get('/subscription/perfume')
            ->assertOk()
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('Filter')
                    ->where('errors', [])
            );
    }

    // Login page visit test
    public function test_visit_login_page_without_any_error(): void
    {
        $this->get('/login')
            ->assertOk()
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('Auth/Login')
                    ->where('errors', [])
            );
    }

    // Register page visit test
    public function test_visit_register_page_without_any_error(): void
    {
        $this->get('/register')
            ->assertOk()
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('Auth/Registration')
                    ->where('errors', [])
            );
    }

    // Quiz page visit test
    public function test_visit_quiz_page_without_any_error(): void
    {
        $this->get('/smart-recommendations')
            ->assertOk()
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('Quiz')
                    ->where('errors', [])
            );
    }

    // Terms Conditions page visit test
    public function test_visit_terms_conditions_page_without_any_error(): void
    {
        $this->get('/page/terms-and-conditions')
            ->assertOk()
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('Page')
                    ->where('errors', [])
            );
    }

    // Privacy Policy page visit test
    public function test_visit_privacy_policy_page_without_any_error(): void
    {
        $this->get('/page/privacy-policy')
            ->assertOk()
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('Page')
                    ->where('errors', [])
            );
    }

    // Order page visit test
    public function test_visit_user_order_page_without_any_error(): void
    {
        $this->actingAs($user = User::factory()->create());

        $this->get('/order')
            ->assertOk()
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('User/OrderHistory')
                    ->where('errors', [])
            );
    }

    // Queue page visit test
    public function test_visit_my_queue_page_without_any_error(): void
    {
        $this->actingAs($user = User::factory()->create());

        $this->get('/queue')
            ->assertOk()
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('User/Queue')
                    ->where('errors', [])
            );
    }

    // Buy Queue page visit test
    public function test_visit_buy_queue_page_without_any_error(): void
    {
        $this->actingAs($user = User::factory()->create());

        $this->get('/queue-purchase')
            ->assertOk()
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('QueuePurchase')
                    ->where('errors', [])
            );
    }

    // Subscribe page visit test
    public function test_visit_subscribe_page_without_any_error(): void
    {
        $this->actingAs($user = User::factory()->create());

        $domain = getCurrentDomain();

        $plan = Plan::create([
            'name' => 'Plan One',
            'domain' => $domain
        ]);

        $this->get('/subscribe')
            ->assertOk()
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('User/Subscribe')
                    ->where('errors', [])
            );
    }
}
