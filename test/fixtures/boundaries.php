<?php

namespace staifa\php_bandwidth_hero_proxy\test\fixtures\boundaries;

function buffer() {
  return [
    "start" => fn() => null,
    "get" => fn() => null,
    "clean" => fn() => null,
    "end_clean" => fn() => null
  ];
};

function http() {
  return [
    "start" => fn() => null,
    "set" => fn($ch, $opt, $val) => null,
    "exec" => fn($ch) => null,
    "info" => fn($ch, $info) => null,
    "err" => fn($ch) => null,
    "err_no" => fn($ch) => null,
    "close" => fn($ch) => null,
    "set_status" => fn($status) => null,
    "set_header" => fn($header) => null,
    "headers_sent" => fn() => null,
    "header_remove" => fn($header) => null,
    "request_opts" => fn($request_headers, &$response_headers, $target_url) => null
  ];
}

function image() {
  return [
    "info" => fn($data) => null,
    "create" => fn($data) => null,
    "filter" => fn($img, $filter) => null,
    "webp" => fn($img, $_file, $quality) => null,
    "jpeg" => fn($img, $_file, $quality) => null,
    "destroy" => fn($img) => null
  ];
};

function logger() {
  return ["error_log" => fn($data, $mode) => null];
};
