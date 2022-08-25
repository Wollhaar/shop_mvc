<?php declare(strict_types=1);

namespace Shop\Model\Mapper;

use Shop\Model\Dto\CategoryDataTransferObject;
use Shop\Model\Entity\Category;

class CategoriesMapper
{
    public function mapToDto(array $category): CategoryDataTransferObject
    {
        return new CategoryDataTransferObject($category['id'], $category['name'], $category['active']);
    }

    public function mapEntityToDto(Category $category): CategoryDataTransferObject
    {
        return new CategoryDataTransferObject($category->id, $category->name, $category->active);
    }
}