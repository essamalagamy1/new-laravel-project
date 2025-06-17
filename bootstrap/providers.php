<?php

use App\Providers\AuthServiceProvider;

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\VoltServiceProvider::class,
    AuthServiceProvider::class,
];
