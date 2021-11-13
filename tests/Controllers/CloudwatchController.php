<?php

namespace RenokiCo\AwsWebhooks\Test\Controllers;

use Illuminate\Http\Request;
use RenokiCo\AwsWebhooks\Http\Controllers\CloudwatchWebhook;

class CloudwatchController extends CloudwatchWebhook
{
    /**
     * Handle the event when an alarm transitioned to OK.
     *
     * @param  array  $message
     * @param  array  $originalMessage
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function onOkState(array $message, array $originalMessage, Request $request)
    {
        //
    }
}
