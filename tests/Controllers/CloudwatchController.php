<?php

namespace RenokiCo\AwsWebhooks\Test\Controllers;

use Aws\Sns\MessageValidator;
use Illuminate\Http\Request;
use RenokiCo\AwsWebhooks\Http\Controllers\CloudwatchWebhook;

class CloudwatchController extends CloudwatchWebhook
{
    /**
     * Get the message validator instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Aws\Sns\MessageValidator
     */
    protected function getMessageValidator(Request $request)
    {
        return new MessageValidator(function ($url) use ($request) {
            return $request->certificate ?: $url;
        });
    }

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
