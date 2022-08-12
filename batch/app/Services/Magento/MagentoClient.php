<?php

namespace App\Services\Magento;

use App\Utility\DataConverter;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class MagentoClient
{
    /**
     * @var Client $client
     */
    private Client $client;
    private string $token;
    private array $storeCodes;
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
        $this->storeCodes = (array) config('magento.store_code');
    }

    public function createProduct(Product $product): void
    {
        $params = $product->toArray();
        $params['product'] = array_filter($params['product']);
        collect($this->storeCodes)->map(function (string $storeCode) use ($params) {
            $path = str_replace('{store_code}', $storeCode, $this->params['createPath']);
            $this->client->request(
                'POST',
                $path,
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
        });
        // Log::channel('daily')->info($response->getBody()->getContents());
        // return new MagentoApiResponse($response);
    }

    public function addImage(string $sku, string $imageUrl)
    {
        $contents = $this->getImageByPath($imageUrl);
        $dataBase64 = DataConverter::convertDataBase64($contents);
        $mimeType = DataConverter::getMimeType($contents);
        $fileName = basename($imageUrl);
        $image = new Image();
        $image->mediaType = 'image';
        $image->label = 'label image';
        $image->position = 1;
        $image->disabled = false;
        $image->types = [
            'image',
            'small_image',
            'thumbnail',
        ];
        $image->content = [
            'base64_encoded_data' => $dataBase64,
            'type' => $mimeType,
            'name' => $fileName,
        ];
        $image->file = $fileName;
        $uri = str_replace('{sku}', $sku, $this->params['imagePath']);

        collect($this->storeCodes)->map(function (string $storeCode) use ($uri,$image) {
            $path = str_replace('{store_code}', $storeCode, $uri);
            $this->client->request(
                'POST',
                $path,
                [
                    'json' => $image->toArray(),
                    'http_errors' => false,
                    'verify' => false,
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Authorization' => 'Bearer ' . $this->token
                    ],
                ]
            );
        });
    }

    private function getImageByPath(string $path): string
    {
        $httpClient = new Client();
        $response = $httpClient->request(
            'GET',
            $path,
            [
                'stream' => true,
                'verify' => false,
                'http_errors' => false, // エラー時に例外に変換しない
            ]
        );
        $contents = $response->getBody()->getContents();

        if ($response->getStatusCode() !== 200) {
            throw new MagentoApiException($contents);
        }

        return $contents;
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
