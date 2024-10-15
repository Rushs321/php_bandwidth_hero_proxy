<?php

namespace staifa\php_bandwidth_hero_proxy\services\logger;

function wrap_context_logger(): callable {
  return function($context) {
    try {
      return fn() => $context;
    } catch(\Exception $e) {
      error_log($context->to_string(), 4);
      throw new \Exception($e);
    };
  };
};
