<?php

namespace staifa\php_bandwidth_hero_proxy\context;

use \staifa\php_bandwidth_hero_proxy\services\curl;
use function \staifa\php_bandwidth_hero_proxy\util\compose;

function resolve_route($uri) {
  return ($pos = strpos($uri, '?')) ? substr($uri, 0, $pos) : $uri;
}

function process_url($config) {
  $pattern = "/http:\/\/1\.1\.\d\.\d\/bmi\/(https?:\/\/)?/i";
  return preg_replace($pattern, "http://", $config["request"]["url"]);
}

function add_computed_values() {
  return fn($config) => $config += [
    "min_transparent_compress_length" => $config["min_compress_length"] * 100,
    "route" => resolve_route($config["request_uri"]),
    "target_url" => process_url($config)
  ];
}

function add_instances() {
  return fn($config) => $config += ["services" => ["curl" => curl\init($config["target_url"])]];
}

function create(): callable {
  return function($config) {
    return compose(add_instances(), add_computed_values())($config);
  };
};
