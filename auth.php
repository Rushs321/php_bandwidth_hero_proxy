<?php

namespace staifa\php_bandwidth_hero_proxy\auth;

// Basic auth
function authenticate(): callable {
  return function($context) {
    ["request" => $req,
     "auth_user" => $user,
     "auth_password" => $pw] = $context;

    if ((isset($user) && $req["PHP_AUTH_USER"] == $user) AND
      (isset($pw) && $req["PHP_AUTH_PW"] == $pw)) { return $context; };

    header("WWW-Authenticate: Basic realm=\"Bandwidth-Hero Compression Service\"");
    http_response_code(401);
    ob_clean();
    echo "Access denied";
  };
};
