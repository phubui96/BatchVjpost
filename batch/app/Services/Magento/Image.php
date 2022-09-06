<?php

namespace App\Services\Magento;

/**
 * Class Image
 * @package App\Services\Magento
 * @property string $mediaType
 * @property string $label
 * @property int $position
 * @property bool $disabled
 * @property array $types
 * @property array $content
 * @property string $file
 */
class Image
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
            [
                'media_type' => $this->mediaType,
                'label' => $this->label,
                'position' => $this->position,
                'disabled' => $this->disabled,
                'types' => $this->types,
                'content' => $this->content,
                'file' => $this->file,
            ],
        ];
    }
}
