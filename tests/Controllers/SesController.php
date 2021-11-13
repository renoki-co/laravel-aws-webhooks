<?php

namespace RenokiCo\AwsWebhooks\Test\Controllers;

use Aws\Sns\MessageValidator;
use Illuminate\Http\Request;
use RenokiCo\AwsWebhooks\Http\Controllers\SesWebhook;

class SesController extends SesWebhook
{
    /**
     * Handle the Rendering Failure event.
     *
     * @param  array  $message
     * @param  array  $originalMessage
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function onRenderingFailure(array $message, array $originalMessage, Request $request)
    {
        //
    }
}
