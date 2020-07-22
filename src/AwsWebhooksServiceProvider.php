<?php

namespace RenokiCo\AwsWebhooks;

use Illuminate\Support\ServiceProvider;

class AwsWebhooksServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/aws-webhooks.php' => config_path('aws-webhooks.php'),
        ]);

        $this->mergeConfigFrom(
            __DIR__.'/../config/aws-webhooks.php', 'aws-webhooks'
        );
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
