<?php

namespace staifa\php_bandwidth_hero_proxy\compression;

// Image compression
function process_image(): callable {
  return function($conf) {
    ["quality" => $quality,
     "webp" => $webp,
     "greyscale" => $greyscale,
     "request_headers" => ["origin-size" => $origin_size],
     "response" => ['data' => $data, "headers" => $headers]] = $conf;
    $format = $webp ? "webp" : "jpeg";
    $info = getimagesizefromstring($data);
    $image = imagecreatefromstring($data);
    if ($greyscale) imagefilter($image, IMG_FILTER_GRAYSCALE);

    ob_clean();

    ob_start();
    ($format == "webp") ? imagewebp($image, null, $quality) : imagejpeg($image, null, $quality);
    $converted_image = ob_get_contents();
    ob_end_clean();
    imagedestroy($image);

    array_walk($headers, fn($v, $k) => header($k . ": " . $v));

    $size = strlen($converted_image);
    header("content-length: " . $size);
    header("content-type: image/" . $format);
    header("x-original-size: " . $origin_size);
    header("x-bytes-saved: " . $origin_size - $size);

    ob_clean();
    echo $converted_image;
  };
};
