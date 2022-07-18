<?php declare(strict_types=1);

namespace Shop\Model\Mapper;

use Shop\Model\Dto\CategoryDataTransferObject;

class CategoriesMapper
{
    public function mapToDto(array $category): CategoryDataTransferObject
    {
        return new CategoryDataTransferObject($category['id'] ?? 0, $category['name'] ?? 'All');
    }
}