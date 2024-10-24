<?php

namespace staifa\php_bandwidth_hero_proxy\validation;

use function staifa\php_bandwidth_hero_proxy\bypass\bypass;

// Checks if the response will be processed or proxied
// This function is used in main flow control
function should_compress()
{
    return function ($ctx) {
        $run_checks = function ($ctx) {
            extract($ctx["config"], EXTR_REFS);
            extract($request_headers, EXTR_REFS);

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

        if ($run_checks($ctx)) {
            return bypass($ctx);
        }
        return $ctx;
    };
};
