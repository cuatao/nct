<?php

if (! function_exists('get_domain_from_url')) {
    /**
     * Parse domain from url string
     *
     * @param $url
     * @return mixed
     */
    function get_domain_from_url($url)
    {
        $parse = parse_url($url);

        return $parse['host'] ?? null;
    }
}

if (! function_exists('split_string_by_from_to')) {
    /**
     * Split string from -> to substring
     *
     * @param $string
     * @param $from
     * @param $to
     * @return string
     */
    function split_string_by_from_to($string, $from, $to)
    {
        $arr = explode($from, $string, 2);

        if (count($arr) == 1) {
            return '';
        }

        return explode($to, $arr[1], 2)[0];
    }
}
