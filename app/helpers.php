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


if (!function_exists('metaOnly')) {
    function metaOnly($meta)
    {
        return response()->json([
            'data' => [],
            'meta' => $meta,
        ]);
    }
}

if (!function_exists('firebase_token')) {
    function firebase_token($uid, array $claims = [])
    {
        $now_seconds = time();
        $service_account_email = config('firebase.service_account_email');
        $private_key = file_get_contents(app()->basePath(config('firebase.private_key')));

        if (!$private_key) {
            abort(500, 'Can`t read firebase private key');
        }

        $payload = [
            'iss' => $service_account_email,
            'sub' => $service_account_email,
            'aud' => 'https://identitytoolkit.googleapis.com/google.identity.identitytoolkit.v1.IdentityToolkit',
            'iat' => $now_seconds,
            'exp' => $now_seconds + (60 * 60),  // Maximum expiration time is one hour
            'uid' => $uid
        ];

        if ($claims) {
            $payload['claims'] = $claims;
        }

        return \Firebase\JWT\JWT::encode($payload, $private_key, 'RS256');
    }
}