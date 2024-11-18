<?php

namespace App\Http\Controllers\Auth;

use DateTime;
use App\Models\Cart;
use App\Models\Plan;
use App\Models\User;
use App\Models\Product;
use App\Traits\SeoTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Http\Controllers\MiscController;
use App\Http\Controllers\QueueController;
use App\Http\Controllers\CartItemController;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use SeoTrait;
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        $this->seo(
            'Login - Access Your ScentQ Account',
            'Log in to your ScentQ account to manage your subscription, view your my order, and more. Discover your new favorite fragrance with ease.'
        );

        return inertia('Auth/Login')->title(__('Login - Access Your ScentQ Account'));
    }


    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (
            method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)
        ) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {

            // check auth session is valid for current domain
            // $domain = request()->getHost();
            // $user_domain = auth()->user()->account_for ?? '';
            // if(auth()->user() && auth()->user()->account_for != null && $domain != "127.0.0.1") {

            //     if($domain != auth()->user()->account_for) {
            //         auth()->logout();
            //         return redirect('/login')
            //         ->with('warning_alert',
            //         'Your account is not compatible with this domain. <br/>
            //          Please log in using this link to proceed.
            //          <br/> <a href="https://'.$user_domain.'" class="tw-no-underline">'. ucfirst($user_domain) .'</a>
            //         ');
            //     }
            // }
             // check auth session is valid for current domain  end

            if ($request->hasSession()) {
                $request->session()->put('auth.password_confirmed_at', time());
            }

            if ($request->has('queue') && $request->queue != null) {
                $this->addProductIntoQueue($request->queue);
            }

            if ($request->has('add_to_cart') && $request->add_to_cart != null) {
                $this->addToCart($request->add_to_cart);
            }

            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, User $user)
    {
        if (session()->has('scent-type') && session()->has('scent-preference')) {
            try {
                if (is_array(session('scent-preference'))) {
                    MiscController::setQuizPreferences(session('scent-type'), session('scent-preference'));
                }
            } catch (\Exception $exception) {
            }
        }
        if (session()->has('scentq_queue')) {
            try {
                $tempQueue = session('scentq_queue', []);
                foreach ($tempQueue as $productId) {
                    QueueController::pushProductToQueue($productId);
                }
            } catch (\Exception $exception) {
            }
        }
        $subscription = $user->subscription('personal');

        if (!$subscription) return redirect()->route('subscribe');

        $this->updateSubscriptionStatus($subscription);

        if (session()->has('intended_brand_slug') && session()->has('intended_product_slug')) {
            $brandSlug = session()->pull('intended_brand_slug');
            $productSlug = session()->pull('intended_product_slug');

            return redirect()->to(url("/perfume/$brandSlug/$productSlug"));
        }

        return redirect()->intended($user->home);
    }

    public function updateSubscriptionStatus($subscription)
    {
        $subscriptionFromStripe = (clone $subscription)->asStripeSubscription();
        $status = $subscriptionFromStripe->status;

        // if current status is not same with stripe status
        if ($subscription->status !== $status) {
            $subscription->stripe_status = $status;
            $subscription->ends_at = Carbon::createFromTimestamp(
                $subscriptionFromStripe->current_period_end
            );
            $subscription->save();
        }
    }

    public function addToCart(string $productId): void
    {
        if (auth()->check()) {
            $user = auth()->user();
            $product = Product::where('id', $productId)->first();
            $cart_check = Cart::where('user_id', $user->id)->first();
            if (!$cart_check) {
                Cart::create([
                    'user_id' => $user->id
                ]);
            }
            $cart = Cart::where('user_id', $user->id)->first();

            if ($product) {
                $cart->items()->create([
                    'product_title' => $product->title,
                    'product_id' => $productId,
                    'product_image' =>   $product->image ? $product->image['thumb_url'] : null,
                    'purchase_option' => null,
                    'purchase_option_type' => 'one_time',
                    'amount' => $product->additional_price,
                    'quantity' => 1,
                    'subtotal' =>  $product->additional_price,
                ]);
                $cart->update([
                    'gross_total' => $product->additional_price + $cart->gross_total,
                    'net_total' => $product->additional_price + $cart->net_total,
                ]);
            }
        }
    }

    public function addToSub(string $productId): void
    {
        if (auth()->check()) {
            $user = auth()->user();
            $product = Product::where('id', $productId)->first();
            $cart_check = Cart::where('user_id', $user->id)->first();

            $plan = Plan::query()->with(['autoCoupon', 'freeProduct'])->domain(getCurrentDomain())->where('is_default', true)->first();

            if (!$cart_check) {
                Cart::create([
                    'user_id' => $user->id
                ]);
            }
            $cart = Cart::where('user_id', $user->id)->first();

            if ($product) {
                $cart->items()->create([
                    'product_title' => $product->title,
                    'product_id' => $productId,
                    'product_image' =>   $product->image ? $product->image['thumb_url'] : null,
                    'purchase_option' => null,
                    'purchase_option_type' => 'subscription',
                    'amount' => $plan->total_price,
                    'quantity' => 1,
                    'subtotal' => $plan->total_price,
                ]);

                // finally cart cal
                $full_cart = $user->cart()->with('items')->first();
                (new CartItemController())->recalculateCartAndCoupon($full_cart);
            }
        }
    }

    public function addProductIntoQueue(string $productId): void
    {
        if (auth()->check()) {
            //check product is already exist on user queue
            $user =  auth()->user();
            $check_product_is_exist = $user->queues()->whereHas('items', function ($q) use ($productId) {
                $q->where('product_id', $productId);
            })->first();

            if (!$check_product_is_exist) {
                // else product not exist do insert
                $month = date('n');
                $year = date('Y');
                $next_months = 13 - $month;
                $month_name = '';
                $added = true;

                for ($i = 0; $i < $next_months; $i++) {

                    $current_month = intval(Carbon::now()->format('m')) + $i;
                    $dateObj   = DateTime::createFromFormat('!m', $current_month);
                    $current_full_month = $dateObj->format('F');

                    //check queue | if queue not then create new one
                    $check_queue = $user->queues()->where('year', $year)->where('month', $current_month)->first();
                    if (!$check_queue) {
                        $user->queues()->create([
                            'month' => $current_month,
                            'year' => $year
                        ]);
                    }

                    // then get queue again with items
                    $queue = $user->queues()->where('year', $year)->where('month', $current_month)->first();
                    $items = $queue->items()->count();

                    // check user plan product qty
                    $subscription =  $user->subscription('personal');
                    if ($subscription) {
                        $plan = Plan::query()->where('stripe_id', $subscription->stripe_price)->first();
                        $product_count = $plan->product_count;
                    } else {
                        $product_count = 1;
                    }

                    // if items 0 then create item and go back or next process

                    //and check this month items qty is lower then plan product qty == true ? then create
                    if (intval($product_count) != intval($items) && intval($product_count) > intval($items)) {

                        $queue->items()->create([
                            'queue_id' => $queue->id,
                            'product_id' => $productId,
                            'addedBy_type' => 'App\Models\User',
                            'addedBy_id' =>  $user->id,
                        ]);

                        $month_name = $current_full_month;
                        $added = true;
                        break;
                    }

                    // else run next
                    $added = false;
                }

                if ($added) {
                    session()->flash('success', 'Product added in ' . $month_name . ' in ' . $year);
                } else {
                    session()->flash('queue', 'Your queue is full . Product not added!');
                }
            }
        }
    }
}
