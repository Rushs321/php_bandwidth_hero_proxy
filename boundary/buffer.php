<?php

namespace staifa\php_bandwidth_hero_proxy\boundary\buffer;

function init()
{
    return [
      "start" => fn () => ob_start(),
      "get" => fn () => ob_get_contents(),
      "clean" => fn () => ob_clean(),
      "end_clean" => fn () => ob_end_clean()
    ];
};
