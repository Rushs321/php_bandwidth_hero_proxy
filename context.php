<?php

namespace staifa\php_bandwidth_hero_proxy\context;

// Creates application context from configuration
// This function is used in main flow control
function create(): callable {
  return function($config) {
    ["request_params" => ["url" => $url],
     "request_uri" => $req_uri,
     "min_compress_length" => $min_comp] = $config;

    if (!isset($url)) { ob_clean(); echo "bandwidth-hero-proxy"; };
    if (is_array($url)) $url = join("&url=", $url);

    $computed_values = function() use ($url, $req_uri, $min_comp) {
      $route = fn($uri) => ($pos = strpos($uri, "?")) ? substr($uri, 0, $pos) : $uri;
      $process_url = function() use ($url) {
        $pattern = "/http:\/\/1\.1\.\d\.\d\/bmi\/(https?:\/\/)?/i";
        return preg_replace($pattern, "http://", $url);
      };
      return [
        "min_transparent_compress_length" => $min_comp * 100,
        "route" => $route($req_uri),
        "target_url" => $process_url()
      ];
    };

    return $config += $computed_values();
  };
};
