<?php

use App\Http\Controllers\PaymentController;
use App\Http\Resources\KlaviyoProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::match(['get', 'post'], 'payment-ipn-receiver/{ref}', [PaymentController::class, 'ipnReceiver'])->name('payment.ipn');

Route::get('klaviyo/api', function () {

    $products = KlaviyoProductResource::collection(Product::with('brand')->get());
    return response()->json($products);
});
Route::get('/text', [\App\Http\Controllers\Staff\Textcontroller::class, 'getText']);
