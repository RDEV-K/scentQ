<?php

use Stripe\Stripe;
use App\Models\Faq;
use App\Models\Cart;
use App\Models\Meta;
use App\Models\Note;
use App\Models\Plan;
use App\Models\Term;
use App\Models\User;
use Inertia\Inertia;
use App\Jobs\TestJob;
use App\Models\Brand;
use App\Models\Order;
use App\Models\Queue;
use App\Models\Staff;
use App\Models\Coupon;
use App\Models\Review;
use App\Models\Payment;
use App\Models\Product;
use App\Models\FaqGroup;
use App\Models\QuizItem;
use App\Models\Taxonomy;
use Stripe\Subscription;
use App\Models\QueueItem;
use Stripe\PaymentIntent;
use App\Models\SocialLink;
use Illuminate\Support\Str;
use App\Models\OrderAddress;
use Illuminate\Http\Request;
use Laravel\Cashier\Cashier;
use App\Models\MailSubscriber;
use App\Models\ProductSubType;
use App\Models\QuizItemOption;
use Illuminate\Support\Carbon;
use App\Events\PaymentReceived;
use App\Models\ProductOfTheMonth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MiscController;
use App\Http\Controllers\QueueController;
use EonVisualMedia\LaravelKlaviyo\Klaviyo;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\WebhookController;
use Illuminate\Support\Facades\Notification;
use Spatie\WebhookClient\Models\WebhookCall;
use App\Notifications\OrderInvoiceToCustomer;
use EonVisualMedia\LaravelKlaviyo\TrackEvent;
use App\Http\Controllers\StripeWebhooksController;
use App\Notifications\SubscriptionAddedNotification;
use App\Jobs\StripeWebhooks\InvoicePaymentSucceededJob;
use App\Models\Address;
use App\Notifications\NewOrderNotification;
use App\Notifications\OrderUpdateNotification;


/* designed */

