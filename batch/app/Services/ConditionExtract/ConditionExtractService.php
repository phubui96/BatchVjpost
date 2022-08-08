<?php

namespace App\Services\ConditionExtract;

use App\Services\Magento\MagentoClient;
use App\Services\Magento\Product;
use App\Services\RainForest\RainForestClient;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ConditionExtractService
{
    private const ATTRIBUTE_KEY = [
        'branch',
        'variants',
        'description',
        'attributes',
        'about_this_item',
        'important_information',
        'protection_plans',
        'add_an_accessory',
        'specifications',
        'more_buying_choices',
        'frequently_bought_together',
        'also_bought',
    ];
    private RainForestClient $rainForestClient;
    private MagentoClient $magentoClient;
    public function __construct(
        RainForestClient $rainForestClient,
        MagentoClient $magentoClient
    ) {
        $this->rainForestClient = $rainForestClient;
        $this->magentoClient = $magentoClient;
    }

    public function executeTest(): void
    {
        $productUrls = (array) config('product.urls');
        collect($productUrls)->map(function (string $url) {
            $this->executeProduct($url);
        });
    }

    private function executeProduct(string $url): void
    {

        try {
            $response = $this->rainForestClient->getProductByUrl($url);
            $productAmazon = $response->getProduct();
            $this->magentoClient->login();
            #$productAmazon = json_decode(Storage::disk('local')->get('test.json'), true);
            if ($productAmazon) {
                $product = new Product();
                $product->sku = $productAmazon['asin'];
                $product->name = $productAmazon['title'];
                $product->price = $productAmazon['buybox_winner']['price']['value'] ?? null;
                $product->status = 1;
                $product->typeId = 'simple';
                $product->attributeSetId = 4;
                $product->weight = $productAmazon['buybox_winner']['weight'] ?? null;
                $product->visibility = 4;
                $customAttributes = null;
                collect(self::ATTRIBUTE_KEY)->each(
                    function (string $key) use (&$customAttributes, $productAmazon) {
                        if (isset($productAmazon[$key])) {
                            $value = is_array($productAmazon[$key]) ? json_encode(
                                $productAmazon[$key],
                                JSON_UNESCAPED_UNICODE
                            ) : (string) $productAmazon[$key];
                            $customAttributes[] = [
                                'attribute_code' => $key,
                                'value' => $value,
                            ];
                        }
                    }
                );
                $product->customAttributes = $customAttributes;
                $product->extensionAttributes = [
                    'category_links' => [
                        [
                            'category_id' => 3,
                            'position' => 0,
                        ],
                    ],
                ];
                $this->magentoClient->createProduct($product);
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }

    // public function execute(): void
    // {
    //     $categoryIds = config('category.category_id');
    //     collect($categoryIds)->map(function (string $categoryId) {
    //         $response = $this->rainForestClient->getCategory($categoryId);
    //         $maxPage = 1;
    //         while (isset($totalPage) && $maxPage < $totalPage) {
    //             $currentPage = $maxPage + 1;
    //             $maxPage += 5;
    //             if ($maxPage > $totalPage) {
    //                 $maxPage = $totalPage;
    //             }
    //             $response = $this->rainForestClient->getCategory($categoryId, $currentPage, $maxPage);
    //         }
    //     });
    // }
}
