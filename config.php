<?php

namespace staifa\php_bandwidth_hero_proxy\config;

const DEFAULT_QUALITY = 40;
const MIN_COMPRESS_LENGTH = 1024;

// Creates a static configuration
// This function is used in main flow control
function create(): callable {
  return fn() => [
    "quality" => ctype_digit($_REQUEST["default_quality"]) || DEFAULT_QUALITY,
    "auth_user" => $_ENV["BHERO_LOGIN"],
    "auth_password" => $_ENV["BHERO_PASSWORD"],
    "greyscale" => $_REQUEST["bw"] ==! 0,
    "min_compress_length" => MIN_COMPRESS_LENGTH,
    "request_params" => $_REQUEST,
    "request_uri" => $_SERVER["REQUEST_URI"],
    "request" => $_SERVER,
    "webp" => !$_REQUEST["jpeg"]
  ];
}
