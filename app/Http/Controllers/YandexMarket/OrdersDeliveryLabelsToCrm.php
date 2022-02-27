<?php

namespace App\Http\Controllers\YandexMarket;

use App\Http\Controllers\Controller;
use App\Http\Services\RetailCRM\Files\FilesService;
use App\Http\Services\YandexMarket\OrderProcessing\StoreToMarket\OrdersDeliveryLabelsService;

class OrdersDeliveryLabelsToCrm extends Controller
{
    public function __invoke()
    {
        $orders = ["95081185", "93637192", "92375420", "92173828"];

        $labelsService = new OrdersDeliveryLabelsService();
        $crmFileUpload = new FilesService();

        foreach ($orders as $order) {

            $pdfPath = public_path() . "/$order.pdf";

            $response = $labelsService->getOrderDeliveryLabels('22474010', $order, $pdfPath);

            if ($response === 200) {
                $response = $crmFileUpload->uploadFile($pdfPath);

                if ($response->success){
                    dump($crmFileUpload->attachFileToOrder($order));
                }
                unlink($pdfPath);
            }

            dump($response);
        }
    }
}
