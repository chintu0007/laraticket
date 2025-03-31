<?php

if (!function_exists('_pr')) {
    /**
     * Pretty print data with `<pre>` formatting
     * 
     * @param mixed $data
     * @param bool $exit (optional) Default: false
     */
    function _pr($data=[], $exit = 1)
    {
        echo '<pre>';
        print_r($data);
        echo '</pre>';

        if ($exit==1) {
            exit; // Stop execution if true
        }
    }
}
