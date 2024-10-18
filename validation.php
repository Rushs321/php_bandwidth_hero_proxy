<?php

namespace staifa\php_bandwidth_hero_proxy\validation;

use function \staifa\php_bandwidth_hero_proxy\bypass\bypass;

// Checks if the response will be processed or proxied
// This function is used in main flow control
function should_compress(): callable {
  return function($conf) {
    $run_checks = function($conf) {
      ["webp" => $webp,
       "response" => $response,
       "min_compress_length" => $min_compress_length,
       "min_transparent_compress_length" => $min_transparent_compress_length,
       "request_uri" => $request_uri,
       "target_url" => $target_url,
       "request_headers" => [
         "origin-type" => $origin_type,
         "origin-size" => $origin_size]] = $conf;
      return !isset($request_uri)
      || !isset($target_url)
      || !str_starts_with($origin_type, "image")
      || (int)$origin_size == 0
      || $webp && $origin_size < $min_compress_length
      || (!$webp
           && (str_ends_with($origin_type, "png")
             || str_ends_with($origin_type, "gif"))
           && $origin_size < $min_transparent_compress_length);
    };

    if ($run_checks($conf)) return bypass($conf);
    return $conf;
  };
};
