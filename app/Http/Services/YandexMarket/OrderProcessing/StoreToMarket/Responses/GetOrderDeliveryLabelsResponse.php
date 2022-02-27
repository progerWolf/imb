<?php

namespace App\Http\Services\YandexMarket\OrderProcessing\StoreToMarket\Responses;

class GetOrderDeliveryLabslsResponse
{
    protected $order;

    protected $mappingClasses = [
        'order' => OrderInfo::class,
    ];

    /**
     * @return OrderInfo
     */
    public function getOrder()
    {
        return $this->order;
    }
}
