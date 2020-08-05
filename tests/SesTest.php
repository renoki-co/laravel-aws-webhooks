<?php

namespace RenokiCo\AwsWebhooks\Test;

use RenokiCo\AwsWebhooks\Http\Controllers\SesWebhook;

class SesTest extends TestCase
{
    public function test_callable_methods()
    {
        foreach (SesWebhook::$eventTypesWithCalledMethod as $callableEventType => $methodToCall) {
            $payload = $this->getSesMessage($callableEventType);

            $this->withHeaders($this->getHeadersForMessage($payload))
                ->json('GET', route('ses', ['certificate' => static::$certificate]), $payload)
                ->assertSee('OK');
        }
    }
}
