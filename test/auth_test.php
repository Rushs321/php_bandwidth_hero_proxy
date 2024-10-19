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
    $cl = authenticate();
    ob_start();
    $cl($ctx);
    $res = ob_get_contents();
    ob_end_clean();
    return assert($res == "Access denied");
}
