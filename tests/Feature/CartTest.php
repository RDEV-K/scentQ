<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Brand;
use App\Models\Product;
use App\Models\PurchaseOption;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_add_to_cart_validation_show()
    {
        // authenticate a user
        $this->actingAs($user = User::factory()->create());

        // add product into cart
        $response = $this->post(route('cart-item.store'));

        $response->assertSessionHasErrors([
            'product_id' => 'The product id field is required.'
        ]);
    }

    public function test_product_add_to_cart_without_errors()
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
    }
}
