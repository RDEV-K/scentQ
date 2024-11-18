<?php

namespace App\Console\Commands;

use App\Models\Meta;
use App\Models\Page;
use App\Models\Term;
use Illuminate\Console\Command;

class Optimize extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scentbee:optimize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Optimize database by deleting unused data';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Delete All Meta Without Parent
        $holders = [Term::class, Page::class];
        Meta::query()->doesntHaveMorph('holder', $holders)->delete();
    }
}
