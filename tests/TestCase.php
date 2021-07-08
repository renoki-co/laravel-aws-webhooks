<?php

namespace RenokiCo\AwsWebhooks\Test;

use Orchestra\Testbench\TestCase as Orchestra;
use RenokiCo\AwsWebhooks\Concerns\GeneratesSnsMessages;

abstract class TestCase extends Orchestra
{
    use GeneratesSnsMessages;

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

    /**
     * Get an example EC2 notification payload.
     *
     * @return array
     */
    public function getEc2Message(): array
    {
        return $this->getNotificationPayload([
            'version' => 0,
            'id' => '72d6566c-e6bd-117d-5bbc-2779c679abd5',
            'detail-type' => 'EC2 Spot Instance Interruption Warning',
            'source' => 'aws.ec2',
            'account' => '12345678910',
            'time' => '2020-03-06T08:25:40Z',
            'region' => 'eu-west-1',
            'resources' => [
                'arn:aws:ec2:eu-west-1a:instance/i-0cefe48f36d7c281a',
            ],
            'detail' => [
                'instance-id' => 'i-0cefe48f36d7c281a',
                'instance-action' => 'terminate',
            ],
        ]);
    }

    /**
     * Get an example Gamelift notification payload.
     *
     * @return array
     */
    public function getGameliftMessage(): array
    {
        return $this->getNotificationPayload([
            'version' => 0,
            'id' => '72d6566c-e6bd-117d-5bbc-2779c679abd5',
            'detail-type' => 'GameLift Matchmaking Event',
            'source' => 'aws.gamelift',
            'account' => '12345678910',
            'time' => '2020-03-06T08:25:40Z',
            'region' => 'eu-west-1',
            'resources' => [
                'arn:aws:gamelift:us-west-2:123456789012:matchmakingconfiguration/SampleConfiguration',
            ],
            'detail' => [
                'tickets' => [
                    [
                        'ticketId' => 'ticket-1',
                        'startTime' => '2017-08-08T21:15:35.676Z',
                        'players' => [
                            ['playerId' => 'player-1'],
                        ],
                    ],
                ],
                'estimatedWaitMillis' => 'NOT_AVAILABLE',
                'type' => 'MatchmakingSearching',
                'gameSessionInfo' => [
                    'players' => [
                        ['playerId' => 'player-1'],
                    ],
                ],
            ],
        ]);
    }
}
