<?php

namespace RenokiCo\AwsWebhooks\Concerns;

trait FiltersTopicArns
{
    /**
     * List the allowed SNS Topic ARNs
     * that are allowed to run the business logic.
     *
     * @var array
     */
    protected static $allowedTopicArns = [
        //
    ];

    /**
     * Check if the topic ARN from
     * the SNS message is whitelisted.
     *
     * @param  array  $snsMessage
     * @return bool
     */
    protected function shouldAllow(array $snsMessage): bool
    {
        return in_array(
            $snsMessage['TopicArn'] ?? null, static::$allowedTopicArns
        );
    }
}
