<?php

namespace RenokiCo\AwsWebhooks\Test;

class SesTest extends TestCase
{
    public function test_calling_existing_method()
    {
        $payload = $this->getSesMessage('Rendering Failure');

        $this->sendSnsMessage(route('ses'), $payload)
            ->assertSee('OK');
    }

    public function test_calling_inexisting_method()
    {
        $payload = $this->getSesMessage('Bounce');

        $this->sendSnsMessage(route('ses'), $payload)
            ->assertSee('OK');
    }
}
