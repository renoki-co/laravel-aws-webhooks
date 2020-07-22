<?php

Route::any('/ses', 'RenokiCo\AwsWebhooks\Test\Controllers\SesController@handle')
    ->name('ses');
