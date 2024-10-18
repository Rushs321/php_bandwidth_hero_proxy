<?php

namespace staifa\php_bandwidth_hero_proxy\bypass;

// Sets bypass headers and returns the response with unchanged body
// Ends the flow execution
function bypass($ctx) {
  ["config" => ["response" => ["data" => $data, "headers" => $headers]],
   "http" => $http,
   "buffer" => $buffer] = $ctx;
  array_walk($headers, fn($v, $k) => $http["set_header"]($k . ": " . $v));
  $http["set_header"]("x-proxy-bypass: 1");
  $http["set_header"]("content-length: " . strlen($data));
  $http["header_remove"]("Transfer-Encoding");

  $buffer["clean"]();
  echo $data;
}