Route::group(['middleware' => ['redirect_uk_ip']], function () {
    Route::get('order/{order}/invoice/{type?}', [MiscController::class, 'invoice'])->name('order.invoice');
    Route::get('payment-success/{ref}', [PaymentController::class, 'successPayment'])->name('payment.success');
    Route::get('payment-failed/{ref}', [PaymentController::class, 'failedPayment'])->name('payment.failed');
    Route::get('r/{referralCode}', [\App\Http\Controllers\Auth\RegisterController::class, 'catchReferral'])->name('referral');
    Route::get('promo-mail/{email}/unsubscribe', [MiscController::class, 'unsubscribeFromMailList'])->middleware('signed')->name('mail.unsubscribe');

    Auth::routes();
    Route::get('social-auth/{provider}/redirect', [\App\Http\Controllers\Auth\SocialLoginController::class, 'redirect'])->name('social.redirect')->middleware('guest');
    Route::get('social-auth/{provider}/callback', [\App\Http\Controllers\Auth\SocialLoginController::class, 'callback'])->name('social.callback')->middleware('guest');
    Route::post('social-login/apple/callback', [\App\Http\Controllers\Auth\SocialLoginController::class, 'callback'])->middleware('guest');

    Route::get('/{gen?}', [App\Http\Controllers\MiscController::class, 'index'])->where('gen', 'men|women')->name('index');

// Product Routes
    Route::get('{productType}/{brandSlug}/{productSlug}', [MiscController::class, 'product'])->where('product_type', 'perfume|cologne|makeup|skincare|personal-care|extras')->name('product');
    Route::get('brands', [MiscController::class, 'brands'])->name('brands');
    Route::get('brand/{slug}', [MiscController::class, 'brand'])->name('brand');
    Route::get('filter-data', [MiscController::class, 'filterData'])->name('filter.data');
    Route::get('get-note-details', [MiscController::class, 'getNoteDetails'])->name('note.details');
    Route::get('product-of-the-month', [MiscController::class, 'getProductOfTheMonth'])->name('product.of.month');
    Route::get('month/{id}', [\App\Http\Controllers\MiscController::class, 'getProductMonth'])->name('product.month');
    Route::get('page/{slug}', [MiscController::class, 'getPage'])->name('page');
    Route::get('contact-us', [MiscController::class, 'contactUs'])->name('contact-us');
    Route::get('faq', [MiscController::class, 'faq'])->name('faq');
    Route::get('about-us', [MiscController::class, 'aboutUs'])->name('about-us');

    Route::post('subscriber', [MiscController::class, 'subscriber'])->name('subscriber');
    Route::post('get/plans', [MiscController::class, 'getPlans'])->name('get.plans');
    Route::post('get/recommendation-products', [MiscController::class, 'getRecommendationProduct'])->name('api.get.recommendation.products');
    Route::post('get/upcoming-shipment', [MiscController::class, 'getUpcomingShipment'])->name('api.get.upcoming.shipment');
    Route::post('get/subscription-data', [MiscController::class, 'getSubscriptionData'])->name('api.get.subscription.data');
    Route::post('get/random-product', [MiscController::class, 'getRandomProduct'])->name('api.get.random.product');

// Product Routes
    Route::get('smart-recommendations', [MiscController::class, 'smartRecommendations'])->name('quiz');
    Route::post('smart-recommendations', [MiscController::class, 'smartRecommendationsStore'])->name('quiz.store');

    Route::post('queue', [QueueController::class, 'push'])->name('queue.push');
    Route::post('queue/custom', [QueueController::class, 'pushCustom'])->name('queue.push.custom');

    Route::get('collections-{type}/{slug}', [\App\Http\Controllers\MiscController::class, 'singleCollection'])->name('collection')->where('type', 'men|women');
    Route::get('subscription/collections-{type}', [\App\Http\Controllers\MiscController::class, 'collections'])->name('collections')->where('type', 'men|women');
    Route::get('subscription/{type}-of-the-month', [\App\Http\Controllers\MiscController::class, 'productOfTheMonth'])->name('productOfTheMonth')->where('type', 'perfume|cologne');
    Route::get('section-data/{section}', [\App\Http\Controllers\SectionController::class, 'sectionData'])->name('section.data');

    Route::get('ajax/{method}', [\App\Http\Controllers\AjaxController::class, 'handle'])->name('ajax');

    Route::group(['middleware' => 'auth'], function () {
        Route::get('order-track/{order}/', [\App\Http\Controllers\OrderController::class, 'show'])->name('order.track');

        Route::post('send-ref-link', [MiscController::class, 'sendRefLink'])->name('ref.send');

        Route::get('checkout', [\App\Http\Controllers\OrderController::class, 'create'])->name('checkout');
        Route::post('coupon', [\App\Http\Controllers\CartItemController::class, 'attachCoupon'])->name('coupon.attach');
        Route::delete('coupon', [\App\Http\Controllers\CartItemController::class, 'detachCoupon'])->name('coupon.detach');
        Route::post('checkout', [\App\Http\Controllers\OrderController::class, 'store'])->name('checkout.store');

        Route::post('queue/{queueItem}', [QueueController::class, 'pop'])->name('queue.pop');
        Route::post('queue/destroy/{queueItem}', [QueueController::class, 'destroy'])->name('queue.destroy');
        Route::put('queue', [QueueController::class, 'sort'])->name('queue.sort');
        Route::post('add/to/queue', [QueueController::class, 'addToQueueFromSub'])->name('add.queue.from.subscribe');
        Route::get('queue-purchase', [MiscController::class, 'queuePurchasePage'])->name('queue.purchase');
        Route::post('queue-purchase', [MiscController::class, 'queuePurchase'])->name('queue.purchase.store');
        Route::get('rating-history', [MiscController::class, 'ratingHistory'])->name('rating-history');

        Route::get('/subscribe/{select_plan?}', [App\Http\Controllers\SubscriptionController::class, 'subscribe'])->middleware('not_subscribed')->name('subscribe');
        Route::get('/check-plan-cart', [App\Http\Controllers\SubscriptionController::class, 'checkPlanCart'])->middleware('not_subscribed')->name('check.plan.cart');
        Route::get('/resubscribe', [App\Http\Controllers\SubscriptionController::class, 'resubscribe'])->name('resubscribe');
        Route::post('/subscribe', [App\Http\Controllers\SubscriptionController::class, 'subscribeStore'])->middleware('not_subscribed')->name('subscribe.store');
        Route::post('/subscribe/coupon', [App\Http\Controllers\SubscriptionController::class, 'subscribeCouponCheck'])->middleware('not_subscribed')->name('subscribe.coupon');
        Route::delete('/subscribe/coupon', [App\Http\Controllers\SubscriptionController::class, 'subscribeCouponRemove'])->middleware('not_subscribed')->name('subscribe.coupon.destroy');
        Route::put('/subscribe', [App\Http\Controllers\SubscriptionController::class, 'subscribeUpdate'])->middleware('subscribed')->name('subscribe.update');
        Route::resource('cart-item', 'CartItemController')->only(['index', 'store', 'update', 'destroy']);
        Route::post('remove/subscribe/items', [MiscController::class, 'removeSubscriptionItems'])->name('remove.subscription.items');

        Route::get('subscription-info', [App\Http\Controllers\HomeController::class, 'subscriptionInfo'])->name('subscription.info');
        Route::get('/change-password', [App\Http\Controllers\MiscController::class, 'showPasswordForm'])->name('changePassword');
        Route::post('/change-password', [App\Http\Controllers\MiscController::class, 'updatePassword'])->name('updatePassword');
        Route::get('/personal-info', [App\Http\Controllers\MiscController::class, 'showPersonalInfoForm'])->name('PersonalInfo');
        Route::post('/personal-info', [App\Http\Controllers\MiscController::class, 'updatePersonalInfo'])->name('updatePersonalInfo');

        // Route::get('/home/{gen?}', [App\Http\Controllers\HomeController::class, 'index'])->where('gen', 'men|women')->name('home');
        Route::get('queue', [\App\Http\Controllers\HomeController::class, 'queue'])->name('queue');
        Route::get('address/{type?}', [\App\Http\Controllers\HomeController::class, 'address'])->name('address');
        Route::put('address/{type?}', [\App\Http\Controllers\HomeController::class, 'addressUpdate'])->name('address.put');
        Route::delete('address/destroy/{orderAddress}', [\App\Http\Controllers\HomeController::class, 'addressDestroy'])->name('address.destroy');
        Route::post('card/declined/mail', [MiscController::class, 'cardDeclinedMail'])->name('card.declined.mail');

        // Product Listing Routes
        Route::post('review', [\App\Http\Controllers\ReviewController::class, 'store'])->name('review.store');
        Route::put('review/update/{review}', [\App\Http\Controllers\ReviewController::class, 'update'])->name('review.update');
        Route::post('review/vote', [\App\Http\Controllers\ReviewController::class, 'vote'])->name('review.vote');
        Route::post('review/refresh', [MiscController::class, 'refreshReviews'])->name('review.refresh');

        Route::get('order/{type?}', [\App\Http\Controllers\OrderController::class, 'index'])->name('order')->where('type', 'subscription|orders');

        Route::group(['middleware' => 'subscribed'], function () {
            Route::get('personal-upgrade-details', [\App\Http\Controllers\SubscriptionController::class, 'personalUpgradeDetails'])->name('personalUpgradeDetails');
            Route::post('fragrance-cancel', [\App\Http\Controllers\SubscriptionController::class, 'fragranceCancel'])->name('fragrance.cancel');
            Route::post('fragrance-resume', [\App\Http\Controllers\SubscriptionController::class, 'fragranceResume'])->name('fragrance.resume');
            Route::post('upgrade/subscription', [\App\Http\Controllers\SubscriptionController::class, 'updateSubscription'])->name('upgrade.subscription');
        });

        Route::get('/manage-subscription/{type?}', [HomeController::class, 'manageSubscription'])->name('manage.subscription');
        Route::get('smart-recommendations/fromQuiz', [MiscController::class, 'recommendationsProducts'])->name('show.recommendation.products');
    });
    Route::get('subscription/{type}', [\App\Http\Controllers\MiscController::class, 'filter'])->name('filter')->where('type', implode('|', \App\Models\Product::$types));
    Route::get('gender/{type}', [\App\Http\Controllers\MiscController::class, 'filterGender'])->name('filterGender')->where('type', implode('|', \App\Models\Product::$types));

    Route::get('get/new-products', [MiscController::class, 'getNewProduct'])->name('api.get.new.products');
    Route::post('get/user-cart', [MiscController::class, 'getUserCart'])->name('api.get.user.cart');
    Route::get('recommendations/products', [MiscController::class, 'getRecommendationsProducts'])->name('get.recommendation.products');
    Route::post('get-recommendations/products/for-search', [MiscController::class, 'getRecommendationsProductsForSearch'])->name('get.recommendation.products.for.search');

    Route::get('filter/{type}/st/{slug}', [\App\Http\Controllers\MiscController::class, 'subFilter'])->name('filter.sub')->where('type', implode('|', \App\Models\Product::$types));
    Route::get('/text', [\App\Http\Controllers\Staff\Textcontroller::class, 'getText'])->name('admin.data');
// Route::get('/new-arrivals/{type?}', function ($type = null) {

//     return inertia('NewArrivals', compact('type'))->title('New Arrivals - The Latest and Greatest in Designer Fragrances');
// })->name('new.arrivals');
    Route::get('/new-arrivals/{type?}', [MiscController::class, 'newArrivals'])->name('new.arrivals');
    Route::post('/subscription/product/edit', [MiscController::class, 'subscriptionProductEdit'])->name('subscription.product.edit');

    Route::post('update_note', 'NoteExtraTextController@update');

    Route::get("faqs", [HomeController::class, "faqs"])->name("faqs");
    Route::get("testimonial/index", [HomeController::class, "fetchTestimonial"])->name("testimonial.index");
});
Route::stripeWebhooks('stripe-webhook');
// Route::post('stripe-webhook-uk/{webhook_secret}', [WebhookController::class, 'store']);

Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);
Route::get('failed-job', function () {
    DB::table('failed_jobs')->delete();

    return 'done';
});
Route::post('save-search/history', [MiscController::class, 'storeSearchHistory'])->name('save.search.history');

