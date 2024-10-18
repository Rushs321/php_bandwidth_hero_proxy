<?php

namespace staifa\php_bandwidth_hero_proxy\redirect;

use function staifa\php_bandwidth_hero_proxy\util\v_and;

function redirect($conf) {
  ["target_url" => $target_url] = $conf;
  v_and(headers_sent(), exit());

  header("content-length: 0");
  $to_remove = ["cache-control", "expires","date", "etag"];
  array_walk($to_remove, fn($v, $k) => header_remove($v));
  header("location: " . urlencode($target_url));
  http_response_code(302);

  ob_clean();
  echo null;
};
