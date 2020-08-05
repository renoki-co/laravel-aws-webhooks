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
}
