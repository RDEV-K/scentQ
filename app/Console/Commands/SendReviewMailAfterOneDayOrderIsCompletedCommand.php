<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Meta;
use App\Models\User;
use App\Models\Order;
use App\Models\SocialLink;
use Illuminate\Console\Command;
use App\Notifications\ProductReviewMailNotification;

class SendReviewMailAfterOneDayOrderIsCompletedCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'review-mail:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $completed_orders = Order::where('status', 'completed')->where('delivery_completed_date', '!=', null)->get();

        foreach ($completed_orders as $key => $order) {

            $send_date = Carbon::now()->addDays(1)->format('Y-m-d');
            $user = User::where('id', $order?->user_id)->first();
            $social_media = SocialLink::orderBy('order', 'ASC')->get();

            if ($order->delivery_completed_date == $send_date) {
                if ($user) {
                    $user->notify(new ProductReviewMailNotification($order, $user, $social_media));
                }
            }
        }
    }
}
