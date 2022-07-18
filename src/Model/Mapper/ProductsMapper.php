<?php declare(strict_types=1);

namespace Shop\Model\Mapper;

use Shop\Model\Dto\ProductDataTransferObject;

class ProductsMapper
{
    public function mapToDto(array $product): ProductDataTransferObject
    {
        return new ProductDataTransferObject(
            $product['id'] ?? 0,
            $product['name'] ?? 'none',
            $product['size'] ?? 'none',
            $product['category'] ?? 'none',
            $product['price'] ?? 0.0,
            $product['amount'] ?? 0,
            $product['active'] ?? false
        );
    }
}