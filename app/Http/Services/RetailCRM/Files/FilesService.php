<?php

namespace App\Http\Services\RetailCRM\Files;

use GuzzleHttp\Psr7\Stream;
use RetailCrm\Api\Client;
use RetailCrm\Api\Factory\SimpleClientFactory;
use RetailCrm\Api\Model\Entity\Files\Attachment;
use RetailCrm\Api\Model\Entity\Files\AttachmentOrder;
use RetailCrm\Api\Model\Entity\Files\File;
use RetailCrm\Api\Model\Request\Files\FilesEditRequest;
use RetailCrm\Api\Model\Request\Files\FilesUploadRequest;
use RetailCrm\Api\Model\Response\Files\FilesUploadResponse;

class FilesService
{
    private Client $client;
    private string $apiUri = '';
    private string $apiKey = '';
    private File $file;

    public function __construct()
    {
        $this->client = SimpleClientFactory::createClient($this->apiUri, $this->apiKey);
    }

    public function uploadFile($filePath): FilesUploadResponse
    {
        $file = new Stream(fopen($filePath, 'rb'));
        $request = new FilesUploadRequest($file);
        $response = $this->client->files->upload($request);

        if ($response->success) {
            $this->file = $response->file;
        }

        return $response;
    }

    public function attachFileToOrder(string|null $externalId = null, int|null $id = null, int|string|null $fileId = null): FilesUploadResponse
    {
        $fileId = $fileId ?? $this->file->id;
        $file = $this->file ?? new File();
        $request = new FilesEditRequest();
        $setOrderAttach = new AttachmentOrder();
        $setAttachment = new Attachment();

        if (!is_null($externalId)) {
            $setOrderAttach->externalId = $externalId;
        }
        if (!is_null($id)) {
            $setOrderAttach->id = $id;
        }

        $setAttachment->order = $setOrderAttach;
        $file->attachment = $setAttachment;
        $request->file = $file;
        dump($request);

        return $this->client->files->edit($fileId, $request);
    }
}

