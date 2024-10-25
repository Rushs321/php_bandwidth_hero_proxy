<?php

namespace staifa\php_bandwidth_hero_proxy\redirect;

function redirect($ctx)
{
    extract($ctx["config"], EXTR_REFS);
    extract($ctx["http"], EXTR_REFS);
    if ($headers_sent()) {
        return false;
    }

    $set_header("content-length: 0");
    $to_remove = ["cache-control", "expires","date", "etag"];
    array_walk($to_remove, fn ($v, $k) => $header_remove($v));
    $set_header("location: " . $target_url);
    $set_status(302);

    return false;
};
