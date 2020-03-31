<?php

namespace fgalvao\Shiffer;

use GuzzleHttp\Client;
use InvalidArgumentException;

class Shiffer
{
    
    public static $subscriptionKey;
    
    public static $devMode = false;
    
    /** @var ClientApi */
    private static $client;
    
    
    private static $baseUri = [
        'live' => 'https://api.shiffle.com',
        'dev'  => 'https://dev.api.shiffle.com',
    ];
    
    
    private static function client()
    {
        if (!static::$subscriptionKey) {
            throw new InvalidArgumentException('API Subscription Key is missing.');
        }
        
        if (!static::$client) {
            $client = new Client([
                'verify'      => static::$devMode,
                'http_errors' => false,
                'timeout'     => 3,
                // Base URI is used with relative requests
                'base_uri'    => static::$baseUri[static::$devMode ? 'dev' : 'live'],
                'headers'     => [
                    'Shiffle-Subscription-Key' => static::$subscriptionKey,
                    'Content-Type'             => 'application/json',
                    'Accept'                   => 'application/json',
                ],
            ]);
            
            static::$client = new ClientApi($client);
        }
        
        return static::$client;
    }
    
    /**
     * Add a new Delivery
     * @param string $signedRequestUrl
     *
     * @return Response
     */
    public function delivery(string $signedRequestUrl)
    {
        return static::client()->delivery($signedRequestUrl);
    }
    
    
    /**
     * Add earnings
     *
     * @param string $provisionId
     * @param array  $params
     *
     * @return Response
     */
    public function earning(string $provisionId, array $params)
    {
        return static::client()->earning($provisionId, $params);
    }
    
    
}