<?php

namespace staifa\php_bandwidth_hero_proxy\proxy;

use function \staifa\php_bandwidth_hero_proxy\util\doto;
use function \staifa\php_bandwidth_hero_proxy\redirect\redirect;

// Serves as basic router
// This function is used in main flow control
function route(): callable {
  return function($context) {
    ["route" => $route] = $context;
    if ($route == "/") return $context;
    if ($route == "/favicon.ico") { http_response_code(204); ob_clean(); echo null; };
    return false;
  };
};

// Sends a GET request to given target URL
// This function is used in main flow control
function send_request(): callable {
  return function($context) {
    ["request" => $request,
     "target_url" => $target_url] = $context;
    $error_msg = null;
    $response_headers = [];
    $request_headers = [
      "x-forwarded-for" => $request["HTTP_X_FORWARDED_FOR"] || $request["REMOTE_ADDR"] || $request["SERVER_ADDR"],
      "cookie" => $request["HTTP_COOKIE"],
      "dnt" => $request["HTTP_DNT"],
      "referer" => $request["HTTP_REFERER"],
      "user-agent" => "Bandwidth-Hero Compressor",
      "via" => "1.1 bandwidth-hero",
      "content-encoding" => "gzip"
    ];

    $curl_opts = [
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

    $ch = curl_init();
    doto("curl_setopt", $ch, $curl_opts);
    $data = curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    $res = [
      "response" => [
        "data" => $data,
        "status" => $status,
        "headers" => array_merge($response_headers, ["content-encoding" => "identity"])
      ],
      "request_headers" => array_merge(
         $request_headers,
         ["origin-type" => $response_headers["content-type"] ?? '',
          "origin-size" => strlen($data)]
      )
    ];

    if (curl_errno($ch)) $error_msg = curl_error($ch);
    curl_close($ch);
    if ($error_msg || $status >= 400) { redirect($context); return false; };

    return $context += $res;
  };
};
