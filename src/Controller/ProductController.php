<?php declare(strict_types=1);

namespace Controller;

use Core\View;
use Model\Product;

class ProductController implements BasicController
{
    private const TPL = 'DetailView.tpl';

    private Product $activeProduct;

    private string $output = '<span style="color: brown">Produkt</span><p>';

    private array $collection = [];


    public function __construct()
    {
        global $productCollection;
        $request = $_REQUEST;

        foreach ($productCollection as $id => $product) {
            if (empty($product)) {
                continue;
            }
            $this->collection[$id] = new Product($id, $product['name'], $product['size'], $product['category'], (float) $product['price']);
        }

        $this->activeProduct = $this->collection[(int)($request['id'] ?? 0)] ??
            new Product(0, 'none', 'none', 'none', 0.0);

        $this->build();
    }

    public function view():void
    {
        $renderer = new View();
        $renderer->addTemplateParameter($this->output, 'output');
        $renderer->display(self::TPL);
    }

    private function build():void
    {
        global $productCollection;

        if ($this->activeProduct->getId()) {
            foreach ($this->activeProduct->summarize() as $key => $value) {
                $this->output .= "$key: $value<br/>";
            }
            $this->output .= 'Anzahl: ' . $productCollection[$this->activeProduct->getId()]['amount'] . '</p>';
        }
    }
}