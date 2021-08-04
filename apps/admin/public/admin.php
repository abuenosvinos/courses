<?php

use App\AdminKernel;

require_once dirname(__DIR__) . '../../../vendor/autoload_runtime.php';

return function (array $context) {
    return new AdminKernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};
