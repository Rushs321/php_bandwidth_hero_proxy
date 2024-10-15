<?php

namespace staifa\php_bandwidth_hero_proxy\redirect;

function redirect($context) {
  ["target_url" => $target_url] = $context;
  if (headers_sent()) return false;

  header("content-length: 0");
  array_walk(["cache-control", "expires","date", "etag"], fn($v, $k) => header_remove($v));
  header("location: " . urlencode($target_url));
  http_response_code(302);

  ob_clean();
  echo null;
};
