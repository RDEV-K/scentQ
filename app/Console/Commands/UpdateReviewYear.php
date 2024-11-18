<?php

namespace App\Console\Commands;

use App\Models\Review;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateReviewYear extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:review-year';

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
        $this->comment('Updating reviews older than one year with random dates...');
        Review::where('created_at', '<', Carbon::now()->subYear())->chunkById(100, function ($reviews) {
            foreach ($reviews as $review) {
                $review->update([
                    'created_at' => Carbon::now()->subDays(rand(0, 365)),
                    'updated_at' => Carbon::now()->subDays(rand(0, 365)),
                ]);
            }
            $this->info('Updated 100 reviews. Sleeping for 5 seconds...');
            sleep(5);
        });

        $this->comment('Task Completed');
    }
}
