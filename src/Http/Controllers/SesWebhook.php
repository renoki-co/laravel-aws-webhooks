<?php

namespace RenokiCo\AwsWebhooks\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Rennokki\LaravelSnsEvents\Http\Controllers\SnsController;

class SesWebhook extends SnsController
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

        $typeKey = (array_key_exists("eventType", $decodedMessage) ? "eventType" : "notificationType");

        $eventType = $decodedMessage[$typeKey] ?? null;

        $methodToCall = 'on'.Str::studly($eventType);

        if (method_exists($this, $methodToCall)) {
            call_user_func(
                [$this, $methodToCall],
                $decodedMessage, $snsMessage, $request
            );
        }
    }
}
