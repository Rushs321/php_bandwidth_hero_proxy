<?php

namespace staifa\php_bandwidth_hero_proxy\config;

const DEFAULT_QUALITY = 40;
const MIN_COMPRESS_LENGTH = 1024;

function create(): callable {
  return fn() => [
    "default_quality" => ctype_digit($_GET["default_quality"]) || DEFAULT_QUALITY,
    "greyscale" => $_GET["bw"] ==! 0,
    "min_compress_length" => MIN_COMPRESS_LENGTH,
    "request" => $_GET,
    "request_uri" => $_SERVER["REQUEST_URI"],
    "server" => $_SERVER,
    "webp" => !$_GET["jpeg"]
  ];
}
