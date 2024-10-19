<?php

namespace staifa\php_bandwidth_hero_proxy\auth;

// Basic auth
function authenticate()
{
    return function ($ctx) {
        ["http" => $http,
            "buffer" => $buffer,
            "config" => [
              "request" => $req,
              "auth_user" => $user,
              "auth_password" => $pw]] = $ctx;

        if ($req["PHP_AUTH_USER"] == $user
          && $req["PHP_AUTH_PW"] == $pw
          && array_reduce([$pw, $user, $req["PHP_AUTH_USER"], $req["PHP_AUTH_PW"]], fn ($v) => isset($v))) {
            return $ctx;
        };

        $http["set_header"]("WWW-Authenticate: Basic realm=\"Bandwidth-Hero Compression Service\"");
        $http["set_status"](401);
        $buffer["clean"]();
        echo "Access denied";
    };
};
