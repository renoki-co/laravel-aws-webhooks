<?php

namespace RenokiCo\AwsWebhooks\Test;

use Orchestra\Testbench\TestCase as Orchestra;
use Rennokki\LaravelSnsEvents\Concerns\GeneratesSnsMessages;
use RenokiCo\AwsWebhooks\Concerns\GeneratesSnsWebhookMessages;

abstract class TestCase extends Orchestra
{
    use GeneratesSnsMessages;
    use GeneratesSnsWebhookMessages;

    /**
     * {@inheritdoc}
     */
    protected function getPackageProviders($app)
    {
        return [
            \RenokiCo\AwsWebhooks\AwsWebhooksServiceProvider::class,
            TestServiceProvider::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('app.key', 'wslxrEFGWY6GfGhvN9L3wH3KSRJQQpBD');
    }
}
