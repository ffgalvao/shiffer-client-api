<?php

namespace fGalvao\Shiffle;

use Psr\Http\Message\ResponseInterface;

class Response
{
    /** @var string */
    private $reasonPhrase = '';
    
    /** @var int */
    private $statusCode = 200;
    
    /** @var bool */
    private $status = false;
    
    /** @var mixed */
    private $body = null;
    
    /**
     * Response constructor.
     *
     * @param ResponseInterface $response
     */
    public function __construct(ResponseInterface $response)
    {
        $this->statusCode   = $response->getStatusCode();
        $this->reasonPhrase = $response->getReasonPhrase();
        $this->body         = $this->decodeBody($response);
        $this->status       = $this->statusCode === 200;
    }
    
    
    /**
     * @param ResponseInterface $response
     *
     * @return string|array
     */
    private function decodeBody(ResponseInterface $response)
    {
        return json_decode($response->getBody(), true) ?: (string)$response->getBody();
    }
    
    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }
    
    /**
     * @return string
     */
    public function getReasonPhrase()
    {
        return $this->reasonPhrase;
    }
    
    /**
     * @param bool $status
     *
     * @return Response
     */
    public function setStatus(bool $status): Response
    {
        $this->status = $status;
        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }
    
    /**
     * @param $body
     *
     * @return Response
     */
    public function setBody($body): Response
    {
        $this->body = $body;
        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getBodyData()
    {
        return $this->body['Data'] ?? $this->body;
    }
    
    /**
     * @return bool
     */
    public function isSuccess()
    {
        return $this->status;
    }
    
    /**
     * @return bool
     */
    public function isFailed()
    {
        return !$this->status;
    }
    
    
}