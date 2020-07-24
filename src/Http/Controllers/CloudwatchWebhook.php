<?php

namespace RenokiCo\AwsWebhooks\Http\Controllers;

use Illuminate\Http\Request;
use Rennokki\LaravelSnsEvents\Http\Controllers\SnsController;

class CloudwatchWebhook extends SnsController
{
    /**
     * List the allowed SNS Topic ARNs
     * that are allowed to run the business logic.
     *
     * @var array
     */
    protected static $allowedTopicArns = [
        //
    ];

    /**
     * Handle logic at the controller level on notification.
     *
     * @param  array  $snsMessage
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function onNotification(array $snsMessage, Request $request): void
    {
        if (! $this->shouldAllow($snsMessage)) {
            return;
        }

        $decodedMessage = json_decode($snsMessage['Message'], true);

        $state = $decodedMessage['NewStateValue'] ?? null;

        switch ($state) {
            case 'OK': $this->onOkState($decodedMessage, $snsMessage, $request); break;
            case 'ALARM': $this->onAlarmState($decodedMessage, $snsMessage, $request); break;
            case 'INSUFFICIENT_DATA': $this->onInsufficientData($decodedMessage, $snsMessage, $request); break;
            default: break;
        }
    }

    /**
     * Check if the topic ARN from
     * the SNS message is whitelisted.
     *
     * @param  array  $snsMessage
     * @return bool
     */
    protected function shouldAllow(array $snsMessage): bool
    {
        return in_array(
            $snsMessage['TopicArn'] ?? null, static::$allowedTopicArns
        );
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

    /**
     * Handle the event when an alarm transitioned to ALARM.
     *
     * @param  array  $message
     * @param  array  $originalMessage
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function onAlarmState(array $message, array $originalMessage, Request $request)
    {
        //
    }

    /**
     * Handle the event when an alarm transitioned to INSUFFICIENT_DATA.
     *
     * @param  array  $message
     * @param  array  $originalMessage
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function onInsufficientData(array $message, array $originalMessage, Request $request)
    {
        //
    }
}
