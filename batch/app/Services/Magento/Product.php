<?php

namespace App\Services\Magento;

/**
 * Class Product
 * @package App\Services\Magento
 * @property string $sku
 * @property string $name
 * @property int $attributeSetId
 * @property float $price
 * @property int $status
 * @property int $visibility
 * @property string $typeId
 * @property float $weight
 * @property array $extensionAttributes
 * @property array $customAttributes
 * @property array $mediaGalleryEntries
 * @property array $options
 * @property array $productLinks
 * @property array $tierPrices
 */
class Product
{
    private string $sku;
    private string $name;
    private int $attributeSetId;
    private float $price;
    private int $status;
    private int $visibility;
    private string $typeId;
    private float $weight;
    private array $extensionAttributes;
    private array $customAttributes;
    private array $mediaGalleryEntries;
    private array $options;
    private array $productLinks;
    private array $tierPrices;
    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'product' => [
                'sku' => $this->sku,
                'name' => $this->name,
                'attribute_set_id' => $this->attributeSetId,
                'price' => $this->price,
                'status' => $this->status,
                'visibility' => $this->visibility,
                'type_id' => $this->typeId,
                'weight' => $this->weight,
                'extension_attributes' => $this->extensionAttributes,
                'product_links' => $this->productLinks,
                'options' => $this->options,
                'media_gallery_entries' => $this->mediaGalleryEntries,
                'tier_prices' => $this->tierPrices,
                'custom_attributes' => $this->customAttributes,
            ],
        ];
    }
}
