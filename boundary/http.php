<?php

namespace staifa\php_bandwidth_hero_proxy\boundary\http;

function init() {
  return [
    "start" => fn() => curl_init(),
    "set" => fn($ch, $opt, $val) => curl_setopt($ch, $opt, $val),
    "exec" => fn($ch) => curl_exec($ch),
    "info" => fn($ch, $info) => curl_getinfo($ch, $info),
    "err" => fn($ch) => curl_error($ch),
    "err_no" => fn($ch) => curl_errno($ch),
    "close" => fn($ch) => curl_close($ch),
    "set_status" => fn($status) => http_response_code($status),
    "set_header" => fn($header) => header($header),
    "headers_sent" => fn() => headers_sent(),
    "header_remove" => fn($header) => header_remove($header),
    "request_opts" => function($request_headers, &$response_headers, $target_url) {
      return [
        CURLOPT_HTTPHEADER => $request_headers,
        CURLOPT_URL => $target_url,
        CURLOPT_CONNECTTIMEOUT => 10,
        CURLOPT_MAXREDIRS => 5,
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_BINARYTRANSFER => 1,
        CURLOPT_FAILONERROR => 1,
        CURLOPT_HEADERFUNCTION => function($curl, $header) use (&$response_headers) {
          $len = strlen($header);
          $header = explode(":", $header, 2);
          if (count($header) < 2) // ignore invalid headers
            return $len;
          $response_headers[strtolower(trim($header[0]))] = trim($header[1]);
          return $len;
        }
      ];
    }
  ];
};
