<?php

namespace staifa\php_bandwidth_hero_proxy\middleware\cleanup;

// check and clean app state
function clean_instances($client_fn) {
  function($ctx) use ($client_fn) {
    try {
      $client_fn($ctx);
    } finally {
      if ($i = $ctx["instances"]["http"]) $ctx["http"]["close"]($i);
      if ($i = $ctx["instances"]["image"]) $ctx["image"]["destroy"]($i);
    }
  };
};
