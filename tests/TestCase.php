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
     * @return array
     */
    protected function getNotificationPayload(array $payload = []): array
    {
        $payload = json_encode($payload);

        return [
            'Type' => 'Notification',
            'MessageId' => '22b80b92-fdea-4c2c-8f9d-bdfb0c7bf324',
            'TopicArn' => 'arn:aws:sns:us-west-2:123456789012:MyTopic',
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

    /**
     * Get an example cloudwatch notification payload.
     *
     * @param  string  $currentState
     * @param  string  $previousState
     * @return array
     */
    public function getCloudwatchNotificationPayload(string $currentState = 'ALARM', string $previousState = 'OK'): array
    {
        $alarm = [
            'AlarmName' => 'Some Alarm',
            'AlarmDescription' => 'This is the alarm description. Pass it some nice info.',
            'AWSAccountId' => '305476205504',
            'NewStateValue' => $currentState,
            'NewStateReason' => 'Threshold Crossed: 1 out of the last 1 datapoints [1.83333333333091 (24/06/20 20:25:00)] was greater than the threshold (1.6) (minimum 1 datapoint for OK -> ALARM transition).',
            'StateChangeTime' => '2020-06-24T20:27:43.474+0000',
            'Region' => 'US East (N. Virginia)',
            'AlarmArn' => 'arn:aws:cloudwatch:us-east-1:305476205504:alarm:Some Alarm',
            'OldStateValue' => $previousState,
            'Trigger' => [
                'MetricName' => 'CPUUtilization',
                'Namespace' => 'AWS/RDS',
                'StatisticType' => 'Statistic',
                'Statistic' => 'AVERAGE',
                'Unit' => null,
                'Dimensions' => [
                    [
                        'value' => 'some-db-identifier',
                        'name' => 'DBInstanceIdentifier',
                    ],
                ],
                'Period' => 60,
                'EvaluationPeriods' => 1,
                'ComparisonOperator' => 'GreaterThanThreshold',
                'Threshold' => 1.6,
                'EvaluateLowSampleCountPercentile' => '',
            ],
        ];

        return $this->getNotificationPayload($alarm);
    }
}
