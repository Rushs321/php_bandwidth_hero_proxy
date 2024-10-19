<?php

namespace staifa\php_bandwidth_hero_proxy\compression;

// Image compression
function process_image()
{
    return function ($ctx) {
        ["config" => [
           "quality" => $quality,
           "webp" => $webp,
           "greyscale" => $greyscale,
           "request_headers" => ["origin-size" => $origin_size],
           "response" => ['data' => $data, "headers" => $headers]],
            "buffer" => $buffer,
            "http" => $http,
            "image" => $image] = $ctx;

        $format = $webp ? "webp" : "jpeg";
        $info = $image["info"]($data);
        $inst = $image["create"]($data);
        $ctx["instances"] += ["image" => $inst];
        if ($greyscale) {
            $image["filter"]($inst, IMG_FILTER_GRAYSCALE);
        }

        $buffer["clean"]();
        $buffer["start"]();
        ($format == "webp") ? $image["webp"]($inst, null, $quality) : $image["jpeg"]($inst, null, $quality);
        $converted_image = $buffer["get"]();
        $buffer["end_clean"]();
        $image["destroy"]($inst);

        array_walk($headers, fn ($v, $k) => $http["set_header"]($k . ": " . $v));

        $size = strlen($converted_image);
        $http["set_header"]("content-length: " . $size);
        $http["set_header"]("content-type: image/" . $format);
        $http["set_header"]("x-original-size: " . $origin_size);
        $http["set_header"]("x-bytes-saved: " . $origin_size - $size);

        $buffer["clean"]();
        echo $converted_image;
    };
};
