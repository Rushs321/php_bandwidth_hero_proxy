<?php

namespace staifa\php_bandwidth_hero_proxy\test\fixtures\config;

include_once("../boundary/http.php");
include_once("../config.php");
include_once("fixtures/boundaries.php");

use staifa\php_bandwidth_hero_proxy\config;
use staifa\php_bandwidth_hero_proxy\test\fixtures\boundaries;
use staifa\php_bandwidth_hero_proxy\fixtures\globals;

function mock()
{
    globals\set_defaults();

    return function () {
        $ctx = config\create();
        $ctx = $ctx();

        $ctx["config"]["min_compress_length"] = 1;
        $ctx["http"] = boundaries\http();

        return $ctx;
    };
};
