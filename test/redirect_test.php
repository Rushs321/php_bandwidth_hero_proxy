<?php

namespace staifa\php_bandwidth_hero_proxy\test\redirect_test;

use function staifa\php_bandwidth_hero_proxy\main\run;

function with_sent_headers($config)
{
    $c = $config();
    $c["http"]["c_info"] = fn ($_, $__) => 400;
    $c["http"]["headers_sent"] = fn () => true;
    $c = fn () => $c;

    run($c);
    $exp_headers = [];

    assert($_SERVER["headers"] == $exp_headers);
}

function without_sent_headers($config)
{
    $c = $config();
    $c["http"]["c_info"] = fn ($_, $__) => 400;
    $c = fn () => $c;

    run($c);
    $exp_headers = ["content-length: 0", "location: foo.com"];

    assert($_SERVER["status"] == 302);
    assert($_SERVER["headers"] == $exp_headers);
}
