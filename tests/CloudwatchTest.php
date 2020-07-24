<?php

namespace RenokiCo\AwsWebhooks\Test;

class CloudwatchTest extends TestCase
{
    public function test_callable_methods()
    {
        $payloads = [
            $this->getCloudwatchNotificationPayload('ALARM', 'OK'),
            $this->getCloudwatchNotificationPayload('OK', 'ALARM'),
            $this->getCloudwatchNotificationPayload('INSUFFICIENT_DATA', 'OK'),
        ];

        foreach ($payloads as $payload) {
            $this
                ->json('GET', route('cloudwatch'), $payload)
                ->assertSee('OK');
        }
    }
}
