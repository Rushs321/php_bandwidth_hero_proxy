<?php

namespace staifa\php_bandwidth_hero_proxy\fixtures\env;

$_REQUEST["url"] = "poodle.com";
$_REQUEST["default_quality"] = "30";
$_REQUEST["jpeg"] = null;
$_REQUEST["bw"] = "0";
$_REQUEST["url"] = "foo.com";
$_ENV["BHERO_LOGIN"] = "foo";
$_ENV["BHERO_PASSWORD"] = "bar";
$_SERVER = [];
$_SERVER["headers"] = [];
$_SERVER["PHP_AUTH_USER"] = "foo";
$_SERVER["PHP_AUTH_PW"] = "bar";
$_SERVER["REQUEST_URI"] = "/?url=foo.com";
