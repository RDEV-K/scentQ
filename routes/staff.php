<?php

use App\Http\Controllers\Staff\CustomerController;
use App\Http\Controllers\Staff\FaqController;
use App\Http\Controllers\Staff\FaqGroupController;
use App\Http\Controllers\Staff\FirstMonthDiscountController;
use App\Http\Controllers\Staff\GatewayController;
use App\Http\Controllers\Staff\MenuController;
use App\Http\Controllers\Staff\MiscController;
use App\Http\Controllers\Staff\NotificationTemplateController;
use App\Http\Controllers\Staff\OrderController;
use App\Http\Controllers\Staff\SocialLinkController;
use App\Http\Controllers\Staff\TeamMemberController;
use App\Http\Controllers\Staff\TestimonialController;
use App\Http\Controllers\Staff\Textcontroller;
use App\Http\Controllers\Staff\TranslationController;
use App\Http\Controllers\Staff\WebhookController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Auth::routes(['register' => false, 'confirm' => false, 'verify' => false]);

Route::group(['middleware' => 'auth:staff'], function () {
    Route::group(['middleware' => 'able:manage_media', 'prefix' => 'media'], function () {
        \UniSharp\LaravelFilemanager\Lfm::routes();
    });

    Route::post('meta', [\App\Http\Controllers\Staff\MetaController::class, 'store'])->name('meta.store');

    // Product Related CRUD
    Route::resource('collection', 'CollectionController')->middleware('able:manage_collection');
    Route::resource('family', 'FamilyController')->middleware('able:manage_family');
    Route::resource('label', 'LabelController')->middleware('able:manage_label');
    Route::resource('brand', 'BrandController')->middleware('able:manage_brand');
    Route::resource('note', 'NoteController')->middleware('able:manage_note');
    Route::resource('badge', 'BadgeController')->middleware('able:manage_badge');

    Route::get('first-month-discount', [FirstMonthDiscountController::class, 'index'])->name('first.month.discount');
    Route::put('first-month-discount', [FirstMonthDiscountController::class, 'update'])->name('first.month.discount.update');

    Route::resource('taxonomy', 'TaxonomyController')->only('index', 'store', 'show', 'update', 'destroy')->middleware('able:manage_taxonomy');
    Route::resource('term', 'TermController')->only('index', 'store', 'update', 'destroy')->middleware('able:manage_taxonomy');
    // Product Related CRUD

    Route::resource("faq-group", FaqGroupController::class);
    Route::resource("faq", FaqController::class)->except("show");
    Route::resource("webhook", WebhookController::class);

    Route::resource("lang-translation", TranslationController::class);
    Route::resource("team-member", TeamMemberController::class);

    Route::get('dashboard', [MiscController::class, 'dashboard'])->name('dashboard');
    Route::get('profile', [MiscController::class, 'profile'])->name('profile');
    Route::put('profile', [MiscController::class, 'updateProfile'])->name('profile.update');

    Route::get('settings', [MiscController::class, 'settings'])->name('settings')->middleware('able:manage_setting');
    Route::put('settings', [MiscController::class, 'updateSettings'])->name('settings.update')->middleware('able:manage_setting');

    Route::post('social-link/store', [SocialLinkController::class, 'store'])->name('social-link.store');
    Route::get('social-link/edit/{social_link}', [SocialLinkController::class, 'edit'])->name('social-link.edit');
    Route::put('social-link/update/{social_link}', [SocialLinkController::class, 'update'])->name('social-link.update');
    Route::delete('social-link/destroy/{social_link}', [SocialLinkController::class, 'destroy'])->name('social-link.destroy');

    Route::get('customer/{customer}/edit', [CustomerController::class, 'edit'])
        ->name('customer.edit')
        ->where('customer', '[0-9]+')
        ->middleware('able:manage_customer');
    Route::resource('customer', 'CustomerController')->middleware('able:manage_customer');
    // Testimonial
    Route::resource('testimonial', 'TestimonialController')->middleware('able:manage_testimonial');
    Route::post('testimonial/sorting', [TestimonialController::class, 'sorting'])->name('testimonial.sorting')->middleware('able:manage_testimonial');
    Route::resource('subscribers', 'SubscriberController')->middleware('able:manage_subscribers');

    Route::get('select2/data', [MiscController::class, 'select2Data'])->name('select2.data');

    Route::resource('product', 'ProductController')->except(['show'])->middleware('able:manage_product');
    Route::resource('review', 'ReviewController')->except(['show'])->middleware('able:manage_product');

    Route::resource('shipping', 'ShippingMethodController')->middleware('able:manage_setting');

    Route::resource('role', 'RoleController')->only(['index', 'store', 'update', 'destroy'])->middleware('able:manage_staff');
    Route::resource('staff', 'StaffController')->only(['index', 'store', 'update', 'destroy'])->middleware('able:manage_staff');

    Route::resource('plan', 'PlanController')->middleware('able:manage_setting');

    Route::resource('page', 'PageController')->middleware('able:manage_page');
    Route::put('page/{page}/section', [\App\Http\Controllers\Staff\PageController::class, 'updateSections'])->name('page.section')->middleware('able:manage_page');

    Route::resource('quiz-item', 'QuizItemController')->only(['index', 'store', 'show', 'update', 'destroy'])->middleware('able:manage_setting');
    Route::resource('quiz-item-option', 'QuizItemOptionController')->middleware('able:manage_setting');

    Route::get('gateway', [GatewayController::class, 'index'])->name('gateway.index')->middleware('able:manage_setting');
    Route::put('gateway', [GatewayController::class, 'update'])->name('gateway.update')->middleware('able:manage_setting');

    Route::resource('product-of-the-month', 'ProductOfTheMonthController')->middleware('able:manage_productOfTheMonth');

    Route::resource('product-sub-type', 'ProductSubTypesController')->middleware('able:manage_productSubType');

    Route::resource('coupon', 'CouponController')->middleware('able:manage_coupon');

    Route::resource('shipping-policy', 'ShippingPoliciesController')->middleware('able:manage_setting');

    Route::put('order/{order}/action', [OrderController::class, 'postAction'])->name('order.action')->middleware('able:manage_order');
    Route::put('order/status/{id}', [OrderController::class, 'updateStatus'])->name('order.status')->middleware('able:manage_order');
    Route::resource('order', 'OrderController')->middleware('able:manage_order');
    Route::post('courier-details/update/{order}', [OrderController::class, 'courierDetailsUpdate'])->name('courier.data.update');

    Route::resource('menu', 'MenuController')->middleware('able:manage_menu');
    Route::get('menu/{menu}/items', [MenuController::class, 'getItems'])->name('menu.getItem');
    Route::put('menu/{menu}/items', [MenuController::class, 'updateItems'])->name('menu.itemupdate');

    Route::resource('queue-purchase', 'QueuePurchasePolicyController')->only(['index', 'store', 'update', 'destroy']);

    Route::get('texts', [TextController::class, 'index'])->middleware('able:manage_page')->name('texts.index');
    Route::get('texts/edit/{id}', [TextController::class, 'edit'])->middleware('able:manage_page');
    Route::post('texts/{id}', [TextController::class, 'update'])->middleware('able:manage_page');

    Route::get('/order-address/{orderAddress}', [OrderController::class, 'editAddress'])->middleware('able:manage_page')->name('edit.address');
    Route::put('/address-update/{orderAddress}', [OrderController::class, 'updateAddress'])->middleware('able:manage_page')->name('update.address');
});
