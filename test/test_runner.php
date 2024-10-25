<?php

namespace staifa\php_bandwidth_hero_proxy\test\test_runner;

error_reporting(E_ERROR);

include_once("fixtures/globals.php");
include_once("../auth.php");
include_once("../util.php");
include_once("../main.php");
include_once("../middleware/context_logger.php");
include_once("auth_test.php");
include_once("main_test.php");
include_once("middleware/context_logger_test.php");
include_once("fixtures/config.php");

use staifa\php_bandwidth_hero_proxy\test\fixtures\config;
use staifa\php_bandwidth_hero_proxy\test\auth_test;
use staifa\php_bandwidth_hero_proxy\test\main_test;
use staifa\php_bandwidth_hero_proxy\test\middleware\context_logger_test;

ob_start();
(auth_test\success(config\mock()()));
(auth_test\failure(config\mock()()));
(main_test\success_webp(config\mock()));
(main_test\success_webp_greyscale(config\mock()));
(main_test\success_webp_greyscale_explicit(config\mock()));
(main_test\success_webp_quality(config\mock()));
(main_test\success_png(config\mock()));
(main_test\success_gif(config\mock()));
(main_test\success_jpeg(config\mock()));
(context_logger_test\success_log(config\mock()));
ob_clean();
