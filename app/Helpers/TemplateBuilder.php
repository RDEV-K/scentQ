<?php

namespace App\Helpers;

use App\Models\NotificationTemplate;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Str;

class TemplateBuilder
{
    private $template;
    private $title;
    private $channel;
    private $except = ['if', 'endif'];
    private $view;

    function fetch($name, $channel = 'email')
    {
        $this->channel = $channel;
        $this->loadViewByName($name);
        $data = NotificationTemplate::query()->where('name', $name)->where('channel', $channel)->first();
        if ($data) {
            $this->template = $data->content;
            $this->title = $data->title;
        } else {
            $data = config('notification_templates.' . $channel . '.' . $name);
            $this->template = $data['content'];
            $this->title = $data['title'];
        }
        return $this;
    }

    function parse($data = [])
    {
        $this->template = $this->resolveMatches($this->template, $data);
        $this->title = $this->resolveMatches($this->title, $data);
        return $this;
    }

    function toEmail()
    {
        $view_file = $this->view ? $this->view : 'default';
        $view = "emails.$view_file";
        return (new MailMessage)->subject($this->title)->view($view, ['data' => $this->template]);
    }

    function toPdf()
    {
        $pdf = PDF::loadView('emails.default', ['data' => $this->template]);
        $name = Str::slug($this->title);
        return $pdf->download($name . '.pdf');
    }

    function toView()
    {
        return view('emails.default', ['data' => $this->template]);
    }

    /**
     * Load custom view file other than default
     */
    function loadViewByName($name)
    {
        /** @note register custom [name => view_file] here */
        // order_name => view_file
        $view_by_name = [
            // "order_sth" => "order-sth"
        ];

        if (!empty($view_by_name[$name])) {
            $this->view = $view_by_name[$name];
        }

        return $this;
    }

//    function toSMS($signature = null)
//    {
//        if ($signature) {
//            return '<#> ' . config('app.name') . ': ' . strip_tags($this->template) . ' ' . $signature;
//        }
//        return strip_tags($this->template);
//    }
//
//    function toTwilio($signature = null)
//    {
//        if ($signature) {
//            return '<#> ' . config('app.name') . ': ' . strip_tags($this->template) . ' ' . $signature;
//        }
//        return (new TwilioSmsMessage)->content(strip_tags($this->template));
//    }
//
//    function toDatabase($data = [])
//    {
//        return [
//            'title' => $this->title,
//            'message' => strip_tags($this->template),
//            'data' => $data
//        ];
//    }
//
//    function toFCM($data = [])
//    {
//        if (is_array($data)) {
//            foreach ($data as $k => $v) {
//                $data[(string)$k] = (string)$v;
//            }
//        }
//        return FcmMessage::create()
//            ->setData($data)
//            ->setNotification(\NotificationChannels\Fcm\Resources\Notification::create()
//                ->setTitle($this->title)
//                ->setBody(strip_tags($this->template))
//                ->setImage(config('ui.logo.small')))
//            ->setAndroid(
//                AndroidConfig::create()
//                    ->setFcmOptions(AndroidFcmOptions::create()->setAnalyticsLabel('analytics'))
//                    ->setNotification(AndroidNotification::create()->setColor('#0A0A0A'))
//            )->setApns(
//                ApnsConfig::create()
//                    ->setFcmOptions(ApnsFcmOptions::create()->setAnalyticsLabel('analytics_ios')));
//    }

    function get($data = [])
    {
//        if ($this->channel == 'sms') return $this->toSMS();
//        if ($this->channel == 'fcm') return $this->toFCM($data);
        return $this->toEmail();
    }

    private function resolveMatches($string, $data = [])
    {
        $except = $this->except;
        return preg_replace_callback('/\[([\w.]+)]/', function ($matches) use ($data, $except) {
            if (in_array($matches[1], $except)) return $matches[0];
            $keys = explode('.', $matches[1]);
            $replacement = '';
            if (sizeof($keys) === 1) {
                $replacement = isset($data[$keys[0]]) ? $data[$keys[0]] : null;
            } else {
                $replacement = $data;

                foreach ($keys as $key) {
                    if (!isset($replacement[$key])) return null;
                    $replacement = $replacement[$key];
                }
            }

            return $replacement;
        }, $string);
    }
}
