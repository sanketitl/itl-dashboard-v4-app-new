<?php 
namespace ITL\RestApi;

use Exception;
use ITL\Adapters\Store\StoreInterface;
use ITL\DTO\SendShopifyDTO;
use ITL\Constants\StoreConstant;
use GuzzleHttp\Client;

class ShopifyApi
{
    private $storeUrl;
    private $shopifyAccessToken;
    private $orderId;

    /**
     * Make Api Request
     * @param $method
     * @param $url
     * @param $method
     */

    private function makeRequest(string $method,string $url,array $optionArray = []) : array
    {
        $client = new Client();
        try
        {
            $response = $client->request($method,$url,$optionArray);
            $responseArray = json_decode($response->getBody()->getContents(),true);
            return $responseArray;
        }
        catch(Exception $e)
        {
            return [$e->getMessage()];
        }
    }

    /**
     * @param SendShopifyDTO $serviceRequest
     * @return $responseArray
     */

    public function getOrderData(SendShopifyDTO $serviceRequest) : array
    {
        $this->storeUrl = $serviceRequest->getStoreUrl();
        $this->orderId = $serviceRequest->getOrderId();
        // $this->shopifyAccessToken = $serviceRequest->getAccessToken();
        $this->shopifyAccessToken = "12345";
        $url = "https://".$this->storeUrl."/admin/api".StoreConstant::SHOPIFYCURRENTAPIVERSION."orders/$this->orderId.json";
        $method = "GET";
        $optionArray = array("headers"=>array("X-Shopify-Access-Token"=>$this->shopifyAccessToken));
        $responseArray = $this->makeRequest($method,$url,$optionArray);
        return $responseArray;
    }

    /**
     * @param SendShopifyDTO $serviceRequest
     */

    public function updateTags(SendShopifyDTO $serviceRequest) : array
    {
        $this->storeUrl = $serviceRequest->getStoreUrl();
        $this->orderId = $serviceRequest->getOrderId();
        $this->shopifyAccessToken = $serviceRequest->getAccessToken();
        $orderTags = $serviceRequest->getOrderTags();
        $requestBodyArray = array('order'=>array('id'=>$this->orderId,'tags'=>$orderTags));
        $url = "https://".$this->storeUrl."/admin/api".StoreConstant::SHOPIFYCURRENTAPIVERSION."orders/$this->orderId.json";
        $method = "PUT";
        $optionArray = array("body"=>json_encode($requestBodyArray),"headers"=>array("X-Shopify-Access-Token" => $this->shopifyAccessToken,"Content-Type" => "application/json"));
        $responseArray = $this->makeRequest($method,$url,$optionArray);
        return $responseArray;
    }
}