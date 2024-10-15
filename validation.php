<?php

namespace staifa\php_bandwidth_hero_proxy\validation;

use function staifa\php_bandwidth_hero_proxy\util\vor;

function should_compress(): callable {
  return function($context) {
    $run_checks = function() use ($context) {
      ['webp' => $webp,
       'min_compress_length' => $min_compress_length,
       'min_transparent_compress_length' => $min_transparent_compress_length,
       'request_uri' => $request_uri,
       'target_url' => $target_url,
       'server' => ['HTTP_ORIGINTYPE' => $origin_type,
       'HTTP_ORIGINSIZE' => $origin_size]] = $context;
      return vor(
        !isset($request_uri),
        !isset($target_url),
        /*(!str_starts_with($origin_type, "image")),*/
        /*((int)$origin_size === 0),*/
        /*($webp && $origin_size < $min_compress_length),*/
        /*(!$webp*/
        /*  && (str_ends_with($origin_type, "png")*/
        /*    || str_ends_with($origin_type, "gif"))*/
        /*  && $origin_size < $min_transparent_compress_length)*/
      );
    };
    return fn() => $run_checks() ? false : $context;
  };
};
