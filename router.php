<?php

namespace staifa\php_bandwidth_hero_proxy\router;

function route()
{
    return function ($ctx) {
        extract($ctx["config"], EXTR_REFS);
        extract($ctx["http"], EXTR_REFS);

        if ($route == "/") {
            return $ctx;
        }
        if ($route == "/favicon.ico") {
            $http_response_code(204);
            ob_clean();
            echo null;
        };
        return false;
    };
};
