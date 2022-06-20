<?php declare(strict_types=1);

namespace Shop\Model;

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

    public function __construct(int $id = 0, string $name = '', string $size = '', string $category ='', float $price = 0.0)
    {
        $this->id = $id;
        if ($id === 0) {
            return;
        }

        $this->name = self::PRODUCTS[$id]['name'] ?? $name;
        $this->size = self::PRODUCTS[$id]['size'] ?? $size;
        $this->category = self::PRODUCTS[$id]['category'] ?? $category;
        $this->price = self::PRODUCTS[$id]['price'] ?? $price;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getSize(): string
    {
        return $this->size;
    }

    /**
     * @param string $size
     */
    public function setSize(string $size): void
    {
        $this->size = $size;
    }

    /**
     * @return string
     */
    public function getCategory(): string
    {
        return $this->category;
    }

    /**
     * @param string $category
     */
    public function setCategory(string $category): void
    {
        $this->category = $category;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    public function summarize():array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'size' => $this->size,
            'category' => $this->category,
            'price' => $this->price
        ];
    }

    public function getAll(): array
    {
        return self::PRODUCTS;
    }
}