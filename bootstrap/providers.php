<?php

use App\Providers\ApiResponseServiceProvider;
use App\Providers\AppServiceProvider;
use App\Providers\AuthServiceProvider;
use App\Providers\ConfigurationServiceServiceProvider;
use App\Providers\ExceptionServiceProvider;
use App\Providers\PaymentServiceProvider;

return [
    ExceptionServiceProvider::class,
    AppServiceProvider::class,
    AuthServiceProvider::class,
    ConfigurationServiceServiceProvider::class,
    ApiResponseServiceProvider::class,
    PaymentServiceProvider::class,
];
