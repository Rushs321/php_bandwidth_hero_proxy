<?php

namespace staifa\php_bandwidth_hero_proxy\index;

/**
 * @author František Štainer <https://github.com/staifa>
 * @license https://opensource.org/license/mit
 * @package staifa\php_bandwidth_hero_proxy\main
 *
 * Credits to:
 *    https://github.com/ayastreb/bandwidth-hero
 *    https://github.com/ayastreb/bandwidth-hero-proxy
 *
 * Usage:
 *    Just run it.
 *    See docs at config.php for configuration options
 *    and other files for inner working explanations.
 *
 * Compatibility:
 *    PHP >=8.3.11
 *    libcurl
 *    GD
 */

ini_set('display_errors', 0);

include_once("auth.php");
include_once("bypass.php");
include_once("compression.php");
include_once("config.php");
include_once("proxy.php");
include_once("router.php");
include_once("util.php");
include_once("redirect.php");
include_once("validation.php");

include_once("boundary/buffer.php");
include_once("boundary/http.php");
include_once("boundary/image.php");
include_once("boundary/logger.php");

include_once("middleware/cleanup.php");
include_once("middleware/context_logger.php");

use \staifa\php_bandwidth_hero_proxy\auth;
use \staifa\php_bandwidth_hero_proxy\compression;
use \staifa\php_bandwidth_hero_proxy\config;
use \staifa\php_bandwidth_hero_proxy\proxy;
use \staifa\php_bandwidth_hero_proxy\router;
use \staifa\php_bandwidth_hero_proxy\validation;

use function \staifa\php_bandwidth_hero_proxy\middleware\cleanup\clean_instances;
use function \staifa\php_bandwidth_hero_proxy\middleware\context_logger\wrap_context_logger;
use function \staifa\php_bandwidth_hero_proxy\util\flow;

// Main execution loop
function run($config) {
  flow(
    $config(),
    auth\authenticate(),
    router\route(),
    proxy\send_request(),
    validation\should_compress(),
    compression\process_image()
  );
}

wrap_context_logger(
  clean_instances(
  run(config\create())
));
