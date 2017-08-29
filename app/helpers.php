<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 2017-07-31
 * Time: 11:46
 */

if (!function_exists('config_path')) {
    /**
     * Get the configuration path.
     *
     * @param  string $path
     * @return string
     */
    function config_path($path = '')
    {
        return app()->basePath() . '/config' . ($path ? '/' . $path : $path);
    }
}

if (!function_exists('public_path')) {
    /**
     * Get the path to the public folder.
     *
     * @param  string $path
     * @return string
     */
    function public_path($path = null)
    {
        return rtrim(app()->basePath('public/' . $path), '/');
    }
}

if (!function_exists('random_hash')) {
    function random_hash()
    {
        return sha1(time() . random_bytes(72));
    }
}

if (!function_exists('file_url')) {
    function file_url($path)
    {
        return \Illuminate\Support\Facades\Storage::url($path);
    }
}