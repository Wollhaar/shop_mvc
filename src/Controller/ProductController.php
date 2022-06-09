<?php declare(strict_types=1);

namespace Controller;

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

    private int $activeId = 0;
    private string $output = self::page . '<br/><br/>';

    public array $collection = [];


    public function __construct()
    {
        $request = $_REQUEST;
        $this->activeId = (int) ($request['id'] ?? 0);

        foreach (self::products as $id => $product) {
            if (empty($product)) {
                continue;
            }
            $this->collection[$id] = new Product($id, $product['name'], $product['size'], $product['category'], (float) $product['price']);
        }
    }

    public function build():void
    {
        $product = $this->collection[$this->activeId] ?? new Product(0, 'none', 'none', 'none', 0.0);
        $exist = (bool) $product->getId();

        if ($exist) {
            foreach ($product->summarize() as $key => $value) {
                $this->output .= "$key: $value<br/>";
            }
        }
        else {
            foreach ($this->collection as $content) {
                $this->output .= '<a href="?page=' . self::page . '&id=' . $content->getId() . '">' . $content->getName() . '</a><br/>';
            }
        }
    }

    public function view():void
    {
        $this->build();
        $test = $this->output;

        include ROOT_PATH . '/src/View/home.php';
    }
}