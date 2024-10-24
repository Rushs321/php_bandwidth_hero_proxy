<?php

namespace staifa\php_bandwidth_hero_proxy\test\main_test;

use function staifa\php_bandwidth_hero_proxy\main\app;

function success_webp($config)
{
    $body = app($config);
    $exp_headers = ["content-type: image",
              "content-encoding: identity",
              "content-length: 250",
              "content-type: image/webp",
              "x-original-size: 328",
              "x-bytes-saved: 78"];

    assert($_SERVER["headers"] == $exp_headers);
    return assert(str_starts_with("RIFF:WEBPVP8X", $body));
}

function success_jpeg($config)
{
    $_SERVER["REQUEST_URI"] = "/?url=foo.com&jpeg=true";
    $_REQUEST["jpeg"] = true;
    $c = $config();
    $c["http"]["c_exec"] = function ($_) { return file_get_contents('./fixtures/images/img.jpg'); };
    $c = fn () => $c;

    $body = app($c);
    $exp_headers = ["content-type: image",
              "content-encoding: identity",
              "content-length: 970",
              "content-type: image/jpeg",
              "x-original-size: 8498",
              "x-bytes-saved: 7528"];

    assert($_SERVER["headers"] == $exp_headers);
    return assert(str_starts_with("RIFF:WEBPVP8X", $body));
}
