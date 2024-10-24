<?php

namespace staifa\php_bandwidth_hero_proxy\middleware\cleanup;

// check and clean app state
function wrap_graceful_shutdown($client_fn)
{
    return function ($ctx) use ($client_fn) {
        try {
            return $client_fn($ctx);
        } finally {
            if ($i = $ctx["instances"]["http"]) {
                $ctx["http"]["c_close"]($i);
            }
            if ($i = $ctx["instances"]["image"]) {
                $ctx["image"]["i_destroy"]($i);
            }
        }
    };
};
