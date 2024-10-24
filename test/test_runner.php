<?php

namespace staifa\php_bandwidth_hero_proxy\test\test_runner;

error_reporting(E_ERROR);

include_once("fixtures/env.php");
include_once("../auth.php");
include_once("../util.php");
include_once("auth_test.php");
include_once("../main.php");
include_once("main_test.php");
include_once("fixtures/config.php");

use staifa\php_bandwidth_hero_proxy\test\fixtures\config;
use staifa\php_bandwidth_hero_proxy\test\auth_test;
use staifa\php_bandwidth_hero_proxy\test\main_test;

(auth_test\success(config\mock()()));
(auth_test\failure(config\mock()()));
(main_test\success_webp(config\mock()));
(main_test\success_jpeg(config\mock()));
