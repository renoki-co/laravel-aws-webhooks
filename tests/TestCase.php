<?php

namespace RenokiCo\AwsWebhooks\Test;

use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    /**
     * {@inheritdoc}
     */
    protected function getPackageProviders($app)
    {
        return [
            \RenokiCo\SnsWebhooks\SnsWebhooksServiceProvider::class,
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
