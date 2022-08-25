<?php declare(strict_types=1);

namespace Shop\Model\Mapper;

use Shop\Model\Dto\ProductDataTransferObject;
use Shop\Model\Entity\Product;

class ProductsMapper
{
    public function mapToDto(array $product): ProductDataTransferObject
    {
        return new ProductDataTransferObject(
            $product['id'],
            $product['name'],
            $product['size'],
            $product['color'],
            $product['category'],
            $product['price'],
            $product['amount'],
            $product['active']
        );
    }

    public function mapEntityToDto(Product $product): ProductDataTransferObject
    {
        return new ProductDataTransferObject(
            $product->id,
            $product->name,
            $product->size,
            $product->color,
            $product->category->name,
            $product->price,
            $product->amount,
            $product->active
        );
    }
}