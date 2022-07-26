<?php

namespace App\Services\ConditionExtract;

use App\Services\Magento\MagentoClient;
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
    public function execute(): void
    {
        $categoryIds = config('category.category_id');
        collect($categoryIds)->map(function (string $categoryId) {
            $response = $this->rainForestClient->getCategory($categoryId);
            $content = $response->getContents();
            $this->executeProduct($content);
            $totalPage = Arr::get($content, 'pagination.total_pages');
            $maxPage = 1;
            while (isset($totalPage) && $maxPage < $totalPage) {
                $currentPage = $maxPage + 1;
                $maxPage += 5;
                if ($maxPage > $totalPage) {
                    $maxPage = $totalPage;
                }
                $response = $this->rainForestClient->getCategory($categoryId, $currentPage, $maxPage);
                $content = $response->getContents();
                $this->executeProduct($content);
            }
        });
    }

    private function executeProduct(array $content): void
    {
        $categoryResult = Arr::get($content, 'category_results');
        if (isset($categoryResult)) {
            collect($categoryResult)->map(function (array $category) {
                $asin = Arr::get($category, 'asin');
                if (isset($asin)) {
                    $response = $this->rainForestClient->getProduct($asin);
                    $content = $response->getContents();
                    $product = Arr::get($content, 'product');
                }
            });
        }
    }
}
