<?php

namespace staifa\php_bandwidth_hero_proxy\boundary\logger;

function init() {
  return ["error_log" => fn($data, $mode) => error_log($data, $mode)];
};
