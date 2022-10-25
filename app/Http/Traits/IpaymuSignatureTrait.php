<?php

namespace App\Http\Traits;

trait IpaymuSignatureTrait {

    private static $ipaymu_api_key = "SANDBOX9B876F64-EFF4-40AD-AD48-2C99F1E8EDD6-20220209130448";
    private static $ipaymu_va = "0000001352671896";

    public static function getApiKey() {
        return self::$ipaymu_api_key;
    }

    public static function getVa() {
        return self::$ipaymu_va;
    }

    public static function makeSignature($method, $body) {
        $va = self::$ipaymu_va;
        $apiKey = self::$ipaymu_api_key;
        $string = $method . ":" . $va . ":" . strtolower(hash("sha256", json_encode($body, JSON_UNESCAPED_SLASHES))) . ":" . $apiKey;
        // echo $string;
        $sig = hash_hmac('sha256', $string, $apiKey);
        return $sig;
    }

}