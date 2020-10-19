<?php

namespace RenokiCo\AwsWebhooks\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Rennokki\LaravelSnsEvents\Http\Controllers\SnsController;

class EventbridgeWebhook extends SnsController
{
    /**
     * Handle logic at the controller level on notification.
     *
     * @param  array  $snsMessage
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function onNotification(array $snsMessage, Request $request): void
    {
        $decodedMessage = json_decode($snsMessage['Message'], true);

        $service = Str::of($decodedMessage['source'])->after('aws.')->ucFirst();

        $methodToCall = "on{$service}Event";

        if (method_exists($this, $methodToCall)) {
            call_user_func(
                [$this, $methodToCall],
                $decodedMessage, $snsMessage, $request
            );
        }
    }
}
