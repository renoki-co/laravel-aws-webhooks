<?php

namespace RenokiCo\AwsWebhooks\Test;

class CloudwatchTest extends TestCase
{
    public function test_callable_methods()
    {
        $payloads = [
            $this->getCloudwatchMessage('ALARM', 'OK'),
            $this->getCloudwatchMessage('OK', 'ALARM'),
            $this->getCloudwatchMessage('INSUFFICIENT_DATA', 'OK'),
        ];

        foreach ($payloads as $payload) {
            $this->sendSnsMessage(route('cloudwatch'), $payload)
                ->assertSee('OK');
        }
    }
}
