<?php

namespace staifa\php_bandwidth_hero_proxy\test\fixtures\config;

include_once("../boundary/buffer.php");
include_once("../boundary/http.php");
include_once("../boundary/image.php");
include_once("../boundary/logger.php");

include_once("../config.php");
include_once("fixtures/boundaries.php");

use staifa\php_bandwidth_hero_proxy\config;
use staifa\php_bandwidth_hero_proxy\test\fixtures\boundaries;

function mock()
{
    $ctx = config\create();
    $ctx = $ctx();
    $ctx["buffer"] = boundaries\buffer();
    $ctx["http"] = boundaries\http();
    $ctx["logger"] = boundaries\logger();
    $ctx["config"] = [
      "request" => [
        "PHP_AUTH_USER" => "foo", "PHP_AUTH_PW" => "bar"],
      "auth_user" => "foo", "auth_password" => "bar"];
    return $ctx;
};
