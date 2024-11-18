<?php

namespace App\Models;

use Laravel\Cashier\Cashier;
use Laravel\Cashier\Billable;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications\ResetPassword;
use Illuminate\Notifications\Notifiable;
use function Illuminate\Events\queueable;
use Stripe\Subscription as StripeSubscription;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Billable;

    protected $guarded = [];
    public $dates = ['dob'];
    protected $appends = [
        'is_card_denied',
        'referral_url',
        'plan_status',
        // 'quiz_answered',
        'full_name',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::updated(queueable(function ($customer) {
            if ($customer->hasStripeId()) {
                $customer->syncStripeCustomerDetails();
            }
        }));
    }

    function getPlanStatusAttribute()
    {
        $subscription = $this->subscription('personal');
        $status = __('Canceled');

        if ($subscription) {
            if ($subscription->canceled()) {
            } elseif ($subscription->active()) {
                $status = __('Subscribed');
            } elseif ($subscription->onGracePeriod()) {
                $status = __('Grace Period');
            } elseif ($subscription->onTrial()) {
                $status = __('On Trail');
            }
        } else {
            $status = __('Not Subscribed');
        }

        return $status;
    }

    function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    function families()
    {
        return $this->belongsToMany(Family::class, 'user_family_relation');
    }

    function socialAccounts()
    {
        return $this->hasMany(SocialAccount::class);
    }

    function cart()
    {
        return $this->hasOne(Cart::class, 'user_id', 'id');
    }

    function referred_by()
    {
        return $this->belongsTo('App\\Models\\User', 'referred_by_id', 'id');
    }

    function getOnPromoListAttribute($v)
    {
        // return MailSubscriber::query()->where('email', $this->email)->first();
        return $this->mailSubscriber;
    }

    public function mailSubscriber()
    {
        return $this->hasOne(MailSubscriber::class, 'email', 'email');
    }

    function referres()
    {
        return $this->hasMany('App\\Models\\User', 'referred_by_id', 'id');
    }

    function reviews()
    {
        return $this->hasMany(Review::class, 'user_id', 'id');
    }

    function orders()
    {
        return $this->hasMany(Order::class, 'user_id', 'id');
    }

    function getHomeAttribute()
    {
        //        return route('home', $this->gender === 'male'?'men':'women');
        return route('index');
    }

    function getReferralUrlAttribute()
    {
        return route('referral', 'refuser' . $this->id);
    }

    function addresses()
    {
        return $this->hasMany(Address::class, 'user_id', 'id');
    }

    function getAvatarAttribute($avatar)
    {
        if (empty($avatar)) {
            $full_name = $this->first_name . $this->last_name;
            $name = trim(collect(explode(' ', $this->full_name))->map(function ($segment) {
                return mb_substr($segment, 0, 1);
            })->join(' '));

            return 'https://ui-avatars.com/api/?name=' . urlencode($name) . '&color=000&background=d1c095';
            // $avatar = 'https://www.gravatar.com/avatar/' . md5(strtolower($this->email)) . '.jpg?s=200&d=mm';
        }
        return $avatar;
    }

    function getIsCardDeniedAttribute(): bool
    {
        $personalSubscription = $this->subscription('personal');
        if ($personalSubscription && ($personalSubscription->stripe_status === StripeSubscription::STATUS_INCOMPLETE ||
            $personalSubscription->stripe_status === StripeSubscription::STATUS_INCOMPLETE_EXPIRED ||
            (!Cashier::$deactivatePastDue && $personalSubscription->stripe_status === StripeSubscription::STATUS_PAST_DUE) ||
            $personalSubscription->stripe_status === StripeSubscription::STATUS_UNPAID
        )) {
            return true;
        }

        return false;
    }

    function getPersonalSubscriptionAttribute()
    {
        $res = null;
        $subscription = $this->subscription('personal');
        if ($subscription) {
            $res = [
                'is_valid' => $subscription->valid(),
                'ends_at' => $subscription->ends_at?->format('d M, Y h:i a')
            ];
        }
        return $res;
    }

    function getCaseSubscriptionAttribute()
    {
        return $this->subscribed('case');
    }

    function queues()
    {
        return $this->hasOne(Queue::class, 'user_id', 'id');
    }

    public function reviewVotes()
    {
        return $this->hasMany(ReviewUserVote::class);
    }

    /**
     * Get the name that should be synced to Stripe.
     *
     * @return string|null
     */
    public function stripeName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Get the email address that should be synced to Stripe.
     *
     * @return string|null
     */
    public function stripeEmail()
    {
        return $this->email;
    }

    /**
     * User take quiz answer
     *
     * @return bool
     */
    public function getQuizAnsweredAttribute()
    {
        return Meta::where('holder_type', 'App\Models\User')
            ->where('holder_id', $this->id)
            ->where('name', 'scent-preference')
            ->first();
    }

    public function quizAnswered()
    {
        return $this->hasOne(Meta::class, 'holder_id')
            ->where('holder_type', 'App\Models\User')
            ->where('name', 'scent-preference');
    }


    public function scopeHasActiveSubscriptions($query)
    {
        return $query->whereHas('subscriptions', fn ($q) => $q->active());
    }

    public function scopeHasActiveSubscriptionsWithIn($query, $days = 3)
    {
        $startDate = now()->subDays($days)->startOfDay();
        $endDate = now()->endOfDay();

        return $query->whereHas(
            'subscriptions',
            fn ($q) => $q->active()->whereBetween('created_at', [$startDate, $endDate])
        );
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }
}
