<?php

use App\CoursesKernel;

require_once dirname(__DIR__) . '../../../vendor/autoload_runtime.php';

return function (array $context) {
    return new CoursesKernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};
