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
 * @property string $weight
 * @property array $extensionAttributes
 * @property array $customAttributes
 * @property array $mediaGalleryEntries
 * @property array $options
 * @property array $productLinks
 * @property array $tierPrices
 */
class Product
{
    private array $data = [];

    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }
    public function __get($name)
    {
        if (!array_key_exists($name, $this->data)) {
            return null;
        }
        return $this->data[$name];
    }
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
