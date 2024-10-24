<?php

namespace staifa\php_bandwidth_hero_proxy\fixtures\globals;

function set_defaults()
{
    $_REQUEST["url"] = "foo.com";
    $_ENV["BHERO_LOGIN"] = "foo";
    $_ENV["BHERO_PASSWORD"] = "bar";
    $_SERVER = [];
    $_SERVER["headers"] = [];
    $_SERVER["PHP_AUTH_USER"] = "foo";
    $_SERVER["PHP_AUTH_PW"] = "bar";
    $_SERVER["REQUEST_URI"] = "/?url=foo.com&bw=0";
    $_REQUEST["bw"] = 0;
    $_REQUEST["l"] = 1;
    unset($_REQUEST["jpeg"]);
};
