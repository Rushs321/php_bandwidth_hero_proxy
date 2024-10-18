<?php

namespace staifa\php_bandwidth_hero_proxy\redirect;

function redirect($ctx) {
  ["config" => ["target_url" => $target_url],
   "buffer" => $buffer,
   "http" => $http] = $ctx;
  if ($http["headers_sent"]()) echo null;

  $http["set_header"]("content-length: 0");
  $to_remove = ["cache-control", "expires","date", "etag"];
  array_walk($to_remove, fn($v, $k) => $http["header_remove"]($v));
  $http["set_header"]("location: " . urlencode($target_url));
  $http["set_status"](302);

  $buffer["clean"]();
  echo null;
};
