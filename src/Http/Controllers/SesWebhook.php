<?php

namespace RenokiCo\AwsWebhooks\Http\Controllers;

use Illuminate\Http\Request;
use RenokiCo\AwsWebhooks\Concerns\FiltersTopicArns;
use Rennokki\LaravelSnsEvents\Http\Controllers\SnsController;

class SesWebhook extends SnsController
{
    use FiltersTopicArns;

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
                    [$decodedMessage, $snsMessage, $request]
                );
            }
        }
    }

    protected function onBounce(array $message, array $originalMessage, Request $request)
    {
        //
    }

    protected function onComplaint(array $message, array $originalMessage, Request $request)
    {
        //
    }

    protected function onDelivery(array $message, array $originalMessage, Request $request)
    {
        //
    }

    protected function onSend(array $message, array $originalMessage, Request $request)
    {
        //
    }

    protected function onReject(array $message, array $originalMessage, Request $request)
    {
        //
    }

    protected function onOpen(array $message, array $originalMessage, Request $request)
    {
        //
    }

    protected function onClick(array $message, array $originalMessage, Request $request)
    {
        //
    }

    protected function onRenderingFailure(array $message, array $originalMessage, Request $request)
    {
        //
    }

    protected function onDeliveryDelay(array $message, array $originalMessage, Request $request)
    {
        //
    }
}