Route::get('payment-retrieve', function () {

    Stripe::setApiKey(config('services.stripe.secret'));

    $paymentIntents = PaymentIntent::all();

    // Check if there are any PaymentIntents
    if ($paymentIntents->count() > 0) {
        // Get the latest PaymentIntent from the collection
        $latestPaymentIntent = $paymentIntents->first();

        if ($latestPaymentIntent->status = 'requires_action') {
            return response()->json([
                'data' => $latestPaymentIntent,
                'status' => $latestPaymentIntent->status,
            ]);
        } else {
            return response()->json([
                'data' => null,
                'status' => null,
            ]);
        }
    } else {
        return response()->json([
            'data' => null,
            'status' => null,
        ]);
    }
});

// Route::get('/data-replace-from-primary-database', function () {

//     try {
//         $notes = Note::all();

//         foreach ($notes as $key => $note) {

//             try {
//                 $primary_note =  DB::connection('mysql_primary')->table('notes')->where('id', $note->id)->first();
//                 if ($primary_note) {
//                     $note->update([
//                         'image' => $primary_note->image
//                     ]);
//                 }
//             } catch (\Throwable $th) {
//                 Log::error($th->getMessage());
//             }
//         }
//     } catch (\Throwable $th) {
//         Log::error($th->getMessage());
//     }

//     return 'done';
// });


include base_path('routes/command.php');
