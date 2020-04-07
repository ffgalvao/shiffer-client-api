<?php


namespace fGalvao\Shiffle;


use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class ClientApi
{
    /**
     * @var Client
     */
    private $client;
    private $lastResponse;
    
    
    /**
     * InternalAnalytics constructor.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }
    
    /**
     * @param ResponseInterface $response
     *
     * @return Response
     */
    protected function toResourceResponse(ResponseInterface $response)
    {
        return new Response($response);
    }
    
    /**
     * @param        $uri
     * @param array  $params
     * @param string $method
     *
     * @return ResponseInterface
     */
    protected function call($uri, $params = [], $method = 'GET')
    {
        $response           = $this->client->request($method, $uri, $params);
        $this->lastResponse = $response;
        
        return $response;
    }
    
    
    /**
     * @param       $uri
     * @param array $params
     *
     * @return ResponseInterface
     */
    protected function post($uri, $params = [])
    {
        return $this->call($uri, $params, 'POST');
    }
    
    /**
     * @param string $signedRequestUrl
     *
     * @return Response
     */
    public function delivery(string $signedRequestUrl)
    {
        $uri = 'earnings';
        
        $_response = $this->post($uri, ['json' => ['signedRequestUrl' => $signedRequestUrl]]);
        $response  = $this->toResourceResponse($_response);
        
        return $response;
    }
    
    
    /**
     *{
     *  "providerRef": "1bc3d9df-1619-40c1-b1a6-069b932fdd46",
     *  "status": "confirmed",
     *  "jobDateTime" : "2020-04-02T10:42:17Z",
     *  "description" : "Mc Donalds",
     *  "longDescription": "A more detailed and optional provider defined description.",
     *  "fee": "4.00",
     *  "tip": "1.00",
     *  "total": "5.00"
     *}
     * @param string $provisionId
     * @param array  $params
     *
     * @return Response
     */
    public function earning(string $provisionId, array $params)
    {
        $uri = sprintf('earnings/%s', $provisionId);
        
        $_response = $this->post($uri, ['json' => $params]);
        $response  = $this->toResourceResponse($_response);
        
        return $response;
    }
    
}