<?php

namespace staifa\php_bandwidth_hero_proxy\test\test_runner;

error_reporting(E_ERROR);

include_once("../auth.php");
include_once("../util.php");
include_once("auth_test.php");
include_once("fixtures/env.php");
include_once("fixtures/config.php");

use \staifa\php_bandwidth_hero_proxy\test\fixtures\config;
use \staifa\php_bandwidth_hero_proxy\test\auth_test;

(auth_test\success(config\mock()));
(auth_test\failure(config\mock()));
