<?php

namespace staifa\php_bandwidth_hero_proxy\services\curl;

function init(): callable {
  return fn($target_url) => curl_init($target_url);
};

function stop(): callable {
  return fn($context) => curl_close($context["curl_service"]);
};
