<?php

namespace staifa\php_bandwidth_hero_proxy\util;

/**
 * Basically simplified maybe monad
 * Takes chain of closures which use app context as a parameter and return value
 * of a closure it returns
 * The execution is short-circuited when a function returns false
 *
 * Usage:
 *     flow(config\create(), context\create(), proxy\route());
 */
function flow($config, ...$fns)
{
    foreach ($fns as $fn) {
        if ($res = call_user_func($fn, $config)) {
            $config = $res;
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
 *    $res = thread(add_computed_values(), add_services(), compute_result())($config);
 */
function thread(callable ...$fns)
{
    return fn (...$args) => array_reduce($fns, fn ($acc, $fn) => call_user_func($fn, $acc), ...$args);
}

/**
 * An `or` that takes multiple arguments and returns first truthful value or false
 * If the argument is a function, it's evaluated
 * Doesn't evaluate after first truthful value is returned (short-circuit)
 *
 * Usage:
 *    $res = v_or(true, 1 == 0, fn() => "foo");
 */
function v_or(...$args)
{
    foreach ($args as $arg) {
        if (is_callable($item)) {
            $item = $item();
        }
        if ($item) {
            return $item;
        }
    };
};

/**
 * An `and` that takes multiple arguments and returns last truthful value or false
 * If the argument is a function, it's evaluated
 *
 * Usage:
 *    $res = v_and(true, 1 == 0, fn() => "foo");
 */
function v_and(...$args)
{
    foreach ($args as $key => $arg) {
        if (is_callable($arg)) {
            $arg = $arg();
        }
        $i = $key + 1;
        if (is_callable($arg[$i])) {
            $arg2 = $arg[$i]();
        }
        ($i == count($args) && arg2) ? $arg2 : false;
        ($arg && $arg2) ? $arg2 : false;
    };
};

/**
 * For each array's key-value pair, calls function with this pair as params
 * on the provided object instance
 * Pass the function name as string, no sensible way around it
 * This mutates the object instance, so no values are returned
 *
 * Usage:
 *    doto('curl_setopt', $http, ['foo' => 1, 'bar' => 2]);
 */
function doto($fn, $instance, $props)
{
    array_walk($props, fn ($v, $k) => call_user_func_array($fn, [$instance, $k, $v]));
}
