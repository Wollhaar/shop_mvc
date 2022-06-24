<?php declare(strict_types=1);

namespace Shop\Model;

use Shop\Controller\ErrorController;

class Product implements Data
{
    private const PRODUCTS = array(
        1 => [
            'id' => 1,
            'name' => 'shirt no.1',
            'size' => 'L',
            'category' => 'T-Shirt',
            'price' => 20,
            'amount' => 200,
        ],
        2 => [
            'id' => 2,
            'name' => 'HSV - Home-Jersey',
            'size' => 'M',
            'category' => 'Sportswear',
            'price' => 80.90,
            'amount' => 200,
        ],
        3 => [
            'id' => 3,
            'name' => 'Hoodie - Kapuzenpulli',
            'size' => 'L',
            'category' => 'Pullover',
            'price' => 30,
            'amount' => 30,
        ],
        4 => [
            'id' => 4,
            'name' => 'Denim',
            'size' => 'W:32 L:32',
            'category' => 'Hosen',
            'price' => 45,
            'amount' => 100,
        ],
        5 => [
            'id' => 5,
            'name' => 'Bandshirt - Outkast',
            'size' => 'M',
            'category' => 'T-Shirt',
            'price' => 5.90,
            'amount' => 50,
        ],
    );

    private int $id = 0;
    private string $name = '';
    private string $size = '';
    private string $category = '';
    private float $price = 0.0;


    public function __construct(int $id = 0, string $name = 'none', string $size = 'none', string $category = 'none', float $price = 0.0)
    {
        $this->id = $id;
        if ($id < 1 || $id > count(self::PRODUCTS)) {
            $this->name = $name;
            $this->size = $size;
            $this->category = $category;
            $this->price = $price;
            return;
        }

        $this->name = self::PRODUCTS[$id]['name'];
        $this->size = self::PRODUCTS[$id]['size'];
        $this->category = self::PRODUCTS[$id]['category'];
        $this->price = self::PRODUCTS[$id]['price'];
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getSize(): string
    {
        return $this->size;
    }

    /**
     * @return string
     */
    public function getCategory(): string
    {
        return $this->category;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    public function getAll(): array
    {
        return self::PRODUCTS;
    }
}