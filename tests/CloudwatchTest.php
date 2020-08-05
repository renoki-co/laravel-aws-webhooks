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
            $this->withHeaders($this->getHeadersForMessage($payload))
                ->json('GET', route('cloudwatch', ['certificate' => static::$certificate]), $payload)
                ->assertSee('OK');
        }
    }
}
