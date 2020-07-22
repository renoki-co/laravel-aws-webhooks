<?php

namespace RenokiCo\AwsWebhooks\Test;

use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    /**
     * The default topic ARN to apply in case
     * none is specified when building messages.
     *
     * @var string
     */
    protected static $defaultTopicArn = 'arn:aws:sns:us-west-2:123456789012:MyTopic';

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

    /**
     * Get an example notification payload for testing.
     *
     * @param  array  $payload
     * @param  string|null  $topicArn
     * @return array
     */
    protected function getNotificationPayload(array $payload = [], string $topicArn = null): array
    {
        $payload = json_encode($payload);

        $topicArn = $topicArn ?: static::$defaultTopicArn;

        return [
            'Type' => 'Notification',
            'MessageId' => '22b80b92-fdea-4c2c-8f9d-bdfb0c7bf324',
            'TopicArn' => "{$topicArn}",
            'Subject' => 'My First Message',
            'Message' => "{$payload}",
            'Timestamp' => '2012-05-02T00:54:06.655Z',
            'SignatureVersion' => '1',
            'Signature' => 'EXAMPLEw6JRN...',
            'SigningCertURL' => 'https://sns.us-west-2.amazonaws.com/SimpleNotificationService-f3ecfb7224c7233fe7bb5f59f96de52f.pem',
            'UnsubscribeURL' => 'https://sns.us-west-2.amazonaws.com/?Action=Unsubscribe&SubscriptionArn=arn:aws:sns:us-west-2:123456789012:MyTopic:c9135db0-26c4-47ec-8998-413945fb5a96',
        ];
    }

    /**
     * Get the SES message for mails.
     *
     * @param  string  $type
     * @return array
     */
    public function getSesMessage(string $type): array
    {
        return $this->getNotificationPayload([
            'eventType' => $type,
        ]);
    }
}
