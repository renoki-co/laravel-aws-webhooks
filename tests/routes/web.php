<?php

Route::any('/ses', 'RenokiCo\AwsWebhooks\Test\Controllers\SesController@handle')
    ->name('ses');

Route::any('/cloudwatch', 'RenokiCo\AwsWebhooks\Test\Controllers\CloudwatchController@handle')
    ->name('cloudwatch');

Route::any('/eventbridge', 'RenokiCo\AwsWebhooks\Test\Controllers\EventbridgeController@handle')
    ->name('eventbridge');
