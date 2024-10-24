<?php

namespace staifa\php_bandwidth_hero_proxy\test\auth_test;

include_once("../auth.php");

use function staifa\php_bandwidth_hero_proxy\auth\authenticate;

function success($ctx)
{
    $cl = authenticate();
    $res = $cl($ctx);
    return assert($res == $ctx);
}

function failure($ctx)
{
    unset($ctx["config"]["auth_user"]);

    ob_start();
    $cl = authenticate();
    $cl($ctx);
    $res = ob_get_contents();
    ob_end_clean();

    $exp_status = 401;
    $exp_header = 'WWW-Authenticate: Basic realm="Bandwidth-Hero Compression Service"';

    assert(in_array($exp_header, $_SERVER["headers"]));
    assert($_SERVER["status"] == $exp_status);
    return assert($res == "Access denied");
}
