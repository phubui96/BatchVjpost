<?php

namespace App\Services\Magento;

class Category
{
    private array $availableSortBy;
    private string $children;
    private array $customAttributes;
    private array $extensionAttributes;
    private int $id;
    private bool $includeInMenu;
    private bool $isActive;
    private int $level;
    private string $name;
    private int $parentId;
    private string $path;
    private string $position;

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'isActive' => true,
            'parent_id' => $this->parentId,
            'path' => $this->path,
            'include_in_menu' => $this->includeInMenu,
            
        ];
    }
}
