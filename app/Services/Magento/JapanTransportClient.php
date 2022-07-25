<?php

namespace App\Services\RainForestAPI;

use App\Services\RainForest\RainForestApiResponse;
use GuzzleHttp\Client;

class RainForestApiClient
{
    /**
     * @var Client $client
     */
    private Client $client;
    /**
     * @var array $config
     */
    private array $config;
    private string $createUrl = '/pub/rest/default/V1/products';
    /**
     * RainForestApiClient constructor.
     * @param Client $client
     * @param array $config
     */
    public function __construct(
        Client $client,
        array $config
    ) {
        $this->client = $client;
        $this->config = $config;
    }

    public function addProduct(string $asin): RainForestApiResponse
    {
        $params = array_merge([
            'type' => 'product',
            'asin' => $asin,
        ], $this->config);
        $uri = self::PREFIX_URL . http_build_query($params);
        $response = $this->client->request(
            'GET',
            $uri,
            [
                'http_errors' => false,
                'verify' => false,
            ]
        );
        return new RainForestApiResponse($response);
    }

    public function getCategory(
        string $categoryId,
        ?int $page,
        ?int $maxPage
    ): RainForestApiResponse {
        $params = array_merge([
            'type' => 'category',
            'category_id' => $categoryId,
        ], $this->config);
        if (isset($page) && isset($maxPage)) {
            $params = array_merge([
                'page' => $page,
                'max_page' => $maxPage,
            ], $params);
        }
        $uri = self::PREFIX_URL . http_build_query($params);
        $response = $this->client->request(
            'GET',
            $uri,
            [
                'http_errors' => false,
                'verify' => false,
            ]
        );
        return new RainForestApiResponse($response);
    }
}
