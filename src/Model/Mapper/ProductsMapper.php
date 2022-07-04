<?php declare(strict_types=1);

namespace Shop\Model\Mapper;

use Shop\Model\Dto\ProductDataTransferObject;

class ProductsMapper
{
    public function mapToDto(array $product): ProductDataTransferObject
    {
        return new ProductDataTransferObject(
            $product['id'],
            $product['name'],
            $product['size'],
            $product['category'],
            $product['price'],
            $product['amount']
        );
    }
}