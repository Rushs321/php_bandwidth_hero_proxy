<?php

namespace staifa\php_bandwidth_hero_proxy\test\fixtures\boundaries;

function buffer()
{
    return [
      "start" => fn () => null,
      "get" => fn () => null,
      "clean" => fn () => null,
      "end_clean" => fn () => null
    ];
};

function http()
{
    return [
      "start" => function($_) { return null; },
      "set" => function($_, $__, $___) { return null; },
      "exec" => function($_) { return null; },
      "info" => function($_, $info) { return null; },
      "err" => function($_) { return null; },
      "err_no" => function($_) { return null; },
      "close" => function($_) { return null; },
      "set_status" => function($v) { echo $v; },
      "set_header" => function($v) { echo $v; },
      "headers_sent" => fn () => null,
      "header_remove" => fn($_) => null,
      "request_opts" => function($_, &$__, $___) { return null; }
    ];
}

function logger()
{
    return ["error_log" => function($data, $_) { echo $data; }];
};
