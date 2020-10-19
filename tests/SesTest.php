<?php

namespace RenokiCo\AwsWebhooks\Test;

use RenokiCo\AwsWebhooks\Http\Controllers\SesWebhook;

class SesTest extends TestCase
{
    public function test_calling_existing_method()
    {
        $payload = $this->getSesMessage('Rendering Failure');

        $this->withHeaders($this->getHeadersForMessage($payload))
            ->json('GET', route('ses', ['certificate' => static::$certificate]), $payload)
            ->assertSee('OK');
    }

    public function test_calling_inexisting_method()
    {
        $payload = $this->getSesMessage('Bounce');

        $this->withHeaders($this->getHeadersForMessage($payload))
            ->json('GET', route('ses', ['certificate' => static::$certificate]), $payload)
            ->assertSee('OK');
    }
}
