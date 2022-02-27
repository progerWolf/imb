<?php

namespace App\Http\Services\YandexMarket\OrderProcessing\StoreToMarket;

use App\Http\Services\YandexMarket\OrderProcessing\Clients\OrderProcessingClientService;

class OrdersDeliveryLabelsService
{
    private string $clientId = "";
    private string $token = "";
    private OrderProcessingClientService $service;

    public function __construct()
    {
        $this->service = new OrderProcessingClientService($this->clientId, $this->token);
    }

    public function getOrderDeliveryLabels($campaignId, $orders, $pdfPath): int
    {
        return $this->service->getOrderDaliveryLabels($campaignId, $orders, $pdfPath);
    }


}
