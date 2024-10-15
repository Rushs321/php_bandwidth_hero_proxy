<?php

namespace staifa\php_bandwidth_hero_proxy\main;

include_once('config.php');
include_once('context.php');
include_once('proxy.php');
include_once('services/curl.php');
include_once('util.php');
include_once('validation.php');

use \staifa\php_bandwidth_hero_proxy\config;
use \staifa\php_bandwidth_hero_proxy\context;
use \staifa\php_bandwidth_hero_proxy\proxy;
use \staifa\php_bandwidth_hero_proxy\validation;

use function \staifa\php_bandwidth_hero_proxy\util\flow;

function run() {
  flow(
    config\create(),
    context\create(),
    proxy\route(),
    proxy\send_request(),
    validation\should_compress(),
    /*$create_response()*/
  );
}

run();
