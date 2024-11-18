<?php

namespace app\Console\Commands;

use App\Models\NotificationTemplate;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

// class SeedNotificationTemplates extends Command
// {
//     /**
//      * The name and signature of the console command.
//      *
//      * @var string
//      */
//     protected $signature = 'notifications:seed';

//     /**
//      * The console command description.
//      *
//      * @var string
//      */
//     protected $description = 'Seed notification templates table with configured templates';

//     /**
//      * Execute the console command.
//      *
//      * @return int
//      */
//     public function handle()
//     {
//         $config_notifications = config("notification_templates");
//         $email_notifications = $config_notifications["email"];

//         try {
//             DB::beginTransaction();
//             foreach ($email_notifications as $name => $template) {
//                 $notification_template = NotificationTemplate::firstOrCreate(
//                     ["name" => $name],
//                     [
//                         "name" => $name,
//                         "title" => $template["title"],
//                         "channel" => "email",
//                         "params" => $template["params"],
//                         "content" => $template["content"],
//                     ]
//                 );
//             }
//             DB::commit();
//             $this->info('Notification template seeding is successful!');
//             return Command::SUCCESS;
//         } catch (\Throwable $th) {
//             DB::rollBack();
//             $this->error($th->getMessage());
//             $this->error('Something went wrong!');
//             return Command::FAILURE;
//         }


//     }
// }
