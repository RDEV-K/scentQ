<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Brand;
use App\Models\Order;
use App\Models\Gateway;
use App\Models\Payment;
use App\Models\Product;
use App\Models\SocialLink;
use App\Models\PurchaseOption;
use Database\Seeders\SocialLinkSeeder;
use App\Notifications\NewOrderNotification;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    // visit checkout page with empty cart
    public function test_visit_checkout_page_with_empty_cart_and_show_validation_message()
    {
        $this->actingAs($user = User::factory()->create());

        $response = $this->get(route('checkout.store'));

        $response->withSession(['errors' => 'Added To Cart']);
        $response->assertStatus(302);
    }

    // create order with no data
    public function test_create_order_without_any_data_and_show_validation_message()
    {
        // authenticate a user
        $this->actingAs($user = User::factory()->create());

        // brand create
        $brand = Brand::create([
            'name' => 'test brand',
            'slug' => 'test-brand',
        ]);

        // create a product
        $product = Product::create([
            'brand_id' => $brand->id,
            'title' => 'Product Pie',
            'slug' => 'product-pie',
            'type' => 'perfume',
            'additional_price' => '122',
            'stock' => 1222,
            'status' => 'published'
        ]);

        // create a purchase option
        $purchase_option = PurchaseOption::create([
            'product_id' => $product->id,
            'type' => 'one_time',
        ]);

        // add product into cart
        $cart = $this->post(route('cart-item.store'), [
            'product_id' => $product->id,
            'purchase_option_id' => $purchase_option->id,
        ]);

        $cart->withSession(['success' => 'Added To Cart']);

        $response = $this->post(route('checkout.store'));

        $response->assertSessionHasErrors([
            'name' => 'The name field is required.'
        ]);
        $response->assertSessionHasErrors([
            'email' => 'The email field is required.'
        ]);
        $response->assertSessionHasErrors([
            'line1' => 'The line1 field is required.'
        ]);
        $response->assertSessionHasErrors([
            'country' => 'The country field is required.'
        ]);
        $response->assertSessionHasErrors([
            'postal_code' => 'The postal code field is required.'
        ]);
        $response->assertSessionHasErrors([
            'phone' => 'The phone field is required.'
        ]);
    }

    public function test_create_order_with_send_email_without_any_errors()
    {
        // authenticate a user
        $this->actingAs($user = User::factory()->create([
            'first_name' => 'MD Khalil',
            'last_name' => 'Khan',
            'email' => 'devzkhalil@gmail.com',
        ]));

        // brand create
        $brand = Brand::create([
            'name' => 'test brand',
            'slug' => 'test-brand',
        ]);

        // create a product
        $product = Product::create([
            'brand_id' => $brand->id,
            'title' => 'Product Pie',
            'slug' => 'product-pie',
            'type' => 'perfume',
            'additional_price' => '122',
            'stock' => 1222,
            'status' => 'published'
        ]);

        // create a purchase option
        $purchase_option = PurchaseOption::create([
            'product_id' => $product->id,
            'type' => 'one_time',
        ]);

        // add product into cart
        $cart = $this->post(route('cart-item.store'), [
            'product_id' => $product->id,
            'purchase_option_id' => $purchase_option->id,
        ]);

        // product added success
        $cart->withSession(['success' => 'Added To Cart']);

        // create order
        $response = $this->post(route('checkout.store'), [
            'name' => $user->first_name . $user->last_name,
            'email' => $user->email,
            'line1' => 'Hatiya Noakhali',
            'country' => 'Bangladesh',
            'city' => 'Noakhali',
            'postal_code' => '1208',
            'phone' => '016442291',
            'gateway_id' => 1, // 1 means Stripe,
            'payment_method' => 'example_method'
        ]);
        $response->assertStatus(200);

        $order = Order::with(['payments'])->first();
        $address = $order->addresses()->first();

        // Email send
        Notification::fake();
        $user->notify(new NewOrderNotification($order, $address));
        Notification::assertSentTo($user, NewOrderNotification::class);
    }
}
