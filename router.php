<?php

namespace staifa\php_bandwidth_hero_proxy\router;

function route()
{
    return function ($ctx) {
        ["config" => ["route" => $route],
            "buffer" => $buffer,
            "http" => $http] = $ctx;
        if ($route == "/") {
            return $ctx;
        }
        if ($route == "/favicon.ico") {
            http["http_response_code"](204);
            buffer["clean"]();
            echo null;
        };
        return false;
    };
};
