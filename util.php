<?php

namespace staifa\php_bandwidth_hero_proxy\util;

/**
 * Basically simplified either monad
 * Takes chain of closures which use app context as a parameter and return value
 * of a closure it returns
 * The execution is short-circuited when a function returns false
 *
 * Usage:
 *     flow(config\create(), context\create(), proxy\route());
 */
function flow(...$fns) {
  $ctx = null;
  foreach ($fns as $fn) {
    if ($res = call_user_func($fn, $ctx)) {
      $ctx = $res;
    } else {
      return null;
    }
  };
}

/**
 * Inspired by thread first and last macros from lisps
 * Takes an initial value and chain of closures
 * Each function in the chain is called with result of previous function's
 * execution
 *
 * Usage:
 *    $res = thread(add_computed_values(), add_services())($config);
 */
function thread(callable ...$fns) {
  return fn(...$args) => array_reduce($fns, fn($acc, $fn) => call_user_func($fn, $acc), ...$args);
}

/**
 * An or that takes multiple arguments and returns first truthful value or false
 * Doesn't evaluate after first truthful value is found
 *
 * Usage:
 *    $res = v_or(true, 1 == 0, false);
 */
function v_or(...$args) {
  foreach($args as $arg) {
    if (is_callable($item)) $item = $item();
    if ($item) return $item;
  };
};

/**
 * An and that takes multiple arguments and returns last truthful value or false
 *
 * Usage:
 *    $res = v_and(true, 1 == 0, false);
 */
function v_and(...$args) {
  return array_reduce($args, fn($c, $i) => ($c && $i) ? $i : false);
}

/**
 * For each array key-value pair, calls function with this pair as request_params
 * on the provided object instance
 * Pass the function name as string, no sensible way around it
 * This mutates the object instance, so no values are returned
 *
 * Usage:
 *    doto('curl_setopt', $http, ['foo' => 1, 'bar' => 2]);
 */
function doto($fn, $instance, $props) {
  array_walk($props, fn($v, $k) => call_user_func_array($fn, [$instance, $k, $v]));
}
