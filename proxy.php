<?php

namespace staifa\php_bandwidth_hero_proxy\proxy;

function route(): callable {
  return function($context) {
    ['request_uri' => $request_uri] = $context;
    if ($request_uri == "/") return fn() => $context;
    if ($request_uri == "/favicon.ico") http_response_code(204);
    return fn() => false;
  };
};

function send_request(): callable {
  return function($context) {
    ['target_url' => $target_url,
     'services' => ['curl' => $curl]] = $context;
        /*$response = curl_exec($curl);*/

    return fn() => $context;
  };
};
