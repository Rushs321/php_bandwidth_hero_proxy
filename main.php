<?php

namespace staifa\php_bandwidth_hero_proxy\main;

include_once("auth.php");
include_once("bypass.php");
include_once("compression.php");
include_once("main.php");
include_once("proxy.php");
include_once("router.php");
include_once("util.php");
include_once("redirect.php");
include_once("validation.php");
include_once("validation.php");

include_once("boundary/http.php");
include_once("boundary/image.php");

include_once("middleware/cleanup.php");
include_once("middleware/context_logger.php");

use staifa\php_bandwidth_hero_proxy\auth;
use staifa\php_bandwidth_hero_proxy\compression;
use staifa\php_bandwidth_hero_proxy\proxy;
use staifa\php_bandwidth_hero_proxy\router;
use staifa\php_bandwidth_hero_proxy\validation;

use function staifa\php_bandwidth_hero_proxy\middleware\cleanup\wrap_graceful_shutdown;
use function staifa\php_bandwidth_hero_proxy\middleware\context_logger\wrap_context_logger;
use function staifa\php_bandwidth_hero_proxy\util\flow;

// Main execution loop
function run($config)
{
    wrap_context_logger(
        wrap_graceful_shutdown(
            fn ($ctx) =>
    flow(
        $ctx,
        auth\authenticate(),
        router\route(),
        proxy\send_request(),
        validation\should_compress(),
        compression\process_image()
    )
        )
    )($config());
};
