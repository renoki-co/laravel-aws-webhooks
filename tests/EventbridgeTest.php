<?php

namespace RenokiCo\AwsWebhooks\Test;

class EventbridgeTest extends TestCase
{
    public function test_call_with_existing_event()
    {
        $payload = $this->getGameliftMessage();

        $this->sendSnsMessage(route('eventbridge'), $payload)
            ->assertSee('OK');
    }

    public function test_call_with_inexisting_event()
    {
        $payload = $this->getEc2Message();

        $this->sendSnsMessage(route('eventbridge'), $payload)
            ->assertSee('OK');
    }
}
