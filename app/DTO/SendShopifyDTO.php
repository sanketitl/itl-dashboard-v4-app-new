<?php

namespace ITL\DTO;

class SendShopifyDTO
{
    private ?string $storeUrl = null;
    private ?int $orderId = null;
    private ?string $tags = null;
    private ?string $accessToken = null;

    public function __construct(string $storeUrl,string $accessToken)
    {
        $this->storeUrl = $storeUrl;
        $this->accessToken = $accessToken;
    }

    /**
     * Get the value of storeUrl
     */

    public function getStoreUrl():string
    {
        return $this->storeUrl;
    }

    /**
     * Get the value of accessToken
     */

    public function getAccessToken():string
    {
        return $this->accessToken;
    }

    /**
     * Set the value of orderId
     * @return self
     */

    public function setOrderId(int $orderId):int
    {
        return $this->orderId = $orderId;
    }

    /**
     * Get the value of orderId
     */

    public function getOrderId():int
    {
        return $this->orderId;
    }

    /**
     * Set the value of tags
     * @return self
     */

    public function setOrderTags(string $tags) : self
    {
        $this->tags = $tags;
        return $this;
    }

    /**
     * Get the value of tags
     */

    public function getOrderTags() : string
    {
        return $this->tags;
    }
}