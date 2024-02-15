<?php 
$current_dir = dirname(dirname(__FILE__));
include $current_dir."/app/config/app.php";

// $users = UserStore::all();
// dd($users);

use ITL\Service\Rbmq\ShopifyService;
shopifyUpdateTags('');
function shopifyUpdateTags($rbmqMessage)
{
    $storeID = 11285;
    $orderId = 5716896842008;
    $tagsToUpdate = "My Master-1";
    try
    {
        $updateShopifyTags = new ShopifyService();
        $userStoreData = $updateShopifyTags->updateOrderTags($storeID,$orderId,$tagsToUpdate);
        echo "<pre>";print_r($userStoreData);die;
    }
    catch (Exception $e)
    {
        echo "Error: " . $e->getMessage();
    }
}

// $rabbitmqClient->register_queue('platform_tracking_status_update', 'rbmqShopifyUpdateTags', 3);

// $rabbitmqClient->consume();