<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MiscController;
use App\Http\Controllers\QueueController;
use App\Models\MailSubscriber;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Traits\SeoTrait;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    use SeoTrait;
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'gender' => ['required', 'string', 'in:male,female'],
            // 'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email:dns',
                'max:191',
                'unique:users,email',
                'regex:/^[a-zA-Z0-9._%+-]+@(gmail\.com|yahoo\.com)$/',
            ],
            'password' => ['required', 'string', 'min:8']
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $params = [
            'first_name' => $data['name'] ?? 'Anonymous',
            'email' => $data['email'],
            'gender' => $data['gender'],
            'password' => Hash::make($data['password']),
        ];
        if (session()->has('referralCode')) {
            $user_id = Str::after(session('referralCode'), 'refuser');
            $refUser = User::find($user_id);
            if ($refUser) {
                $params['referred_by_id'] = $refUser->id;
                session()->forget('referralCode');
            }
        }
        try {
            DB::beginTransaction();
            if (isset($data['on_promo_list'])) {
                MailSubscriber::query()->updateOrCreate(['email' => $data['email']]);
            }
            $user = User::create($params);
            DB::commit();
            return $user;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw ValidationException::withMessages(['email' => $exception->getMessage()]);
        }
    }

    public function showRegistrationForm()
    {
        $quiz = \request()->has('quiz');
        $gen = session('scent-type') == 'feminine' ? 'female' : 'male';
        $msg = session('message');

        $this->seo(
            'Signup - Join ScentQ and Discover Your Perfect Fragrance Match',
            'Sign up for ScentQ and receive monthly samples of over 1600 designer perfumes and colognes. Find your ideal scent and purchase full-sized bottles of your favorites.'
        );

        return inertia('Auth/Registration', compact('quiz', 'gen', 'msg'))->title(__('Signup - Join ScentQ and Discover Your Perfect Fragrance Match'));
    }

    public function catchReferral($referralCode)
    {
        session()->put('referralCode', $referralCode);
        return redirect()->route('register');
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        if (session()->has('scent-type') && session()->has('scent-preference')) {
            try {
                if (is_array(session('scent-preference'))) {
                    MiscController::setQuizPreferences(session('scent-type'), session('scent-preference'));
                }
            } catch (\Exception $exception) {
            }
        }
        //
        if ($request->has('queue') && $request->queue != null) {
            // $this->addProductIntoQueue($request->queue);
            (new LoginController)->addProductIntoQueue($request->queue);
        }

        if ($request->has('add_to_cart') && $request->add_to_cart != null) {
            // $this->addToCart($request->add_to_cart);
            (new LoginController)->addToCart($request->add_to_cart);
        }

        if ($request->has('add_to_sub') && $request->add_to_sub != null) {
            // $this->addToCart($request->add_to_cart);
            (new LoginController)->addToSub($request->add_to_sub);
        }

        if ($request->has('add_to_cart') && $request->add_to_cart != null) {
            return redirect()->route('checkout');
        }

        //
        if (session()->has('scentq_queue')) {
            try {
                $tempQueue = session('scentq_queue', []);
                foreach ($tempQueue as $productId) {
                    QueueController::pushProductToQueue($productId);
                }
            } catch (\Exception $exception) {
            }
        }
        session()->flash('success', 'Registration success!');
        // info('refistewr success');
        if ($request->has('subscribe') && $request->subscribe == 1) {
            // info('$request->has(subscribe)');
            return redirect()->route('subscribe');
        }

        if ($request->has('add_to_sub') && $request->add_to_sub != null || $request->has('add_to_cart') && $request->add_to_cart != null) {
            // info('$request->has(subscribe)');
            return redirect()->route('subscribe');
        }

        if ($request->has('quiz') && $request->quiz == true) {
            // info('$request->quiz ');
            return redirect()->route('show.recommendation.products');
        }

        $previous = url()->previous();

        if ($previous) {
            if (!$user->subscription('personal') && $this->checkProductIsExistOnQueue($user) > 0) {
                // info('subscribe it subs not found');
                return redirect()->route('subscribe');
            }
            return redirect($previous);
        } else {
            return redirect()->route('subscribe');
        }
    }

    public function checkProductIsExistOnQueue(object $user)
    {
        // check product exist on queue
        $month = (int)date('n');
        $year = date('Y');

        $queue_product_check = $user->queues()->where('year', $year)->where('month', $month)->first();
        if (!$queue_product_check) {
            $user->queues()->create([
                'month' => $month,
                'year' => $year
            ]);
        }

        $queue_product_check = $user->queues()->where('year', $year)->where('month', $month)->first();
        $check_queue_items = $queue_product_check->items ? $queue_product_check->items()->count() : 0;

        return $check_queue_items;
    }
}
