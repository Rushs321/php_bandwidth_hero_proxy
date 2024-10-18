<?php

namespace staifa\php_bandwidth_hero_proxy\bypass;

// Sets bypass headers and returns the response with unchanged body
// Ends the flow execution
function bypass($conf) {
  ['response' => ["data" => $data, "headers" => $headers]] = $conf;

  array_walk($headers, fn($v, $k) => header($k . ": " . $v));
  header("x-proxy-bypass: 1");
  header("content-length: " . strlen($data));
  header_remove("Transfer-Encoding");

  ob_clean();
  echo $data;
}
