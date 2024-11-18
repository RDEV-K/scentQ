<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Brand;
use App\Models\Order;
use App\Models\Staff;
use App\Models\Product;
use App\Models\PurchaseOption;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use App\Notifications\OrderUpdateNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SendEmailTest extends TestCase
{
    use RefreshDatabase;

    public function test_send_order_status_changed_email_to_user_successfully()
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

        // Email send
        Notification::fake();
        $user->notify(new OrderUpdateNotification($order));
        Notification::assertSentTo($user, OrderUpdateNotification::class);
    }
}
