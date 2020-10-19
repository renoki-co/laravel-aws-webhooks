<?php

namespace RenokiCo\AwsWebhooks\Test;

class EventbridgeTest extends TestCase
{
    public function test_call_with_existing_event()
    {
        $payload = $this->getGameliftMessage();

        $this->withHeaders($this->getHeadersForMessage($payload))
            ->json('GET', route('eventbridge', ['certificate' => static::$certificate]), $payload)
            ->assertSee('OK');
    }

    public function test_call_with_inexisting_event()
    {
        $payload = $this->getEc2Message();

        $this->withHeaders($this->getHeadersForMessage($payload))
            ->json('GET', route('eventbridge', ['certificate' => static::$certificate]), $payload)
            ->assertSee('OK');
    }
}
