<?php

if (!function_exists('_pr')) {
    /**
     * Pretty print data with `<pre>` formatting
     * 
     * @param mixed $data
     * @param bool $exit (optional) Default: false
     */
    function _pr($data=[], $exit = true)
    {
        echo '<pre style="background: #282c34; color: #61dafb; padding: 10px; border-radius: 5px;">';
        print_r($data);
        echo '</pre>';

        if ($exit) {
            exit; // Stop execution if true
        }
    }
}
