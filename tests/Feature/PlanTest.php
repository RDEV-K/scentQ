<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Meta;
use App\Models\Staff;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PlanTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_plan_page_visit_without_any_errors(): void
    {
        $user = Staff::create([
            'name' => 'test',
            'username' => 'test',
            'email' => 'test@mail.com',
            'password' => bcrypt('password'),
        ]);

        $this->actingAs($user, 'staff');

        $response = $this->get(route('staff.plan.index'));

        $response->assertStatus(200);
    }

    public function test_plan_create_page_visit_without_any_errors(): void
    {
        $user = Staff::create([
            'name' => 'test',
            'username' => 'test',
            'email' => 'test@mail.com',
            'password' => bcrypt('password'),
        ]);

        $this->actingAs($user, 'staff');

        $response = $this->get(route('staff.plan.create'));

        $response->assertStatus(200);
    }

    public function test_plan_store_without_any_errors(): void
    {
        $user = Staff::create([
            'name' => 'test',
            'username' => 'test',
            'email' => 'test@mail.com',
            'password' => bcrypt('password'),
        ]);

        $this->actingAs($user, 'staff');

        Meta::create([
            'holder_type' => null,
            'holder_id' => null, 
            'name' => 'cashier_stripe_fragrance_subscription',
            'content' => 'prod_Os4YVsAZUf95iz',
        ]);

        $response = $this->post(route('staff.plan.store',[
                'type' => 'personal',
                'name' => 'Test',
                'interval_count' => 1,
                'product_count' => 1,
                'price_par_product'	 => 12,
                'total_price' => 12,
                'stripe_id' => 'price_1O4KPVBHIlyP76EzF94twBeo',
                'domain' => 'scentq.com',
        ]));

        // $response->assertRedirect(route('staff.plan.index'));
        $response->assertSessionHasNoErrors();
    }
}
