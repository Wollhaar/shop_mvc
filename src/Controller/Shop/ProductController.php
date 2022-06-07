<?php declare(strict_types=1);

namespace Controller\Shop;

use Model\Shop\Product;
use View\Engine\Response;

class ProductController
{
    private const page = 'detail';

    private const products = array(
        1 => [
            'name' => 'shirt no.1',
            'size' => 'L',
            'category' => 'T-Shirt',
            'price' => 20,
            'amount' => 200,
        ],
        2 => [
            'name' => 'HSV - Home-Jersey',
            'size' => 'M',
            'category' => 'Sportswear',
            'price' => 80.90,
            'amount' => 200,
        ],
        3 => [
            'name' => 'Hoodie - Kapuzenpulli',
            'size' => 'L',
            'category' => 'Pullover',
            'price' => 30,
            'amount' => 30,
        ],
        4 => [
            'name' => 'Denim',
            'size' => 'W:32 L:32',
            'category' => 'Hosen',
            'price' => 45,
            'amount' => 100,
        ],
        5 => [
            'name' => 'Bandshirt - Outkast',
            'size' => 'M',
            'category' => 'T-Shirt',
            'price' => 5.90,
            'amount' => 50,
        ],
    );

    public $collection = [];


    public function __construct()
    {
        foreach (self::products as $id => $product) {
            if (empty($product)) {
                continue;
            }
            $this->collection[] = new Product((int) $id, $product['name'], $product['size'], $product['category'], (float) $product['price']);
        }
    }

    public function view():Response
    {
        return new Response('detail');
    }

    public function getById(int $id): Product
    {

        foreach ($this->collection as $product) {
            if ($product->getId() === $id) {
                return $product;
            }
        }

        return new Product(0, 'none', 'none', 'none', 0.0);
    }
}