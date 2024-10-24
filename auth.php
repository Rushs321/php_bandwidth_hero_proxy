<?php

namespace staifa\php_bandwidth_hero_proxy\auth;

// Basic auth
function authenticate()
{
    return function ($ctx) {
        extract($ctx["config"], EXTR_REFS);
        extract($ctx["http"], EXTR_REFS);

        if ($request["PHP_AUTH_USER"] == $auth_user
          && $request["PHP_AUTH_PW"] == $auth_password
          && array_reduce([$auth_password, $auth_user, $request["PHP_AUTH_USER"], $request["PHP_AUTH_PW"]], fn ($v) => isset($v))) {
            return $ctx;
        };

        $set_header("WWW-Authenticate: Basic realm=\"Bandwidth-Hero Compression Service\"");
        $set_status(401);
        ob_clean();
        echo "Access denied";
    };
};
