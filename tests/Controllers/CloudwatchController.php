<?php

namespace RenokiCo\AwsWebhooks\Test\Controllers;

use Illuminate\Http\Request;
use RenokiCo\AwsWebhooks\Http\Controllers\CloudwatchWebhook;

class CloudwatchController extends CloudwatchWebhook
{
    /**
     * List the allowed SNS Topic ARNs
     * that are allowed to run the business logic.
     *
     * @var array
     */
    protected static $allowedTopicArns = [
        'arn:aws:sns:us-west-2:123456789012:MyTopic',
    ];
}
