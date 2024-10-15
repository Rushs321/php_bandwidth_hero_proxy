<?php

namespace staifa\php_bandwidth_hero_proxy\util;

function flow(...$fns) {
  $ctx = null;
  foreach ($fns as $key => $fn) {
    if ($res = call_user_func($fn, $ctx)) {
      $ctx = $res;
    } else {
      return false;
    }
  };
}

function compose(callable ...$fns) {
  return function(...$args) use ($fns) {
    return array_reduce($fns, fn($acc, $fn) => call_user_func($fn, $acc), array_reverse(...$args));
  };
};

function vor(...$args) {
  $compare_and_return = function($carry, $item) {
    if ($item) return $item;
    if ($carry) return $carry;
    return false;
  };

  return array_reduce($args, $compare_and_return);
}

function vand(...$args) {
  return array_reduce($args, fn($c, $i) => ($c && $i) ? $i : false);
}
