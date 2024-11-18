<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Brand;
use App\Models\Product;
use App\Models\PurchaseOption;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class QueueTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_add_to_queue_time_validation_show_without_product_entry()
    {
        // authenticate a user
        $this->actingAs($user = User::factory()->create());

        $response = $this->post(route('queue.push'));

        $response->assertStatus(302);
        $response->assertSessionHasErrors([
            'productId' => 'The product id field is required.'
        ]);
    }

    public function test_user_can_product_add_to_queue_without_errors()
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
        $response = $this->post(route('queue.push'), [
            'productId' => $product->id
        ]);
        $response->assertStatus(302);
    }

    public function test_the_user_can_successfully_sorting_product_in_my_queue_page()
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
        $response = $this->post(route('queue.push'), [
            'productId' => $product->id
        ]);
        $response->assertStatus(302);

        $queue = $user->queues()->first();
        $queue_item = $queue->items()->first();

        // // sorting product
        $request = $this->put(route('queue.sort'), [
            "to_month" => Carbon::now()->addMonths(1)->format('F'),
            "from_month" => Carbon::now()->format('F'),
            "item_id" => $queue_item->id,
            "new_add" => true,
            "replace_id" => $product->id
        ]);
        $request->assertStatus(302);
        $request->withSession(['status' => 'Queue updated.']);
    }
}
