<?php

namespace App\Console\Commands;

use App\Models\Meta;
use Illuminate\Console\Command;

class SettingsInit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scentq:setting';

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
        foreach (config('settings') as $key => $value) {
            Meta::create([
                'name' => $key,
                'content' => (is_array($value)?json_encode($value):$value)
            ]);
        }
        return 0;
    }
}
