<?php

namespace App\Services\ConditionExtract;

use App\Services\Magento\MagentoClient;
use App\Services\Magento\Product;
use App\Services\RainForest\RainForestApiException;
use App\Services\RainForest\RainForestClient;
use Illuminate\Support\Arr;

class ConditionExtractService
{
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
        $response = $this->rainForestClient->getProductByUrl($url);
        $productAmazon = $response->getProduct();
        if ($productAmazon) {
            $product = new Product();
            $product->sku = $productAmazon['asin'];
            $product->name = $productAmazon['title'];
            $product->price = $productAmazon['buybox_winner']['price']['value'];
            $product->status = 1;
            $product->typeId = 'configurable';
            $product->attributeSetId = 1;
            $product->customAttributes = [
                'branch' => $productAmazon['brand'],
                'variants' => $productAmazon['variants'],
                'description' => $productAmazon['description'],
                'attributes' => $productAmazon['attributes'],
                'about_this_item' => $product['feature_bullets'],
                'important_information' => $productAmazon['important_information'],
                'protection_plans' => $productAmazon['protection_plans'],
                'add_an_accessory' => $productAmazon['add_an_accessory'],
                'specifications' => $productAmazon['specifications'],
                'more_buying_choices' => $productAmazon['more_buying_choices'],
                'frequently_bought_together' => $productAmazon['frequently_bought_together'],
                'also_bought' => $productAmazon['also_bought'],
            ];
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
