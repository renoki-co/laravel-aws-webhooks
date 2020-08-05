<?php

namespace RenokiCo\AwsWebhooks\Test;

use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    use Concerns\GeneratesSnsMessages;

    /**
     * {@inheritdoc}
     */
    public static function setUpBeforeClass(): void
    {
        static::initializeSsl();
    }

    /**
     * {@inheritdoc}
     */
    public static function tearDownAfterClass(): void
    {
        static::tearDownSsl();
    }

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
    public function getCloudwatchMessage(string $currentState = 'ALARM', string $previousState = 'OK'): array
    {
        return $this->getNotificationPayload([
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
        ]);
    }
}
