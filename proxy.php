<?php

namespace staifa\php_bandwidth_hero_proxy\proxy;

use function staifa\php_bandwidth_hero_proxy\util\doto;
use function staifa\php_bandwidth_hero_proxy\redirect\redirect;

// Sends a GET request to given target URL
// This function is used in main flow control
function send_request()
{
    return function ($ctx) {
        ["config" => ["request" => $request, "target_url" => $target_url],
            "http" => $http] = $ctx;
        $error_msg = null;
        $response_headers = [];
        $request_headers = [
          "x-forwarded-for" => $request["HTTP_X_FORWARDED_FOR"] || $request["REMOTE_ADDR"] || $request["SERVER_ADDR"],
          "cookie" => $request["HTTP_COOKIE"],
          "dnt" => $request["HTTP_DNT"],
          "referer" => $request["HTTP_REFERER"],
          "user-agent" => "Bandwidth-Hero Compressor",
          "via" => "1.1 bandwidth-hero",
          "content-encoding" => "gzip"
        ];

        $ch = $http["start"]();
        $ctx["instances"] += ["http" => $ch];
        doto(
            fn ($c, $o, $v) => $http["set"]($c, $o, $v),
            $ch,
            $http["request_opts"]($request_headers, $response_headers, $target_url)
        );
        $data = $http["exec"]($ch);
        $status = $http["info"]($ch, CURLINFO_HTTP_CODE);

        $ctx["config"] += [
          "response" => [
            "data" => $data,
            "status" => $status,
            "headers" => array_merge($response_headers, ["content-encoding" => "identity"])
          ],
          "request_headers" => array_merge(
              $request_headers,
              ["origin-type" => $response_headers["content-type"] ?? '',
         "origin-size" => strlen($data)]
          )
        ];

        if ($http["err_no"]($ch)) {
            $error_msg = $http["err"]($ch);
        }
        $http["close"]($ch);
        if ($error_msg || $status >= 400) {
            redirect($ctx);
        }

        return $ctx;
    };
};
