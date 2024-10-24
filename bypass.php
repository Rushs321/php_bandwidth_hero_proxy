<?php

namespace staifa\php_bandwidth_hero_proxy\bypass;

// Sets bypass headers and returns the response with unchanged body
// Ends the flow execution
function bypass($ctx)
{
    extract($ctx["config"]["response"], EXTR_REFS);
    extract($ctx["http"], EXTR_REFS);

    array_walk($headers, fn ($v, $k) => $set_header($k . ": " . $v));
    $set_header("x-proxy-bypass: 1");
    $set_header("content-length: " . strlen($data));
    $header_remove("Transfer-Encoding");

    ob_clean();
    echo $data;
}
