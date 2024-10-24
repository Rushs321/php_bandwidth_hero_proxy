<?php

namespace staifa\php_bandwidth_hero_proxy\test\fixtures\boundaries;

function http()
{
    return [
      "start" => function () { return null; },
      "set" => function ($_, $__, $___) { return null; },
      "exec" => function ($_) { return file_get_contents('./fixtures/images/img.webp'); },
      "info" => function ($_, $info) { return 200 ; },
      "err" => function ($_) { return null; },
      "err_no" => function ($_) { return null; },
      "close" => function ($_) { return null; },
      "set_status" => function ($v) { $_SERVER["status"] = $v; },
      "set_header" => function ($v) { array_push($_SERVER["headers"], $v); },
      "headers_sent" => fn () => null,
      "header_remove" => fn ($_) => null,
    "request_opts" => function ($_, &$response_headers, $___) {
        $response_headers["content-type"] = "image";
        return [];
    }
    ];
}

function logger()
{
    return ["error_log" => function ($data, $_) { $_SERVER["error"] = $data; }];
};
