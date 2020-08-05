<?php

namespace RenokiCo\AwsWebhooks\Http\Controllers;

use Illuminate\Http\Request;
use Rennokki\LaravelSnsEvents\Http\Controllers\SnsController;

class CloudwatchWebhook extends SnsController
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

        $state = $decodedMessage['NewStateValue'] ?? null;

        switch ($state) {
            case 'OK': $this->onOkState($decodedMessage, $snsMessage, $request); break;
            case 'ALARM': $this->onAlarmState($decodedMessage, $snsMessage, $request); break;
            case 'INSUFFICIENT_DATA': $this->onInsufficientData($decodedMessage, $snsMessage, $request); break;
            default: break;
        }
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
