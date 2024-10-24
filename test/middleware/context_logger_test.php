<?php

namespace staifa\php_bandwidth_hero_proxy\test\middleware\context_logger_test;

include("../../middleware/context_logger.php");

use function staifa\php_bandwidth_hero_proxy\middleware\context_logger\wrap_context_logger;

function success_log($ctx)
{
    $failing_fn = fn ($_) => throw new \Exception("error_to_log");

    try {
        wrap_context_logger($failing_fn)($ctx());
    } catch (\Exception $e) {
        // check that the exception went through the middleware
        assert(str_contains($e, "middleware/context_logger.php"));
    }
};
