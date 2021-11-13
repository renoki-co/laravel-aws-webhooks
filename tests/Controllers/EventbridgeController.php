<?php

namespace RenokiCo\AwsWebhooks\Test\Controllers;

use Illuminate\Http\Request;
use RenokiCo\AwsWebhooks\Http\Controllers\EventbridgeWebhook;

class EventbridgeController extends EventbridgeWebhook
{
    /**
     * Handle the event coming from Autoscaling.
     *
     * @param  array  $message
     * @param  array  $originalMessage
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function onGameliftEvent(array $message, array $originalMessage, Request $request)
    {
        //
    }
}
