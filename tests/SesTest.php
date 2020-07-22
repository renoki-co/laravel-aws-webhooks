<?php

namespace RenokiCo\AwsWebhooks\Test;

use RenokiCo\AwsWebhooks\Http\Controllers\SesWebhook;

class SesTest extends TestCase
{
    public function test_callable_methods()
    {
        foreach (SesWebhook::$eventTypesWithCalledMethod as $callableEventType => $methodToCall) {
            $this
                ->json('GET', route('ses'), $this->getSesMessage($callableEventType))
                ->assertSee('OK');
        }
    }
}
