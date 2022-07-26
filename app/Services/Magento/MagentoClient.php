<?php

namespace App\Services\Magento;

use GuzzleHttp\Client;

class MagentoClient
{
    /**
     * @var Client $client
     */
    private Client $client;
    private const CREATE_URL = '/pub/rest/default/V1/products';
    /**
     * MagentoClient constructor.
     * @param Client $client
     */
    public function __construct(
        Client $client
    ) {
        $this->client = $client;
    }

    public function createProduct(Product $product)
    {
        $response = $this->client->request(
            'POST',
            self::CREATE_URL,
            [
                'body' => $product->toArray(),
                'http_errors' => false,
                'verify' => false,
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
            ]
        );
        return new MagentoApiResponse($response);
    }
}
