<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\AppleToken;
use App\Http\Controllers\MiscController;
use App\Http\Controllers\QueueController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController
{
    // public function __construct(private AppleToken $appleToken)
    // {
    // }

    function redirect(string $provider)
    {
        $this->init($provider);
        $socialite = Socialite::driver($provider);
        if ($provider === 'google') {
            $socialite->stateless();
        }
        $response = $socialite->redirect();
        return Inertia::location($response->getTargetUrl());
    }

    function callback(string $provider)
    {
        try {

            $this->init($provider);

            $socialite = Socialite::driver($provider);
            if ($provider === 'google') {
                $socialite->stateless();
            }
            $socialUser = $socialite->user();

            $user = User::query()->whereHas('socialAccounts', function ($q) use ($provider, $socialUser) {
                $q->where('provider', $provider)->where('provider_id', $socialUser->getId());
            })->first();

            if (!$user) {

                $email_exist = User::query()->where('email', $socialUser['email'])->first();
                if ($email_exist) {
                    $email_exist->socialAccounts()->create([
                        'provider' => $provider,
                        'provider_id' => $socialUser->getId(),
                    ]);

                    $user = $email_exist;
                } else {
                    /* @var User $user */
                    $user = User::create([
                        'first_name' => $socialUser->getName() ?? 'Anonymous',
                        'email' => $socialUser->getEmail() ?? $socialUser->getId() . '@' . $provider . '.com',
                        'avatar' => $socialUser->getAvatar(),
                        'email_verified_at' => now(),
                        'password' => Hash::make(uniqid()),
                        'is_active' => true,
                        'on_promo_list' => true,
                    ]);

                    $user->socialAccounts()->create([
                        'provider' => $provider,
                        'provider_id' => $socialUser->getId(),
                    ]);
                }

                session()->flash('success', __('User Registered Successfully'));
            }
            Auth::login($user);

            // check auth session is valid for current domain
            // $domain = request()->getHost();
            // $user_domain = auth()->user()->account_for ?? '';
            // if (auth()->user() && auth()->user()->account_for != null && $domain != "127.0.0.1") {
            //     if ($domain != auth()->user()->account_for) {
            //         auth()->logout();
            //         return redirect(route('login', ['warning_alert' => ucfirst($user_domain)]));
            //     }
            // }
            // check auth session is valid for current domain  end

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

            // if (!$user->subscription('personal')) return redirect()->route('subscribe');
            return redirect('/');
        } catch (\Throwable $th) {

            session()->flash('error',  $th->getMessage());
            return redirect('/');
        }
    }

    private function init(string $provider)
    {
        config()->set('services.' . $provider . '.redirect', route('social.callback', $provider));
        if ($provider === 'apple') {
            config()->set('services.apple.client_secret', $this->appleToken->generate());
        }
    }
}
