<?php

namespace staifa\php_bandwidth_hero_proxy\middleware\context_logger;

// Log app state and rethrow the exception
function wrap_context_logger($client_fn)
{
    return function ($ctx) use ($client_fn) {
        try {
            return $client_fn($ctx);
        } catch (\Exception $e) {
            // don't log the response body
            unset($ctx["config"]["response"]["data"]);
            error_log($e . "\nApp context: " . print_r($ctx["config"], true));
            throw new \Exception($e);
        }
    };
};
