<?php

namespace App\Services\Magento;

use App\Services\RainForest\MagentoApiResponse;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class MagentoClient
{
    /**
     * @var Client $client
     */
    private Client $client;
    private string $token;
    /**
     * MagentoClient constructor.
     * @param Client $client
     */
    public function __construct(
        Client $client,
        array $params
    ) {
        $this->client = $client;
        $this->params = $params;
        $this->token = '';
    }

    public function createProduct(Product $product)
    {
        $params = array_filter($product->toArray());
        Log::info(json_encode($params, JSON_UNESCAPED_UNICODE));
        $response = $this->client->request(
            'POST',
            $this->params['createPath'],
            [
                'json' => $params,
                'http_errors' => false,
                'verify' => false,
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $this->token
                ],
            ]
        );
        Log::channel('daily')->info($response->getBody()->getContents());
        return new MagentoApiResponse($response);
    }

    public function login(): void
    {

        $response = $this->client->request(
            'POST',
            $this->params['loginPath'],
            [
                'json' =>  $this->params['bodyLogin'],
                'http_errors' => false,
                'verify' => false,
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
            ]
        );
        $this->token = str_replace(
            '"',
            '',
            $response->getBody()->getContents()
        );
        if ($response->getStatusCode() !== 200) {
            throw new MagentoApiException($this->token);
        }
    }
}
