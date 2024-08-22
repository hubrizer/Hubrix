<?php

if (!function_exists('array_pluck')) {
    /**
     * Pluck an array of values from an array
     *
     * @param array $array The array to pluck from.
     * @param string $key The key to pluck.
     * @return array
     */
    function array_pluck($array, $key) {
        return array_map(function ($item) use ($key) {
            return is_object($item) ? $item->$key : $item[$key];
        }, $array);
    }
}

if (!function_exists('array_get')) {
    /**
     * Get an item from an array using "dot" notation
     *
     * @param array $array The array to get the value from.
     * @param string $key The key of the value to get.
     * @param mixed $default The default value to return if the key doesn't exist.
     * @return mixed
     */
    function array_get($array, $key, $default = null) {
        if (is_null($key)) {
            return $array;
        }

        if (isset($array[$key])) {
            return $array[$key];
        }

        foreach (explode('.', $key) as $segment) {
            if (array_key_exists($segment, $array)) {
                $array = $array[$segment];
            } else {
                return $default;
            }
        }

        return $array;
    }
}

if (!function_exists('array_set')) {
    /**
     * Set an array item to a given value using "dot" notation
     *
     * @param array $array The array to set the value on.
     * @param string $key The key to set the value on.
     * @param mixed $value The value to set.
     * @return array
     */
    function array_set(&$array, $key, $value) {
        if (is_null($key)) {
            return $array = $value;
        }

        $keys = explode('.', $key);

        foreach ($keys as $i => $key) {
            if (count($keys) === 1) {
                $array[$key] = $value;
            } else {
                if (!isset($array[$key]) || !is_array($array[$key])) {
                    $array[$key] = [];
                }

                $array = &$array[$key];
            }
        }

        return $array;
    }
}

if (!function_exists('array_has')) {
    /**
     * Check if an item exists in an array using "dot" notation
     *
     * @param array $array The array to check.
     * @param string $key The key to check.
     * @return bool
     */
    function array_has($array, $key) {
        if (is_null($key)) {
            return false;
        }

        if (isset($array[$key])) {
            return true;
        }

        foreach (explode('.', $key) as $segment) {
            if (array_key_exists($segment, $array)) {
                $array = $array[$segment];
            } else {
                return false;
            }
        }

        return true;
    }
}

if (!function_exists('array_first')) {
    /**
     * Return the first element in an array
     *
     * @param array $array The array to get the first element from.
     * @return mixed
     */
    function array_first($array) {
        return reset($array);
    }
}

if (!function_exists('array_last')) {
    /**
     * Return the last element in an array
     *
     * @param array $array The array to get the last element from.
     * @return mixed
     */
    function array_last($array) {
        return end($array);
    }
}

if (!function_exists('array_only')) {
    /**
     * Get only a subset of the items from a given array
     *
     * @param array $array The array to get the subset from.
     * @param array $keys The keys to retrieve.
     * @return array
     */
    function array_only($array, $keys) {
        return array_intersect_key($array, array_flip((array) $keys));
    }
}
