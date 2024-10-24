<?php

namespace staifa\php_bandwidth_hero_proxy\test\fixtures\boundaries;

function http()
{
    return [
      "c_init" => function () { return null; },
      "c_set" => function ($_, $__, $___) { return null; },
      "c_exec" => function ($_) { return file_get_contents('./fixtures/images/img.webp'); },
      "c_info" => function ($_, $info) { return 200 ; },
      "c_err" => function ($_) { return null; },
      "c_err_no" => function ($_) { return null; },
      "c_close" => function ($_) { return null; },
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
