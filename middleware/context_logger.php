<?php

namespace staifa\php_bandwidth_hero_proxy\middleware\context_logger;

// Log app state and rethrow the exception
function wrap_context_logger($client_fn) {
  function($ctx) use ($client_fn) {
    try {
      $client_fn($ctx);
    } catch (\Exception $e) {
      // don't log the response body
      unset($ctx["config"]["response"]["data"]);
      error_log(print_r($ctx, true), 4);
      throw new \Exception($e);
    }
  };
};
