<?php


namespace fgalvao\Shiffer;


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
     *  "totalEarned": 3.5,
     *  "earnedDateTime": "2019-05-29T09:10:08Z",
     *  "description": "Gourmet Burger",
     *  "fee": 3,
     *  "tip": 0.5
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