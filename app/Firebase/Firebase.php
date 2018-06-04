<?php
/**
 * Created by PhpStorm.
 * User: mark
 * Date: 12/16/17
 * Time: 17:18
 */

namespace App\Firebase;


class Firebase
{
    use FirebaseFunctions;
    protected $key;
    protected $host;

    public function __construct(array $config = [])
    {
        $config = array_merge(config('firebase'), $config);
        $this->key = $config['security_code'];
        $this->host = $config['server_url'];
    }

    protected function request($func_name, $params, $parse_json = false)
    {
        $cl = new \GuzzleHttp\Client();
        $resp = $cl->post($this->makeURL($func_name), [
            'json' => $params,
            'headers' => [
                'Authorization' => $this->key
            ]
        ]);

        if ($resp->getStatusCode() !== 200) {
            Log::critical('Firebase request failed', [
                'code' => $resp->getStatusCode(),
                'message' => $resp->getBody()->getContents(),
                'function' => $func_name,
                'params' => $params
            ]);

            throw new FirebaseException('Firebase request failed with code: ' . $resp->getStatusCode() . ' and message: ' . $resp->getBody()->getContents());
        }

        if ($parse_json) {
            return json_decode($resp->getBody()->getContents(), true);
        }

        return $resp;
    }

    protected function makeURL($func_name): string
    {
        if (strpos($func_name, '/') === 0) {
            $func_name = substr($func_name, 1);
        }

        return $this->host . $func_name;
    }
}