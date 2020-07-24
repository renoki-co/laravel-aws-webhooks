<?php

namespace RenokiCo\AwsWebhooks\Http\Controllers;

use Illuminate\Http\Request;
use Rennokki\LaravelSnsEvents\Http\Controllers\SnsController;

class SesWebhook extends SnsController
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
     * Associate each SNS `eventType` value
     * with a callable method from this class.
     *
     * @var array
     */
    public static $eventTypesWithCalledMethod = [
        'Bounce' => 'onBounce',
        'Complaint' => 'onComplaint',
        'Delivery' => 'onDelivery',
        'Send' => 'onSend',
        'Reject' => 'onReject',
        'Open' => 'onOpen',
        'Click' => 'onClick',
        'Rendering Failure' => 'onRenderingFailure',
        'DeliveryDelay' => 'onDeliveryDelay',
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

        $eventType = $decodedMessage['eventType'] ?? null;

        foreach (static::$eventTypesWithCalledMethod as $callableEventType => $methodToCall) {
            if ($eventType === $callableEventType) {
                call_user_func(
                    [$this, $methodToCall],
                    $decodedMessage, $snsMessage, $request
                );
            }
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
     * Handle the Bounce event.
     *
     * @param  array  $message
     * @param  array  $originalMessage
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function onBounce(array $message, array $originalMessage, Request $request)
    {
        //
    }

    /**
     * Handle the Bounce event.
     *
     * @param  array  $message
     * @param  array  $originalMessage
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function onComplaint(array $message, array $originalMessage, Request $request)
    {
        //
    }

    /**
     * Handle the Delivery event.
     *
     * @param  array  $message
     * @param  array  $originalMessage
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function onDelivery(array $message, array $originalMessage, Request $request)
    {
        //
    }

    /**
     * Handle the Send event.
     *
     * @param  array  $message
     * @param  array  $originalMessage
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function onSend(array $message, array $originalMessage, Request $request)
    {
        //
    }

    /**
     * Handle the Reject event.
     *
     * @param  array  $message
     * @param  array  $originalMessage
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function onReject(array $message, array $originalMessage, Request $request)
    {
        //
    }

    /**
     * Handle the Open event.
     *
     * @param  array  $message
     * @param  array  $originalMessage
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function onOpen(array $message, array $originalMessage, Request $request)
    {
        //
    }

    /**
     * Handle the Click event.
     *
     * @param  array  $message
     * @param  array  $originalMessage
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function onClick(array $message, array $originalMessage, Request $request)
    {
        //
    }

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

    /**
     * Handle the DeliveryDelay event.
     *
     * @param  array  $message
     * @param  array  $originalMessage
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function onDeliveryDelay(array $message, array $originalMessage, Request $request)
    {
        //
    }
}
