<?php

namespace staifa\php_bandwidth_hero_proxy\test\main_test;

use function staifa\php_bandwidth_hero_proxy\main\run;

function success_webp($config)
{
    $body = run($config);
    $exp_headers = ["content-type: image",
              "content-encoding: identity",
              "content-length: 322",
              "content-type: image/webp",
              "x-original-size: 328",
              "x-bytes-saved: 6"];

    assert($_SERVER["headers"] == $exp_headers);
    return assert(str_starts_with("RIFF:WEBPVP8X", $body));
}

// Greyscale setting works. The app returns greyscale
// images by default
function success_webp_greyscale($config)
{
    unset($_REQUEST["bw"]);
    $_SERVER["REQUEST_URI"] = "/?url=foo.com";
    $body = run($config);
    $exp_headers = ["content-type: image",
              "content-encoding: identity",
              "content-length: 250",
              "content-type: image/webp",
              "x-original-size: 328",
              "x-bytes-saved: 78"];

    assert($_SERVER["headers"] == $exp_headers);
    return assert(str_starts_with("RIFF:WEBPVP8X", $body));
}

function success_webp_greyscale_explicit($config)
{
    $_REQUEST["bw"] = 1;
    $_SERVER["REQUEST_URI"] = "/?url=foo.com?bw=1";
    $body = run($config);
    $exp_headers = ["content-type: image",
              "content-encoding: identity",
              "content-length: 250",
              "content-type: image/webp",
              "x-original-size: 328",
              "x-bytes-saved: 78"];

    assert($_SERVER["headers"] == $exp_headers);
    return assert(str_starts_with("RIFF:WEBPVP8X", $body));
}

// Setting quality works
function success_webp_quality($config)
{
    $_REQUEST["l"] = 80;
    $_SERVER["REQUEST_URI"] = "/?url=foo.com&l=80";
    $body = run($config);
    $exp_headers = ["content-type: image",
              "content-encoding: identity",
              "content-length: 664",
              "content-type: image/webp",
              "x-original-size: 328",
              "x-bytes-saved: -336"];

    assert($_SERVER["headers"] == $exp_headers);
    return assert(str_starts_with("RIFF:WEBPVP8X", $body));
}

function success_jpeg($config)
{
    $_SERVER["REQUEST_URI"] = "/?url=foo.com&jpeg=1";
    $_REQUEST["jpeg"] = 1;
    $c = $config();
    $c["http"]["c_exec"] = function ($_) { return file_get_contents('./fixtures/images/img.jpg'); };
    $c = fn () => $c;

    $body = run($c);
    $exp_headers = ["content-type: image",
              "content-encoding: identity",
              "content-length: 980",
              "content-type: image/jpeg",
              "x-original-size: 8498",
              "x-bytes-saved: 7518"];

    assert($_SERVER["headers"] == $exp_headers);
    return assert(str_starts_with("RIFF:WEBPVP8X", $body));
}
