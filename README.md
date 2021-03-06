Laravel AWS Webhooks
====================

![CI](https://github.com/renoki-co/laravel-aws-webhooks/workflows/CI/badge.svg?branch=master)
[![codecov](https://codecov.io/gh/renoki-co/laravel-aws-webhooks/branch/master/graph/badge.svg)](https://codecov.io/gh/renoki-co/laravel-aws-webhooks/branch/master)
[![StyleCI](https://github.styleci.io/repos/281713043/shield?branch=master)](https://github.styleci.io/repos/281713043)
[![Latest Stable Version](https://poser.pugx.org/renoki-co/laravel-aws-webhooks/v/stable)](https://packagist.org/packages/renoki-co/laravel-aws-webhooks)
[![Total Downloads](https://poser.pugx.org/renoki-co/laravel-aws-webhooks/downloads)](https://packagist.org/packages/renoki-co/laravel-aws-webhooks)
[![Monthly Downloads](https://poser.pugx.org/renoki-co/laravel-aws-webhooks/d/monthly)](https://packagist.org/packages/renoki-co/laravel-aws-webhooks)
[![License](https://poser.pugx.org/renoki-co/laravel-aws-webhooks/license)](https://packagist.org/packages/renoki-co/laravel-aws-webhooks)

Laravel AWS Webhooks is a fine integration of Laravel controllers that help you build fast business logic when your SNS topic gets notified. This comes handy in situations like SES when you need to unsubscribe users whose mails bounce or if they complain about it.

This package leverages [renoki-co/laravel-sns-events](https://github.com/renoki-co/laravel-sns-events) that allows listening to HTTP/HTTPS requests properly.

## 🤝 Supporting

Renoki Co. on GitHub aims on bringing a lot of open source projects and helpful projects to the world. Developing and maintaining projects everyday is a harsh work and tho, we love it.

If you are using your application in your day-to-day job, on presentation demos, hobby projects or even school projects, spread some kind words about our work or sponsor our work. Kind words will touch our chakras and vibe, while the sponsorships will keep the open source projects alive.

[![ko-fi](https://www.ko-fi.com/img/githubbutton_sm.svg)](https://ko-fi.com/R6R42U8CL)

## 🚀 Installation

You can install the package via composer:

```bash
composer require renoki-co/laravel-aws-webhooks
```

## 🙌 Usage

The package comes with more controllers that will handle each service separately, so you should be implementing different topics for each controller.

You should create a controller that extends once of the package controllers, based on the service you want to get SNS notifications from:

- `\RenokiCo\AwsWebhooks\Http\Controllers\SesWebhook`
- `\RenokiCo\AwsWebhooks\Http\Controllers\CloudwatchWebhook`
- `\RenokiCo\AwsWebhooks\Http\Controllers\EventbridgeWebhook`

A controller that will handle the response for you should be extended & registered in your routes:

```php
use RenokiCo\AwsWebhooks\Http\Controllers\SesWebhook;

class MySesController extends SesWebhook
{
    /**
     * Handle the Bounce event.
     *
     * @param  array  $message
     * @param  array  $originalMessage
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function onBounce(array $message, array $originalMessage, Request $request)
    {
        // Unsubscribe the user from newsletter in case of bounce.

        foreach ($message['bounce']['bouncedRecipients'] as $recipient) {
            if ($user = User::whereEmail($recipient['emailAddress'])->first()) {
                $user->update([
                    'subscribed' => false,
                ]);
            }
        }
    }
}
```

```php
// You can choose any route.
Route::any('/aws/sns/ses', 'MySesController@handle');
```

Make sure to to whitelist your route in your `VerifyCsrfToken.php`:

```php
protected $except = [
    ...
    'aws/sns/ses/',
];
```

If you have registered the route and created a SNS Topic, you should register the URL and click the confirmation button from the AWS Dashboard. In a short while, if you implemented the route well, you'll be seeing that your endpoint is registered.

## Simple Email Service (SES)

Simple Email Service integrates with SNS to send notifications regarding mails. For example, you can catch bouncers or click/opens for various addresses.

All methods accept the same parameters.

`$message` is the array message of the content, while `$originalMessage` is the entire SNS message as array.

```php
use RenokiCo\AwsWebhooks\Http\Controllers\SesWebhook;

class MySesController extends SesWebhook
{
    /**
     * Handle the Bounce event.
     *
     * @param  array  $message
     * @param  array  $originalMessage
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function onComplaint(array $message, array $originalMessage, Request $request)
    {
        //
    }

    protected function onDelivery(array $message, array $originalMessage, Request $request)
    {
        //
    }

    protected function onSend(array $message, array $originalMessage, Request $request)
    {
        //
    }

    protected function onReject(array $message, array $originalMessage, Request $request)
    {
        //
    }

    protected function onOpen(array $message, array $originalMessage, Request $request)
    {
        //
    }

    protected function onClick(array $message, array $originalMessage, Request $request)
    {
        //
    }

    protected function onRenderingFailure(array $message, array $originalMessage, Request $request)
    {
        //
    }

    protected function onDeliveryDelay(array $message, array $originalMessage, Request $request)
    {
        //
    }
}
```

## Cloudwatch Alerts

Cloudwatch Alerts sends notifications via SNS to your topics when an alarm state changed. For example, you can listen to all the OK and ALARM statuses and implement your own logic to send Slack notifications to your organisation.

`$message` is the array message of the content, while `$originalMessage` is the entire SNS message as array.

```php
use RenokiCo\AwsWebhooks\Http\Controllers\CloudwatchWebhook;

class MyCloudwatchController extends CloudwatchWebhook
{
    /**
     * Handle the event when an alarm transitioned to OK.
     *
     * @param  array  $message
     * @param  array  $originalMessage
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function onOkState(array $message, array $originalMessage, Request $request)
    {
        //
    }

    /**
     * Handle the event when an alarm transitioned to ALARM.
     *
     * @param  array  $message
     * @param  array  $originalMessage
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function onAlarmState(array $message, array $originalMessage, Request $request)
    {
        //
    }

    /**
     * Handle the event when an alarm transitioned to INSUFFICIENT_DATA.
     *
     * @param  array  $message
     * @param  array  $originalMessage
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function onInsufficientDataState(array $message, array $originalMessage, Request $request)
    {
        //
    }
}
```

## EventBridge Events

EventBridge is supported for all `aws.*` sources coming within the message payload. You can implement your own methods just by creating a method similar to `on[source_name]Event`.

For example, you might have this EC2 Spot Termination notice:

```json
{
   "id":"7bf73129-1428-4cd3-a780-95db273d1602",
   "detail-type":"EC2 Instance State-change Notification",
   "source":"aws.ec2",
   "account":"123456789012",
   "time":"2015-11-11T21:29:54Z",
   "region":"us-east-1",
   "resources":[
      "arn:aws:ec2:us-east-1:123456789012:instance/i-abcd1111"
   ],
   "detail":{
      "instance-id":"i-abcd1111",
      "state":"pending"
   }
}
```

Because the source is called `aws.ec2`, you should create a `onEc2Event` method within your extended class:

```php
use RenokiCo\AwsWebhooks\Http\Controllers\EventbridgeWebhook;

class MyEventbridgeController extends EventbridgeWebhook
{
    /**
     * Handle the EC2 events.
     *
     * @param  array  $message
     * @param  array  $originalMessage
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function onEc2Event(array $message, array $originalMessage, Request $request)
    {
        foreach ($message['resources'] as $instanceArn) {
            //
        }
    }
}
```

## 🐛 Testing

``` bash
vendor/bin/phpunit
```

## 🤝 Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## 🔒  Security

If you discover any security related issues, please email alex@renoki.org instead of using the issue tracker.

## 🎉 Credits

- [Alex Renoki](https://github.com/rennokki)
- [All Contributors](../../contributors)
