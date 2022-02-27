<?php

namespace App\Http\Services\YandexMarket\OrderProcessing\Clients;

use  Yandex\Market\Partner\Clients\OrderProcessingClient;
use  App\Http\Services\YandexMarket\OrderProcessing\StoreToMarket\Responses\GetOrderDeliveryLabslsResponse;
use Illuminate\Support\Facades\Storage;
/**
 * Class OrderProcessingClient
 */
class OrderProcessingClientService extends OrderProcessingClient
{
    public function getOrderDaliveryLabels($campaignId, $orderId, $pdfPath, array $params = [], $dbgKey = null)
    {
        $fileResource = fopen($pdfPath, 'w');
        $resource = "campaigns/$campaignId/orders/$orderId/delivery/labels.json";
        $resource = $this->addDebugKey($resource, $dbgKey);
        $response = $this->sendRequest(
            'GET',
            $this->getServiceUrl($resource),
            ['sink' => $fileResource, 'headers' => ['Content-Type' => 'application/pdf',]]
        );
        fclose($fileResource);
        return $response->getStatusCode();
    }
}
