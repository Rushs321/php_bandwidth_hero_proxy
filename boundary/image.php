<?php

namespace staifa\php_bandwidth_hero_proxy\boundary\image;

function init()
{
    return [
      "info" => fn ($data) => getimagesizefromstring($data),
      "create" => fn ($data) => imagecreatefromstring($data),
      "filter" => fn ($img, $filter) => imagefilter($img, $filter),
      "webp" => fn ($img, $_file, $quality) => imagewebp($img, $_file, $quality),
      "jpeg" => fn ($img, $_file, $quality) => imagejpeg($img, $_file, $quality),
      "destroy" => fn ($img) => imagedestroy($img)
    ];
};
