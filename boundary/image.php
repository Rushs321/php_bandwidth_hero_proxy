<?php

namespace staifa\php_bandwidth_hero_proxy\boundary\image;

function init()
{
    return [
      "i_info" => fn ($data) => getimagesizefromstring($data),
      "i_create" => fn ($data) => imagecreatefromstring($data),
      "i_filter" => fn ($img, $filter) => imagefilter($img, $filter),
      "i_webp" => fn ($img, $_file, $quality) => imagewebp($img, $_file, $quality),
      "i_jpeg" => fn ($img, $_file, $quality) => imagejpeg($img, $_file, $quality),
      "i_destroy" => fn ($img) => imagedestroy($img)
    ];
};
