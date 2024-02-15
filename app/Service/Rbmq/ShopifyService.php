<?php 
namespace ITL\Service\Rbmq;

use Exception;
use ITL\Repositories\MySql\UserStoreRepositoryImpl;
use ITL\DTO\SendShopifyDTO;
use ITL\Utils\CleanDbData;
use ITL\RestApi\ShopifyApi;

class ShopifyService
{
    private $userRepositoryImpl;
    public function __construct()
    {
        $this->userRepositoryImpl = new UserStoreRepositoryImpl();
    }

    /**
     * Update Order Tags
     * @param $storeId
     * @param $orderId
     * @param $tagsToUpdate
     */

    public function updateOrderTags(int $storeId,int $orderId,string $tagsToUpdate):array|string
    {
        $userStoreData = $this->userRepositoryImpl->findById($storeId);
        if($userStoreData == null)
        {
            throw new Exception("No Records Found for Store Or User Id  Into Database");
        }
        $jsonUserStoreData = json_decode($userStoreData,true);
        if(count($jsonUserStoreData) <= 0)
        {
            throw new Exception("No Records Found for Store Or User Id  Into Database");
        }

        $storeUrl = CleanDbData::xssClean($jsonUserStoreData['store_url']);
        $accessToken = CleanDbData::xssClean($jsonUserStoreData['access_token']);
        $setServiceRequest = new SendShopifyDTO($storeUrl,$accessToken);
        $setServiceRequest->setOrderId($orderId);
        $shopify = new ShopifyApi();
        $orderData = $shopify->getOrderData($setServiceRequest);
        echo "<pre>";print_r($orderData);die;
        $orderTags = $orderData['order']['tags'].",".$tagsToUpdate;
        $setServiceRequest->setOrderTags($orderTags);
        $resultData =  $shopify->updateTags($setServiceRequest);
        return $resultData;
    }
}