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

include_once("main.php");

use function staifa\php_bandwidth_hero_proxy\main\run;

run();
